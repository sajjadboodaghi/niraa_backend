<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['item_id']) && isset($_POST['new_place'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $itemId = $_POST['item_id'];
        $newPlace = $_POST['new_place'];
        
        if(!isAdmin($conn, $username, $password)) {
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $updateQuery = 'UPDATE items SET place = :new_place WHERE id = :item_id;';
            $updateSth = $conn->prepare($updateQuery);
            $updateResult = $updateSth->execute([
                ':item_id' => $itemId,
                ':new_place' => $newPlace
            ]);
            if($updateResult) {
                $response['error'] = false;
                $response['message'] = "مکان جدید برای آگهی تعیین شده ثبت شد.";
            } else {
                $response['error'] = true;
                $response['message'] = "مشکلی در ثبت مکان جدید به وجود آمده است!";
            }
            
        }
        
    } else {
        $response['error'] = true;
        $response['message'] = "اطلاعات مورد نیاز ارسال نشده است!";
    }
    
} else {
    $response['error'] = true;
    $response['message'] = "درخواست نامعتبر است!";
}

$conn = null;

echo json_encode($response);

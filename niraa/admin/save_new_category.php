<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['item_id']) && isset($_POST['new_subcat_name']) && isset($_POST['new_subcat_id'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $itemId = $_POST['item_id'];
        $newSubcatName = $_POST['new_subcat_name'];
        $newSubcatId = $_POST['new_subcat_id'];
        
        if(!isAdmin($conn, $username, $password)) {
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $updateQuery = 'UPDATE items SET subcat_name = :new_subcat_name, subcat_id = :new_subcat_id WHERE id = :item_id;';
            $updateSth = $conn->prepare($updateQuery);
            $updateResult = $updateSth->execute([
                ':item_id' => $itemId,
                ':new_subcat_name' => $newSubcatName,
                ':new_subcat_id' => $newSubcatId
            ]);
            if($updateResult) {
                $response['error'] = false;
                $response['message'] = "دسته جدید برای آگهی تعیین شده ثبت شد.";
            } else {
                $response['error'] = true;
                $response['message'] = "مشکلی در ثبت دسته جدید به وجود آمده است!";
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

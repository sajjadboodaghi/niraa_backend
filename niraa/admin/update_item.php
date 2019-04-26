<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) &&
         isset($_POST['item_id']) && isset($_POST['item_title']) &&
        isset($_POST['item_description']) && isset($_POST['item_price'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $itemId = $_POST['item_id'];
        $itemTitle = $_POST['item_title'];
        $itemDescription = $_POST['item_description'];
        $itemPrice = $_POST['item_price'];

        if(!isAdmin($conn, $username, $password)) {  
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $updateQuery = 'UPDATE items SET title = :item_title, description = :item_description, price = :item_price WHERE id = :item_id;';
            $updateSth = $conn->prepare($updateQuery);
            $updateResult = $updateSth->execute([
                        ':item_title' => $itemTitle,
                        ':item_description' => $itemDescription,
                        ':item_price' => $itemPrice,
                        ':item_id' => $itemId
                    ]);
            if($updateResult) {
                $response['error'] = false;
                $response['message'] = "ویرایش انجام شده ذخیره شد.";    
            } else {
                $response['error'] = true;
                $response['message'] = "مشکلی در ذخیره تغییرات به وجود آمده است!";
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

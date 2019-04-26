<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            $selectImageNameQuery = 'SELECT `image_name` FROM `users` WHERE `phone_number` = :phone_number;';
            $selectImageNameSth = $conn->prepare($selectImageNameQuery );
            $selectImageNameSth ->execute([
                ':phone_number' => $phoneNumber
            ]);
                
            $previousImageName = $selectImageNameSth->fetch(PDO::FETCH_ASSOC)['image_name'];
            
            $imageName = "default.jpg";
            $updateQuery = 'UPDATE `users` SET `image_name` = :image_name WHERE `phone_number` = :phone_number;';
            $updateSth = $conn->prepare($updateQuery );
            $result = $updateSth ->execute([
                    ':image_name' => $imageName,
                    ':phone_number' => $phoneNumber
                ]);

            if($result) {  
                $upload_user_image_directory = "../users_images/";                  
                if($previousImageName != "default.jpg") {
                    $previousImageNamePath = $upload_user_image_directory . $previousImageName;
                    unlink($previousImageNamePath);
                }
           
                $response['error'] = false;
                $response['message'] = 'تصویر کاربری حذف شد';
                $response['image_name'] = $imageName;
                
            } else {
                $response['error'] = true;
                $response['message'] = 'متأسفانه مشکلی در حذف تصویر کاربری به وجود آمد!';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'اطلاعات کاربری داده شده معتبر نیست!';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات کاربری ارسال نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];
        $imageName = $phoneNumber . "_" . time() . ".jpg";

        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['user_image'])) {
                $selectImageNameQuery = 'SELECT `image_name` FROM `users` WHERE `phone_number` = :phone_number;';
                $selectImageNameSth = $conn->prepare($selectImageNameQuery );
                $selectImageNameSth ->execute([
                    ':phone_number' => $phoneNumber
                ]);
                
                $previousImageName = $selectImageNameSth->fetch(PDO::FETCH_ASSOC)['image_name'];

                $updateQuery = 'UPDATE `users` SET `image_name` = :image_name WHERE `phone_number` = :phone_number;';
                $updateSth = $conn->prepare($updateQuery );
                $result = $updateSth ->execute([
                        ':image_name' => $imageName,
                        ':phone_number' => $phoneNumber
                    ]);
                if($result) {  
                    $upload_user_image_directory = "../users_images/";                  
                    $userImage= $_POST['user_image'];
                    $user_image_path = $upload_user_image_directory . $imageName;

                    file_put_contents($user_image_path, base64_decode($userImage));

                    if($previousImageName != "default.jpg") {
                        $previousImageNamePath = $upload_user_image_directory . $previousImageName;
                        unlink($previousImageNamePath);
                    }

                       
                    $response['error'] = false;
                    $response['message'] = 'تصویر کاربری تغییر کرد';
                    $response['image_name'] = $imageName;
                } else {
                    $response['error'] = true;
                    $response['message'] = 'متأسفانه مشکلی در بارگذاری تصویر به وجود آمد!';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'تصویر ارسال نشده است!';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'اطلاعات کاربری داده شده معتبر نیست!';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات کاربری داده نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

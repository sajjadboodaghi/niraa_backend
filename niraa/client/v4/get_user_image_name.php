<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];
        
        if(userExists($conn, $phoneNumber, $token)) {
            $selectUserInfoQuery = 'SELECT `name`,`image_name` FROM `users` WHERE `phone_number` = :phone_number;';
            $selectUserInfoSth = $conn->prepare($selectUserInfoQuery );
            $selectUserInfoSth->execute([
                ':phone_number' => $phoneNumber
            ]);
            $infoArray = $selectUserInfoSth->fetch(PDO::FETCH_ASSOC);
   
            if(!empty($infoArray)) {
                $response['error'] = false;
                $response['user_name'] = $infoArray['name'];
                $response['image_name'] = $infoArray['image_name'];
            } else {
                $response['error'] = true;
                $response['message'] = "متأسفانه مشکلی در دریافت اطلاعات کاربری به وجود آمد!";
            }
        } else {
                $response['error'] = true;
                $response['message'] = "کاربری با مشخصات ارسال شده پیدا نشد!";
        }
       
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم ارسال نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

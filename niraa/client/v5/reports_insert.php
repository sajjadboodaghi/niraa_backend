<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['description']) && isset($_POST['item_id'])) {
                $description = $_POST['description'];
                $itemId = $_POST['item_id'];
                if(trim($description, ' ') != "") {
                    $insertQuery = 'INSERT INTO `reports` (`reporter_number`, `item_id` , `description`) VALUES (:reporter_number, :item_id, :description);';
                    $insertSth = $conn->prepare($insertQuery);
                    $result = $insertSth->execute([
                        ':reporter_number' => $phoneNumber,
                        ':item_id' => $itemId,
                        ':description' => $description,
                    ]);
                    if($result) {
                        $response['error'] = false;
                        $response['message'] = 'گزارش شما با موفقیت ارسال شد. از شما بسیار سپاسگزاریم.';
                    } else {
                        $response['error'] = true;
                        $response['message'] = 'متأسفانه مشکلی در ثبت گزارش به وجود آمد!';
                    }    
                } else {
                    $response['error'] = true;
                    $response['message'] = 'بخش توضیحات نمیتوانند خالی رها شوند!';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'درج توضیحات و شناسه آگهی اجباری است!';
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

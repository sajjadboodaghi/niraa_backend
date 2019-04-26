<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['suggest'])) {
                $suggest = $_POST['suggest'];
                if(trim($suggest, ' ') != "") {
                    $insertQuery = 'INSERT INTO `suggests`(`phone_number`, `suggest`) VALUES (:phone_number, :suggest);';
                    $insertSth = $conn->prepare($insertQuery);
                    $result = $insertSth->execute([
                        ':phone_number' => $phoneNumber,
                        ':suggest' => $suggest
                    ]);
                    if($result) {
                        $response['error'] = false;
                        $response['message'] = 'توضیحات شما با موفقیت ارسال شد. از توجه شما بسیار سپاسگزاریم.';
                    } else {
                        $response['error'] = true;
                        $response['message'] = 'متأسفانه مشکلی در ثبت توضیحات شما به وجود آمد!';
                    }    
                } else {
                    $response['error'] = true;
                    $response['message'] = 'بخش توضیحات نمیتوانند خالی رها شوند!';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'درج توضیحات اجباری است!';
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

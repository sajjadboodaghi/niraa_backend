<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];
        
        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['description'])) {
                $niraaVersion   = $_POST['niraa_version'];
                $androidVersion = $_POST['android_version'];
                $description    = $_POST['description'];
                if(trim($description, ' ') != "") {
                    $insertQuery = 'INSERT INTO `suggests`(`phone_number`, `niraa_version`, `android_version`, `description`, `status`) VALUES (:phone_number, :niraa_version, :android_version, :description, :status);';
                    $insertSth = $conn->prepare($insertQuery);
                    $result = $insertSth->execute([
                        ':phone_number'    => $phoneNumber,
                        ':niraa_version'   => $niraaVersion,
                        ':android_version' => $androidVersion,
                        ':description'     => $description,
                        ':status'          => "unseen"
                    ]);
                    if($result) {
                        $response['error'] = false;
                        $response['message'] = 'توضیحات شما با موفقیت ارسال شد. از شما بسیار سپاسگزاریم.';
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

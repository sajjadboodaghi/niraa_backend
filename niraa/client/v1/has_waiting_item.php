<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'jdf.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'has_waiting_item_function.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber'])) {
        $phoneNumber = $_POST['phoneNumber'];

        if(!hasWaitingItem($conn, $phoneNumber)) {
            $response['error'] = false;
            $response['hasWaitingItem'] = false;
            $response['message'] = "مشکلی نیست";
        } else {
            $response['error'] = false;
            $response['hasWaitingItem'] = true;
            $response['message'] = "تا زمانی که آگهی قبلی شما تایید نشده است، نمی‌توانید آگهی جدید ثبت کنید!";
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

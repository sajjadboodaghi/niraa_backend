<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'jdf.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_waiting_items_count.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber'])) {
        $phoneNumber = $_POST['phoneNumber'];

        if(waitingItemsCount($conn, $phoneNumber) < 1) {
            $response['error'] = false;
            $response['hasTooManyWaitingItems'] = false;
            $response['message'] = "مشکلی نیست";
        } else {
            $response['error'] = false;
            $response['hasTooManyWaitingItems'] = true;
            $response['message'] = "نمی‌توانید در یک زمان دو آگهی تأیید نشده داشته باشید! لطفاً تا تأیید شدن آگهی قبلی صبر کنید.";
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

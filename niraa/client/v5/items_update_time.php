<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'jdf.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['item_id'])) {
        $itemId = $_POST['item_id'];
        $updateItemQuery = "UPDATE `items` SET shamsi = :shamsi, timestamp = :timestamp WHERE id = :item_id;";
        $updateItemSth = $conn->prepare($updateItemQuery);
        $updateItemResult = $updateItemSth->execute([
            ':shamsi' => jdate('y/m/d H:i'),
            ':timestamp' => time(),
            ':item_id' => $itemId
        ]);
                    
        if($updateItemResult) {
            $response['error'] = false;
            $response['message'] = 'آگهی با موفقیت تازه شد';
        } else {
            $response['error'] = true;
            $response['message'] = 'متأسفانه مشکلی در تازه کردن آگهی به وجود آمد!';
        }
                
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم برای تازه کردن آگهی ارسال نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

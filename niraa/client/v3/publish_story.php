<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['story_id'])) {
                $storyId = $_POST['story_id'];
         
                $updateStoryQuery = "UPDATE `stories` SET status = :status, timestamp = :timestamp WHERE id = :story_id AND phone_number = :phone_number;";
                $updateStorySth = $conn->prepare($updateStoryQuery);
                $updateStoryResult = $updateStorySth->execute([
                    ':status' => "published",
                    ':timestamp' => time(),
                    ':story_id' => $storyId,
                    ':phone_number' => $phoneNumber
                ]);
                    
                if($updateStoryResult) {
                    $response['error'] = false;
                    $response['message'] = 'تبلیغ با موفقیت منتشر شد';
                } else {
                    $response['error'] = true;
                    $response['message'] = 'متأسفانه مشکلی در انتشار تبلیغ به وجود آمد!';
                }
                
            } else {
                $response['error'] = true;
                $response['message'] = 'اطلاعات لازم برای انتشار تبلیغ داده نشده است!';
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

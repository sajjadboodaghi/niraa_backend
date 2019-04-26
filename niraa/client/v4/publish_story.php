<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['story_id'])) {
        $storyId = $_POST['story_id'];
        $updateStoryQuery = "UPDATE `stories` SET status = :status, timestamp = :timestamp WHERE id = :story_id;";
        $updateStorySth = $conn->prepare($updateStoryQuery);
        $updateStoryResult = $updateStorySth->execute([
            ':status' => "published",
            ':timestamp' => time(),
            ':story_id' => $storyId
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
        $response['message'] = 'اطلاعات لازم برای انتشار تبلیغ ارسال نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

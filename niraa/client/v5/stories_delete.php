<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];
        
        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['story_id'])) {
                $storyId = $_POST['story_id'];
                
                $deleteStoryQuery = 'DELETE FROM `stories` WHERE id = :story_id AND phone_number = :phone_number;';
                $deleteStorySth = $conn->prepare($deleteStoryQuery);
                $deleteStoryResult = $deleteStorySth->execute([
                    ':story_id' => $storyId,
                    ':phone_number' => $phoneNumber
                ]);
                    
                if($deleteStoryResult) {

                    $small_image = "../stories/small_" . $storyId. ".jpg";
                    unlink($small_image );
                        
                    $large_image = "../stories/large_" . $storyId. ".jpg";
                    unlink($large_image);

                    $response['error'] = false;
                    $response['message'] = 'حذف تبلیغ با موفقیت انجام شد';
                } else {
                    $response['error'] = true;
                    $response['message'] = 'متأسفانه مشکلی در حذف تبلیغ به وجود آمد!';
                }
                
            } else {
                $response['error'] = true;
                $response['message'] = 'اطلاعات لازم برای حذف تبلیغ داده نشده است!';
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

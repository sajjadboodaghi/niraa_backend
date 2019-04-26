<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['story_id'])) {
            
        $username = $_POST['username'];
        $password = $_POST['password'];
        $storyId = $_POST['story_id'];
        
        if(!isAdmin($conn, $username, $password)) {
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $deleteStoryQuery = 'DELETE FROM `stories` WHERE id = :story_id;';
            $deleteStorySth = $conn->prepare($deleteStoryQuery);
            $deleteStoryResult = $deleteStorySth->execute([
                    ':story_id' => $storyId
            ]);
            if($deleteStoryResult) {
                $small_image = "../client/stories/small_" . $storyId . ".jpg";
                unlink($small_image);
                
                $large_image = "../client/stories/large_" . $storyId . ".jpg";
                unlink($large_image);
                
                $response['error'] = false;
                $response['message'] = 'حذف تبلیغ با موفقیت انجام شد';
            } else {
                $response['error'] = true;
                $response['message'] = 'متأسفانه مشکلی در حذف تبلیغ به وجود آمد!';
            }
            
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم برای حذف تبلیغ داده نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

?>
<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];
        
        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['small_image']) && isset($_POST['large_image'])) {
                $insertStoryQuery = 'INSERT INTO `stories`(`phone_number`, `status`, `timestamp`) VALUES (:phone_number, :status, :timestamp);';
                $insertStorySth = $conn->prepare($insertStoryQuery);
                $result = $insertStorySth->execute([
                        ':phone_number' => $phoneNumber,
                        ':status' => "draft",
                        ':timestamp' => time()
                    ]);
                if($result) {
                    $id = $conn->lastInsertId();
                    $upload_story_directory = "../stories/";
                    
                    $smallImage = $_POST['small_image'];
                    $small_image_path = $upload_story_directory . "small_" . $id . ".jpg";
                    file_put_contents($small_image_path, base64_decode($smallImage));
                       
                    $largeImage = $_POST['large_image'];
                    $large_story_path = $upload_story_directory . "large_" . $id . ".jpg";
                    file_put_contents($large_story_path, base64_decode($largeImage));
                                           
                    $response['error'] = false;
                    $response['message'] = 'تبلیغ با موفقیت ثبت شد';
                    $response['story_id'] = $id;
                } else {
                    $response['error'] = true;
                    $response['message'] = 'متأسفانه مشکلی در ثبت تبلیغ به وجود آمد!';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'تصاویر مورد نیاز ارسال نشده است!';
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

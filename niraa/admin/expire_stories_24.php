<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if(!isAdmin($conn, $username, $password)) {
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            
            $updateStoriesQuery = "UPDATE `stories` SET status = :new_status WHERE timestamp < :specified_date AND status = :old_status;";
            $updateStoriesSth = $conn->prepare($updateStoriesQuery );
            $updateStoriesResult = $updateStoriesSth->execute([
                ':new_status' => "expired",
                ':old_status' => "published",
                ':specified_date' => time() - 24 * 60 * 60
            ]);
            
            if($updateStoriesResult) {                
                $response['error'] = false;
                $response['message'] = 'تبلیغات قبل از دیروز منقضی شدند';
            } else {
                $response['error'] = true;
                $response['message'] = 'متأسفانه مشکلی در انقضاء تبلیغات تاریخ‌گذشته به وجود آمد!';
            }
            
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم برای انتقضاء تبلیغات تاریخ‌گذشته داده نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

?>
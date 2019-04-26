<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['item_id'])
                && isset($_POST['item_phone_number']) && isset($_POST['item_title'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $itemId = $_POST['item_id'];

    
        if(!isAdmin($conn, $username, $password)) {   
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $updateQuery = 'UPDATE items SET verified = 1, timestamp = :timestamp WHERE id = :item_id;';
            $updateSth = $conn->prepare($updateQuery);
            $updateResult = $updateSth->execute([
                        ':timestamp' => time(),
                        ':item_id' => $itemId
                    ]);
            if($updateResult) {
                $itemPhoneNumber = $_POST['item_phone_number'];
                $itemTitle = $_POST['item_title'];

                $message = "آگهی شما با عنوان «" . $itemTitle . "» تایید و منتشر شد";

                $createNotificationQuery = 'INSERT INTO `notifications` (`phone_number`, `type`, `message`) VALUES (:phone_number, :type, :message);';
                $createNotificationSth = $conn->prepare($createNotificationQuery);
                $createNotificationSth->execute([
                        ':phone_number' => $itemPhoneNumber,
                        ':type' => 'item_verified',
                        ':message' => $message
                    ]);

                $response['error'] = false;
                $response['message'] = "آگهی با موفقیت تایید شد";    
            } else {
                $response['error'] = true;
                $response['message'] = "مشکلی در تایید آگهی به وجود آمده است!";
            }
            
        }        

    } else {
        $response['error'] = true;
        $response['message'] = "اطلاعات مورد نیاز ارسال نشده است!";
    }

} else {
    $response['error'] = true;
    $response['message'] = "درخواست نامعتبر است!";
}

$conn = null;

echo json_encode($response);

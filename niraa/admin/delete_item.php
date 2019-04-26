<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['item_id'])
        && isset($_POST['item_phone_number']) && isset($_POST['item_title']) && isset($_POST['message_for_user'])) {
            
            $username = $_POST['username'];
            $password = $_POST['password'];
            $itemId = $_POST['item_id'];
            $messageForUser = $_POST['message_for_user'];
            
            if(!isAdmin($conn, $username, $password)) {
                $response['error'] = true;
                $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
            } else {
                $findItemQuery = 'SELECT * FROM `items` WHERE id = :itemId';
                $findItemSth = $conn->prepare($findItemQuery);
                $findItemSth->execute([
                    ':itemId' => $itemId
                ]);

                $findItemResult = $findItemSth->fetch(PDO::FETCH_ASSOC);
                
                if(!empty($findItemResult)) {
                    $imageCount = $findItemResult['image_count'];
                    
                    $deleteQuery = 'DELETE FROM `items` WHERE id = :item_id;';
                    $deleteSth = $conn->prepare($deleteQuery);
                    $deleteResult = $deleteSth->execute([
                        ':item_id' => $itemId
                    ]);
                    if($deleteResult) {
                        if($imageCount > 0) {
                            $thumbnail_path = "../client/images/item_" . $itemId . "_thumbnail.jpg";
                            unlink($thumbnail_path);
                            
                            for($i = 0; $i < $imageCount; $i++) {
                                $image_path = "../client/images/item_" . $itemId . "_" . ($i+1) .".jpg";
                                unlink($image_path);
                            }
                        }
                        
                        $itemPhoneNumber = $_POST['item_phone_number'];
                        $itemTitle = $_POST['item_title'];
                        
                        $message = "آگهی شما با عنوان «" . $itemTitle . "» تایید نشد!\n";
                        $message .= $messageForUser;
                        
                        $createNotificationQuery = 'INSERT INTO `notifications` (`phone_number`, `type`, `message`) VALUES (:phone_number, :type, :message);';
                        $createNotificationSth = $conn->prepare($createNotificationQuery);
                        $createNotificationSth->execute([
                            ':phone_number' => $itemPhoneNumber,
                            ':type' => 'item_deleted',
                            ':message' => $message
                        ]);
                        
                        $response['error'] = false;
                        $response['message'] = "آگهی با موفقیت حذف شد";
                    } else {
                        $response['error'] = true;
                        $response['message'] = "مشکلی در حذف آگهی به وجود آمده است!";
                    }
                
                } else {
                    $response['error'] = false;
                    $response['message'] = "این آگهی قبلاً حذف شده بود!";
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

?>
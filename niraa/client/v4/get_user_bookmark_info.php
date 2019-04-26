<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['owner_phone_number'])) {
        $ownerPhoneNumber = $_POST['owner_phone_number'];
        
        $selectUserInfoQuery = 'SELECT `name`,`image_name` FROM `users` WHERE `phone_number` = :phone_number;';
        $selectUserInfoSth = $conn->prepare($selectUserInfoQuery );
        $selectUserInfoSth->execute([
            ':phone_number' => $ownerPhoneNumber
        ]);
        $infoArray = $selectUserInfoSth->fetch(PDO::FETCH_ASSOC);
        $response['error'] = false;
        $response['user_name'] = $infoArray['name'];
        $response['user_image_name'] = $infoArray['image_name'];

        if(isset($_POST['item_id']) && isset($_POST['loggedin_phone_number'])) {
            $itemId = $_POST['item_id'];
            $loggedinPhoneNumber = $_POST['loggedin_phone_number'];
        
            $findBookmarkQuery = 'SELECT `id` FROM `bookmarks` WHERE `item_id` = :item_id AND `phone_number` = :phone_number;';
            $findBookmarkSth = $conn->prepare($findBookmarkQuery);
            $findBookmarkSth->execute([
                ':item_id' => $itemId,
                ':phone_number' => $loggedinPhoneNumber
            ]);
            $findBookmarkResult = $findBookmarkSth->fetch(PDO::FETCH_ASSOC);
            if(empty($findBookmarkResult)) {
                $response['bookmarked'] = false;
            } else {
                $response['bookmarked'] = true;
            }
        }
        
        
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم ارسال نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);

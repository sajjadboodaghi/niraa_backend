<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['item_id'])) {
        $phoneNumber = $_POST['phone_number'];
        $itemId= $_POST['item_id'];
        
        $findBookmarkQuery = 'SELECT id FROM `bookmarks` WHERE `phone_number` = :phone_number AND `item_id` = :item_id;';
        $findBookmarkSth = $conn->prepare($findBookmarkQuery);
        $findBookmarkSth->execute([
            ':phone_number' => $phoneNumber,
            ':item_id' => $itemId,
        ]);
        
        $result = $findBookmarkSth->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) {
            // bookmark
            $bookmarkQuery = 'INSERT INTO `bookmarks` (`item_id`, `phone_number`) VALUES (:item_id, :phone_number);';
            $bookmarkSth = $conn->prepare($bookmarkQuery);
            $bookmarkResult = $bookmarkSth->execute([
                ':item_id' => $itemId,
                ':phone_number' => $phoneNumber
            ]);
            if($bookmarkResult) {
                $response['error'] = false;
                $response['status'] = "bookmarked";
                $response['message'] = "نشان شد";
            } else {
                $response['error'] = true;
                $response['message'] = "متأسفانه مشکلی در نشان کردن آگهی به وجود آمد!";
            }
        } else {
            // unbookmark
            $unbookmarkQuery = 'DELETE FROM `bookmarks` WHERE `item_id` = :item_id AND `phone_number` = :phone_number;';
            $unbookmarkSth = $conn->prepare($unbookmarkQuery);
            $unbookmarkResult = $unbookmarkSth->execute([
                ':item_id' => $itemId,
                ':phone_number' => $phoneNumber
            ]);
            if($unbookmarkResult) {
                $response['error'] = false;
                $response['status'] = "unbookmarked";
                $response['message'] = "نشان برداشته شد";
            } else {
                $response['error'] = true;
                $response['message'] = "متأسفانه مشکلی در حذف این آگهی از فهرست نشان‌های شما به وجود آمد!";
            }
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

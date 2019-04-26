<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';
$response = array();
$response["now_timestamp"] = time();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number'])) {
        $phoneNumber = $_POST['phone_number'];

        $getUserBookmarksQuery = 'SELECT items.* FROM items,bookmarks WHERE bookmarks.phone_number = :phone_number AND items.id = bookmarks.item_id ORDER BY bookmarks.created_at DESC';
        $getUserBookmarksSth = $conn->prepare($getUserBookmarksQuery);
        $getUserBookmarksSth->execute([
            ':phone_number' => $phoneNumber
        ]);

        $response['error'] = false;
        $response['bookmarks'] = $getUserBookmarksSth->fetchAll(PDO::FETCH_ASSOC);
        $response['now_timestamp'] = time();


    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم ارسال نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده نامعتبر است!';
}

$conn = null;

echo json_encode($response);

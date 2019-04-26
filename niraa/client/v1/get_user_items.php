<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            $getUserItemsQuery = 'SELECT * FROM `items` WHERE phone_number = :phoneNumber AND verified != 2 ORDER BY `timestamp` DESC;';
            $getUserItemsSth = $conn->prepare($getUserItemsQuery);
            $getUserItemsSth->execute([ ':phoneNumber' => $phoneNumber ]);
            $getUserItemsResult = $getUserItemsSth->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($getUserItemsResult)) {
                $response['error'] = false;
                $response['userItems'] = $getUserItemsResult;
            } else {
                $response['error'] = true;
                $response['message'] = 'هیچ آگهی‌ای برای نمایش وجود ندارد';
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

<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();
$response["now_timestamp"] = time();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            $getUserItemsQuery = 'SELECT * FROM `items` WHERE phone_number = :phoneNumber AND verified != 2 ORDER BY `verified` ASC, `timestamp` DESC;';
            $getUserItemsSth = $conn->prepare($getUserItemsQuery);
            $getUserItemsSth->execute([ ':phoneNumber' => $phoneNumber ]);

            $response['error'] = false;
            $response['userItems'] = $getUserItemsSth->fetchAll(PDO::FETCH_ASSOC);
            

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

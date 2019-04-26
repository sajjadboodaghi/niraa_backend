<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number'])) {
        $phone_number = $_POST['phone_number'];

        // get user notifications
        $getNotificationsQuery = 'SELECT * FROM notifications WHERE phone_number = :phone_number ORDER BY created_at DESC;';
        $getNotificationsSth = $conn->prepare($getNotificationsQuery);
        $getNotificationsSth->execute([':phone_number' => $phone_number]);
        $response['notifications'] = $getNotificationsSth->fetchAll(PDO::FETCH_ASSOC);
        $response['now_timestamp'] = time();

        // delete seen notifications
        $deleteNotificationsQuery = 'DELETE FROM notifications WHERE phone_number = :phone_number;';
        $deleteNotificationsSth = $conn->prepare($deleteNotificationsQuery);
        $deleteNotificationsSth->execute([':phone_number' => $phone_number]);
    }
}

$conn = null;
        
echo json_encode($response);

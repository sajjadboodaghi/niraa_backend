<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number'])) {
        $phone_number = $_POST['phone_number'];

        // get user notifications
        $getNotificationsQuery = 'SELECT * FROM notifications WHERE phone_number = :phone_number;';
        $getNotificationsSth = $conn->prepare($getNotificationsQuery);
        $getNotificationsSth->execute([':phone_number' => $phone_number]);
        $response = $getNotificationsSth->fetchAll(PDO::FETCH_ASSOC);

        // delete seen notifications
        $deleteNotificationsQuery = 'DELETE FROM notifications WHERE phone_number = :phone_number;';
        $deleteNotificationsSth = $conn->prepare($deleteNotificationsQuery);
        $deleteNotificationsSth->execute([':phone_number' => $phone_number]);
    }
}

$conn = null;
        
echo json_encode($response);

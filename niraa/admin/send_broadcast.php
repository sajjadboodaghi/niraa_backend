<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password'])
        && isset($_POST['broadcast_type']) && isset($_POST['broadcast_message'])) {
            
            $username = $_POST['username'];
            $password = $_POST['password'];
            $broadcastType = $_POST['broadcast_type'];
            $broadcastMessage = $_POST['broadcast_message'];
            
            if(!isAdmin($conn, $username, $password)) {
                $response['error'] = true;
                $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
            } else {
                $findUsersQuery = 'SELECT * FROM `users` WHERE status = :status';
                $findUsersSth = $conn->prepare($findUsersQuery);
                $findUsersSth->execute([
                    ':status' => "normal"
                ]);
                
                $users = $findUsersSth->fetchAll(PDO::FETCH_ASSOC);
                
                if(!empty($users)) {
                    foreach($users as $user) {
                        $createNotificationQuery = 'INSERT INTO `notifications` (`phone_number`, `type`, `message`) VALUES (:phone_number, :type, :message);';
                        $createNotificationSth = $conn->prepare($createNotificationQuery);
                        $createNotificationSth->execute([
                            ':phone_number' => $user['phone_number'],
                            ':type'         => $broadcastType,
                            ':message'      => $broadcastMessage
                        ]);
                    }
                                 
                    $response['error'] = false;
                    $response['message'] = "پیام شما برای کاربران ارسال شد";
                    
                } else {
                    $response['error'] = false;
                    $response['message'] = "هیچ کاربری پیدا نشد!!!";
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
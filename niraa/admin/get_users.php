<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if(!isAdmin($conn, $username, $password)) {
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            
            $getUsersQuery = "SELECT id, phone_number FROM users ORDER BY id DESC";
            $getUsersSth = $conn->prepare($getUsersQuery);
            $getUsersSth->execute();
            $users = $getUsersSth->fetchAll(PDO::FETCH_ASSOC);
            
            $response['error'] = false;
            $response['users'] = $users;
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
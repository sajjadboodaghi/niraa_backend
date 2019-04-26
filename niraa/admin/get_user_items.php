<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['phone_number'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phone_number'];

        if(!isAdmin($conn, $username, $password)) {  
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $getUserItemsQuery = 'SELECT * FROM `items` WHERE phone_number = :phone_number ORDER BY `timestamp` DESC ;';
            $getUserItemsSth = $conn->prepare($getUserItemsQuery);
            $getUserItemsSth->execute([
                        ':phone_number' => $phoneNumber
                    ]);
            $getUserItemsResult = $getUserItemsSth->fetchAll(PDO::FETCH_ASSOC);
            
                $response['error'] = false;
                $response['items'] = $getUserItemsResult;
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

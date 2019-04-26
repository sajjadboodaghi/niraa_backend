<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['phone_number']) && isset($_POST['name']) && isset($_POST['token'])) {        

        $name = $_POST['name'];
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {

            $updateQuery = 'UPDATE users SET name = :name WHERE phone_number = :phone_number;';
            $updateSth = $conn->prepare($updateQuery);
            $result = $updateSth ->execute([
                ':name'         => $name,
                ':phone_number' => $phoneNumber
            ]);

            $response['error'] = false;
            $response['message'] = "تغییر نام با موفقیت انجام شد";
            } else {
                $response['error'] = true;
                $response['message'] = 'اطلاعات کاربری داده شده معتبر نیست!';
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

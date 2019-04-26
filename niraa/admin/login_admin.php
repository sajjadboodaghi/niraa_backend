<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password'])) {

        $username = md5($_POST['username']);
        $password = md5($_POST['password']);

        if(!isAdmin($conn, $username, $password)) {  
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $response['error'] = false;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر است.";
        }

    } else {
        $response['error'] = true;
        $response['message'] = "وارد کردن نام کاربری و گذرواژه الزامی است!";
    }

} else {
    $response['error'] = true;
    $response['message'] = "درخواست نامعتبر است!";
}

$conn = null;

echo json_encode($response);

<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
$response = array();
$salt1 = "060509bd09a726f18ccd7f8574b52353";
$salt2 = "254bb964f62b2507c1ba812d28df226d";

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['phoneNumber'])) {

        $phoneNumber = $_POST['phoneNumber'];

        // make a fake token from time funtion value
        $fake_token = md5(time());

        // make main token by twice md5 generation
        $token = md5(md5($fake_token . $salt1) . $salt2);

        $selectQuery = 'SELECT * FROM users WHERE phone_number = :phoneNumber;';
        $selectSth = $conn->prepare($selectQuery);
        $selectSth->execute(array(':phoneNumber' => $phoneNumber));
        $selectResult = $selectSth->fetch(PDO::FETCH_ASSOC);

        if(empty($selectResult)) {
            $insertQuery = 'INSERT INTO users (phone_number, token) VALUES (:phoneNumber, :token);';
            $insertSth = $conn->prepare($insertQuery);
            $result = $insertSth->execute([':phoneNumber' => $phoneNumber, ':token' => $token]);
            $response['error'] = false;
            $response['message'] = "ثبت نام با موفقیت انجام شد";
            $response['token'] = $fake_token;
        } else {
            if($selectResult['status'] == 'normal') {
                $updateQuery = 'UPDATE users SET token = :token WHERE phone_number = :phoneNumber;';
                $updateSth = $conn->prepare($updateQuery);
                $result = $updateSth->execute([':token' => $token, ':phoneNumber' => $phoneNumber]);    
                if($result) {
                    $response['error'] = false;
                    $response['message'] = "ورود با موفقیت انجام شد";
                    $response['token'] = $fake_token;
                } else {
                    $response['error'] = true;
                    $response['message'] = "متأسفانه مشکلی در ورود به وجود آمده است!";
                }
            } else {
                    $response['error'] = true;
                    $response['message'] = "این شماره مسدود شده است!";
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

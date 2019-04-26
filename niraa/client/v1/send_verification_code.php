<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'jdf.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'SmsIR_UltraFastSend.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';

$response = array();
$response['errorName'] = 'nothing';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber'])) {
        $phoneNumber = $_POST['phoneNumber'];
        
        if(!isUserBlocked($conn, $phoneNumber)) {
            
            try {
                date_default_timezone_set("Asia/Tehran");
                
                // your sms.ir panel configuration
                $APIKey = '495c05891ee0c8f65b47f90a';
                $SecretKey = 'uz0BC!@*&W313@1bit66)%#tei8*7&^%';
                
                $SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
                
                $verificationCode = makeVerificationCode();
                $data = prepareData($verificationCode, $phoneNumber);
                
                $UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
                $UltraFastSend['VerificationCode'] = $verificationCode;
                
                $response = $UltraFastSend;
                
            } catch (ErrorException $e) {
                $response["IsSuccessful"] = false;
                $response["errorName"] = "sending_error";
                $response["Message"] = 'Error UltraFastSend: ' . $e->getMessage();
            }
            
        } else {
            $response["IsSuccessful"] = false;
            $response["errorName"] = "user_is_blocked";
            $response["Message"] = "حساب کاربری شما مسدود شده است!";
        }
    } else {
        $response["IsSuccessful"] = false;
        $response["errorName"] = "no_phone_number";
        $response["Message"] = "شماره تلفن همراه ارسال نشده است!";
    }
} else {
    $response["IsSuccessful"] = false;
    $response["errorName"] = "wrong_method";
    $response["Message"] = "درخواست ارسال شده معتبر نیست!";
}

$conn = null;
echo json_encode($response);


function makeVerificationCode() {
    return rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
}

function prepareData($verificationCode, $phoneNumber) {    
    // رمز چهاررقمی برای تایید شماره تلفن در نیرا: [VerificationCode]
    $templateId = "3574";
    
    $data = array(
        "ParameterArray" => array(
            array(
                "Parameter" => "VerificationCode",
                "ParameterValue" => $verificationCode
            )
        ),
        "Mobile" => $phoneNumber,
        "TemplateId" => $templateId
    );
    
    return $data;
}
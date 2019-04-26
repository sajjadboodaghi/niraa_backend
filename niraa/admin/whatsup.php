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
            $response['error'] = false;
            $response['message'] = "";
            $suggestsCountQuery = "SELECT COUNT(id) FROM `suggests` WHERE `status` = 'unseen'";
            $suggestsCountSth = $conn->prepare($suggestsCountQuery);
            $suggestsCountSth->execute();
            $suggestsCount = $suggestsCountSth->fetchColumn();
            
            if($suggestsCount > 0) {
                $response['message'] .= "- پیشنهاد جدید (" . $suggestsCount . ")\n";
            }
            
            $reportsCountQuery = "SELECT COUNT(id) FROM `reports` WHERE `status` = 'unseen'";
            $reportsCountSth = $conn->prepare($reportsCountQuery);
            $reportsCountSth->execute();
            $reportsCount = $reportsCountSth->fetchColumn();
            if($reportsCount > 0) {
                $response['message'] .= "- گزارش تخلف (" . $reportsCount . ")"; 
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
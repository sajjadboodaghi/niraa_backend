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
            
		$getReportsQuery = "SELECT * FROM reports ORDER BY id DESC";
		$getReportsSth = $conn->prepare($getReportsQuery);
		$getReportsSth->execute();
		$items = $getReportsSth->fetchAll(PDO::FETCH_ASSOC);

                foreach($items as $item) {
                	$updateReportQuery = "UPDATE `reports` SET `status` = :status WHERE `id` = :id";
                	$updateReportSth = $conn->prepare($updateReportQuery);
                	$updateReportSth->execute([
                   		":status" => "seen",
                   		":id" => $item['id']
                	]);
                }

		$response['error'] = false;
        	$response['reports'] = $items;
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
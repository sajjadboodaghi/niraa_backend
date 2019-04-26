<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['report_id'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $reportId = $_POST['report_id'];
        
        if(!isAdmin($conn, $username, $password)) {  
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            
			$deleteReportQuery = "DELETE FROM reports WHERE id = :report_id";
			$deleteReportSth = $conn->prepare($deleteReportQuery);
			$deleteReportResult = $deleteReportSth->execute([
                    ':report_id' => $reportId
                ]);
			if($deleteReportResult) {
				$response['error'] = false;
        		$response['message'] = "گزارش با موفقیت حذف شد";
			} else {
				$response['error'] = true;
            	$response['message'] = "در حذف گزارش مشکلی به وجود آمده است!";
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
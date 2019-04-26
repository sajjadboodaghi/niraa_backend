<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['suggest_id'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $suggestId = $_POST['suggest_id'];
        
        if(!isAdmin($conn, $username, $password)) {   
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            
			$deleteSuggestQuery = "DELETE FROM suggests WHERE id = :suggest_id";
			$deleteSuggestSth = $conn->prepare($deleteSuggestQuery);
			$deleteSuggestResult = $deleteSuggestSth->execute([
                    ':suggest_id' => $suggestId
                ]);
			if($deleteSuggestSth) {
				$response['error'] = false;
        		$response['message'] = "پیشنهاد با موفقیت حذف شد";
			} else {
				$response['error'] = true;
            	$response['message'] = "در حذف پیشنهاد مشکلی به وجود آمده است!";
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
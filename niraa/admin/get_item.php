<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['itemId'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $itemId = $_POST['itemId'];

        if(!isAdmin($conn, $username, $password)) {   
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
			$getItemQuery = "SELECT * FROM `items` WHERE `id` = :item_id";
			$getItemSth = $conn->prepare($getItemQuery);
			$getItemSth->execute([
                    ':item_id' => $itemId
                ]);
			$item = $getItemSth->fetch(PDO::FETCH_ASSOC);
			if(empty($item)) {
				$response['error'] = true;
            	$response['message'] = "آگهی پیدا نشد!";
			} else {
				$response['error'] = false;
        		$response['item'] = $item;
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
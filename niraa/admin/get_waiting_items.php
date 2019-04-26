<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['last_id']) && isset($_POST['items_count'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if(!isAdmin($conn, $username, $password)) {   
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {
            $timesForItemsCount = 4;

			$items_count = $_POST['items_count'] * $timesForItemsCount;
			$last_id = $_POST['last_id'];

			$getWaitingItemsQuery = "SELECT * FROM `items` WHERE `id` > :last_id AND `verified` = :verified ORDER BY `id` ASC LIMIT :items_count";
			// for solving limit error in pdo prepare
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
			$getWaitingItemsSth = $conn->prepare($getWaitingItemsQuery);
			$getWaitingItemsSth->execute([
                ':last_id' => $last_id,
                ':items_count' => $items_count,
                ':verified' => 0
            ]);

			$items = $getWaitingItemsSth->fetchAll(PDO::FETCH_ASSOC);

			$response['error'] = false;
        	$response['items'] = $items;

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
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

if(!isset($_POST['search_string'])) {

	$response = [
	    "error" => true,
	    "message" => "عبارت جستجو ارسال نشده است!"
	];

    echo json_encode($response);
    exit();

}


$timesForItemsCount = 4;

$items_count = isset($_POST['items_count']) ? $_POST['items_count'] * $timesForItemsCount : 20;

if(isset($_POST['last_timestamp']) && $_POST['last_timestamp'] != 'first') {
    $last_timestamp = $_POST['last_timestamp'];
} else {
    $last_timestamp = time();
}

$search_string = substr($_POST['search_string'], 0, 30);
$search_string = str_replace("  ", " ", $search_string);
$search_string = str_replace(" ", "%", $search_string);
$search_string = '%' . $search_string . '%';

$params = [
    ':last_timestamp'         => $last_timestamp,
    ':items_count'            => $items_count,
    ':string_for_subcat'      => $search_string,
    ':string_for_title'       => $search_string,
    ':string_for_description' => $search_string
];

$searchQuery = "SELECT * FROM items WHERE (`subcat_name` LIKE :string_for_subcat OR `title` LIKE :string_for_title OR `description` LIKE :string_for_description) AND `timestamp` < :last_timestamp AND verified = 1 ORDER BY `timestamp` DESC LIMIT :items_count";

// for solving limit error in pdo prepare
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
$searchSth = $conn->prepare($searchQuery);
$searchSth->execute($params);
$items = $searchSth->fetchAll(PDO::FETCH_ASSOC);
$response = [
    "error" => false,
    "items" => $items,
    "now_timestamp" => time()
];

$conn = null;
echo json_encode($response);


?>
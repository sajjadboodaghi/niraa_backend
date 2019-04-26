<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

$timesForItemsCount = 4;

$items_count = isset($_GET['items_count']) ? $_GET['items_count'] * $timesForItemsCount: 20;
if(isset($_GET['last_timestamp']) && $_GET['last_timestamp'] != 0) {
	$last_timestamp = $_GET['last_timestamp'];
} else {
	$last_timestamp = time();
}


$selectQuery = "SELECT * FROM items WHERE `timestamp` < :last_timestamp AND verified = 1 ORDER BY `timestamp` DESC LIMIT :items_count";
// for solving limit error in pdo prepare
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
$selectSth = $conn->prepare($selectQuery);
$selectSth->execute([':last_timestamp' => $last_timestamp, ':items_count' => $items_count]);

$items = $selectSth->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

$result = [
	"error" => false, 
	"items" => $items,
	"now_timestamp" => time()
];

echo json_encode($result);

?>
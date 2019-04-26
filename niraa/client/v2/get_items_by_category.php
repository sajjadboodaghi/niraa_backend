<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

$timesForItemsCount = 4;

$items_count = isset($_POST['items_count']) ? $_POST['items_count'] * $timesForItemsCount: 20;
if(isset($_POST['last_timestamp']) && $_POST['last_timestamp'] != 'first') {
    $last_timestamp = $_POST['last_timestamp'];
} else {
    $last_timestamp = time();
}

if(isset($_POST['subcat_id'])) {
    $subcat_id = $_POST['subcat_id'];
} else {
    echo json_encode([
        "error" => true,
        "message" => "هیچ دسته ای انتخاب نشده است!"
    ]);
    return;
}

$selectQuery = "SELECT * FROM items WHERE `timestamp` < :last_timestamp AND subcat_id = :subcat_id AND verified = 1 ORDER BY `timestamp` DESC LIMIT :items_count";
// for solving limit error in pdo prepare
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
$selectSth = $conn->prepare($selectQuery);
$selectSth->execute([
    ':last_timestamp' => $last_timestamp,
    ':subcat_id' => $subcat_id,
    ':items_count' => $items_count
]);

$items = $selectSth->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

$result = [
    "error" => false,
    "items" => $items
];

echo json_encode($result);

?>
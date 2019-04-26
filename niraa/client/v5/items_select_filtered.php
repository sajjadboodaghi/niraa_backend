<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

$timesForItemsCount = 4;

$items_count = isset($_POST['items_count']) ? $_POST['items_count'] * $timesForItemsCount: 20;
if(isset($_POST['last_timestamp']) && $_POST['last_timestamp'] != 'first') {
    $last_timestamp = $_POST['last_timestamp'];
} else {
    $last_timestamp = time();
}

if(isset($_POST['subcat_id']) && isset($_POST['city']) && isset($_POST['image_count'])) {
    $subcat_id = $_POST['subcat_id'];
    $city = $_POST['city'];
    $imageCount = $_POST['image_count'];
} else {
    echo json_encode([
        "error" => true,
        "message" => "اطلاعات مورد نیاز ارسال نشده است!"
    ]);
    return;
}

if($city == "تمام شهرها") {
    $city = "%";
}

$selectQuery = "SELECT * FROM items WHERE `timestamp` < :last_timestamp AND subcat_id LIKE :subcat_id AND place LIKE :city AND image_count >= :image_count AND verified = 1 ORDER BY `timestamp` DESC LIMIT :items_count";
// for solving limit error in pdo prepare
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
$selectSth = $conn->prepare($selectQuery);
$selectSth->execute([
    ':last_timestamp' => $last_timestamp,
    ':subcat_id'      => $subcat_id,
    ':city'           => $city,
    ':image_count'    => $imageCount,
    ':items_count'    => $items_count
]);

$items = $selectSth->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

$result = [
    "error" => false,
    "items" => $items,
    "now_timestamp" => time()
];

echo json_encode($result);

?>
<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

$timesForItemsCount = 4;

$items_count = isset($_POST['items_count']) ? $_POST['items_count'] * $timesForItemsCount: 20;
if(isset($_POST['last_timestamp']) && $_POST['last_timestamp'] != 'first') {
    $last_timestamp = $_POST['last_timestamp'];
} else {
    $last_timestamp = time();
}

$searchQuery = "SELECT * FROM items WHERE ";
$params = [
    ':last_timestamp' => $last_timestamp,
    ':items_count'    => $items_count
];

if(isset($_POST['search_string'])) {
    $search_string = substr($_POST['search_string'], 0, 30);
    $search_string = str_replace("  ", " ", $search_string);
    $words = explode(" ", $search_string);

    foreach ($words as $key => $value) {
        if(strlen(trim($value)) < 6)
            unset($words[$key]);
    }

    if(count($words) == 0) {
        $result = [
            "error" => false,
            "items" => [],
            "now_timestamp" => time()
        ];

        echo json_encode($result);
        exit();
    }

    $searchQuery .= " ( ";
    $counter = 0;
    foreach ($words as $word) {
        $word_name = ":word" . $counter;
        $searchQuery .= " `subcat_name` like " . $word_name . " OR ";
        $params[$word_name] = "%" . $word . "%";
        $counter++;
    }

    foreach ($words as $word) {
        $word_name = ":word" . $counter;
        $searchQuery .= " `title` like " . $word_name . " OR ";
        $params[$word_name] = "%" . $word . "%";
        $counter++;
    }

    foreach ($words as $word) {
        $word_name = ":word" . $counter;
        $searchQuery .= " `description` like " . $word_name . " OR ";
        $params[$word_name] = "%" . $word . "%";
        $counter++;
    }

    if(count($words) > 0) {
        $searchQuery .= "|";
        $searchQuery = str_replace(" OR |", ") AND ", $searchQuery);
    }

}

$searchQuery .= " `timestamp` < :last_timestamp AND verified = 1 ORDER BY `timestamp` DESC LIMIT :items_count";
// for solving limit error in pdo prepare
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
$searchSth = $conn->prepare($searchQuery);
$searchSth->execute($params);

$items = $searchSth->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

$result = [
    "error" => false,
    "items" => $items,
    "now_timestamp" => time()
];

echo json_encode($result);

?>
<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';


$selectQuery = "SELECT id, phone_number, link, phone FROM stories WHERE status = :status ORDER BY timestamp DESC";
$selectSth = $conn->prepare($selectQuery);
$selectSth->execute([
    ":status" => "published"
]);
$stories = $selectSth->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

$result = [
    "error" => false,
    "stories" => $stories,
    "now_timestamp" => time()

];

echo json_encode($result);

?>
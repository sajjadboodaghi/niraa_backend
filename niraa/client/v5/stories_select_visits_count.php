<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

$id = $_GET['story_id'];

$selectQuery = "SELECT visits_count FROM stories WHERE id = :id";
$selectSth = $conn->prepare($selectQuery);
$selectSth->execute([
    ":id" => $id
]);
$story = $selectSth->fetch(PDO::FETCH_ASSOC);
$conn = null;

$result = [
    "error" => false,
    "visits_count" => $story['visits_count']

];

echo json_encode($result);

?>
<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';

$id = $_GET['story_id'];

$updateQuery = "UPDATE `stories` SET visits_count = visits_count + 1 WHERE id = :id;";
$updateSth = $conn->prepare($updateQuery);
$result = $updateSth->execute([
    ":id" => $id
]);


echo json_encode($result);

?>
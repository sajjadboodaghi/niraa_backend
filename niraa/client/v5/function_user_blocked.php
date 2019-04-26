<?php

function isUserBlocked($connection, $phoneNumber) {
    $selectQuery = 'SELECT id FROM users WHERE phone_number = :phoneNumber AND status = :status;';
    $selectSth = $connection->prepare($selectQuery);
    $selectSth->execute([':phoneNumber' => $phoneNumber, ':status' => 'blocked' ]);
    $result = $selectSth->fetchAll();
    
    if(empty($result)) {
        return false;
    } else {
        return true;
    }
}



?>
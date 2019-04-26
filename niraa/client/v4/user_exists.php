<?php

function userExists($connection, $phoneNumber, $token) {
    $selectQuery = 'SELECT id FROM users WHERE phone_number = :phoneNumber AND token = :token AND status = :status;';
    $selectSth = $connection->prepare($selectQuery);
    $selectSth->execute([':phoneNumber' => $phoneNumber, ':token' => $token, ':status' => 'normal' ]);
    $result = $selectSth->fetchAll();
    
    if(empty($result)) {
        return false;
    } else {
        return true;
    }
}

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
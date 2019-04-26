<?php

function hasWaitingItem($connection, $phoneNumber) {
	$hasWaitingItemQuery = 'SELECT id FROM items WHERE phone_number = :phoneNumber AND verified = :verified;';
    $hasWaitingItemSth = $connection->prepare($hasWaitingItemQuery);
    $hasWaitingItemSth->execute([':phoneNumber' => $phoneNumber, ':verified' => 0]);
    $hasWaitingItemResult = $hasWaitingItemSth->fetchAll();
   
	if(empty($hasWaitingItemResult)) {
		return false;
	} else {
		return true;
	}
}

?>
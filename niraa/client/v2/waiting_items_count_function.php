<?php

function waitingItemsCount($connection, $phoneNumber) {
	$waitingItemsQuery = 'SELECT id FROM items WHERE phone_number = :phoneNumber AND verified = :verified;';
        $waitingItemsSth = $connection->prepare($waitingItemsQuery);
        $waitingItemsSth ->execute([':phoneNumber' => $phoneNumber, ':verified' => 0]);
        $waitingItems = $waitingItemsSth ->fetchAll(PDO::FETCH_ASSOC);
   
	return count($waitingItems);
}

?>
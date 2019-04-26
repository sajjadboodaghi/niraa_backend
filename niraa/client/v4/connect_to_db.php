<?php


define('DB_HOST', 'localhost');
define('DB_NAME', 'sajjadbo_db');
define('DB_USER', 'sajjadbo_user');
define('DB_PASS', 'uzumymW313');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8" , DB_USER, DB_PASS);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
catch(PDOException $e)
{
    die("Connection failed: " . $e->getMessage());
}



?>
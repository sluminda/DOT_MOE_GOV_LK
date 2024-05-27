<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "dot_moe_gov_lk"; 
$port = 3308; // Add the port number

try {
    // Include the port number in the DSN
    $dsn = "mysql:host=$servername;port=$port;dbname=$dbname";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

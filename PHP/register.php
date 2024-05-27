<?php

include './db_connect.php';

$username = 'admin1';
$password = 'admin1';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO userlogin (userName, userPassword) VALUES (:username, :password)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashed_password);
$stmt->execute();

echo "User registered successfully!";
?>

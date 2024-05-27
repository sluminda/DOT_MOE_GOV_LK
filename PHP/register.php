<?php

include './db_connect.php';

$username = 'admin';
$password = 'admin';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO userlogin (userName, userPassword) VALUES (:username, :password)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashed_password);
$stmt->execute();

echo "User registered successfully!";
?>

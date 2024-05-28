<?php
require 'db_connect.php';

$username = 'superadmin';
$password = 'superadmin';
$userType = 'Super Admin';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO userlogin (userName, userPassword, userType) VALUES (:username, :password, :userType)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashed_password);
$stmt->bindParam(':userType', $userType);
$stmt->execute();

echo "User registered successfully!";
?>

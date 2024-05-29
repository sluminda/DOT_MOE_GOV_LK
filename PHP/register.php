<?php
require 'db_connect.php';

$username = 'ok';
$password = 'ok';
$userType = 'Admin';
$email = 'sanda@gmail.com';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO userlogin (userName, userPassword, userType, email) VALUES (:username, :password, :userType, :email)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':userType', $userType);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "User registered successfully!";
} catch (PDOException $e) {
    // Check if the error code is for duplicate entry
    if ($e->getCode() == 23000) {
        echo "Error: Username or email already exists. Please choose a different username or email.";
    } else {
        // For other database errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
require 'db_connect.php';

$username = 'd';
$password = 'a';
$userType = 'gertergrgergergergdasfwetwsgwsegwsrgwsrgws';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    try {
        $sql = "INSERT INTO userlogin (userName, userPassword, userType) VALUES (:username, :password, :userType)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':userType', $userType);
        $stmt->execute();
        echo "User registered successfully!";
    } catch (PDOException $e) {
        // Check if the error code is for duplicate entry
        if ($e->getCode() == 23000) {
            echo "<h1>Error: Username already exists. Please choose a different username.</h1>";
        } else {
            // For other database errors
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
} catch (Exception $e) {
    // Handle any other PHP errors
    echo "<h1>Something went wrong. Please try again later.</h1>";
    // Optionally log the error message for debugging purposes
    // error_log($e->getMessage());
}

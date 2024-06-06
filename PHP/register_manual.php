<?php
// session_start();
require 'db_connect.php';

// Ensure that the user is logged in
// if (!isset($_SESSION['loggedIn'])) {
//     header("Location: login.php");
//     exit;
// }

// Ensure that the user is a Super Admin
// if ($_SESSION['userType'] !== 'Super Admin') {
//     echo "Access denied. You do not have permission to access this page.";
//     exit;
// }

// Sample data for 20 users
$sampleUsers = [
    ["username" => "user1", "password" => "password1", "userType" => "Admin", "email" => "user1@example.com", "phoneNumber" => "0234567890"],
    ["username" => "user2", "password" => "password2", "userType" => "Super Admin", "email" => "user2@example.com", "phoneNumber" => "0234567891"],
    ["username" => "user3", "password" => "password3", "userType" => "Admin", "email" => "user3@example.com", "phoneNumber" => "0234567892"],
    ["username" => "user4", "password" => "password4", "userType" => "Super Admin", "email" => "user4@example.com", "phoneNumber" => "0234567893"],
    ["username" => "user5", "password" => "password2", "userType" => "Super Admin", "email" => "user5@example.com", "phoneNumber" => "0234567891"],
    ["username" => "user6", "password" => "password3", "userType" => "Admin", "email" => "user6@example.com", "phoneNumber" => "0234567892"],
    ["username" => "user7", "password" => "password4", "userType" => "Super Admin", "email" => "user7@example.com", "phoneNumber" => "0234567893"],
    ["username" => "user8", "password" => "password2", "userType" => "Super Admin", "email" => "user8@example.com", "phoneNumber" => "0234567891"],
    ["username" => "user9", "password" => "password3", "userType" => "Admin", "email" => "user9@example.com", "phoneNumber" => "0234567892"],
    ["username" => "user10", "password" => "password4", "userType" => "Super Admin", "email" => "user10@example.com", "phoneNumber" => "0234567893"]
];

foreach ($sampleUsers as $user) {
    $username = htmlspecialchars(trim($user['username']));
    $password = htmlspecialchars(trim($user['password']));
    $userType = htmlspecialchars(trim($user['userType']));
    $email = htmlspecialchars(trim($user['email']));
    $phoneNumber = htmlspecialchars(trim($user['phoneNumber']));

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO userlogin (userName, userPassword, userType, userEmail, userPhoneNumber) VALUES (:username, :password, :userType, :email, :phoneNumber)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':userType', $userType);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->execute();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Error: Username or email already exists. Please choose a different username or email.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}

echo "20 users registered successfully!";

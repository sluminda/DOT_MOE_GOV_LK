<?php
session_start();
require './db_config.php';


if (!isset($_SESSION['loggedIn'])) {
    header("Location: ./login.php");
    exit;
}


if ($_SESSION['userType'] !== 'Owner') {
    echo "Access denied. You do not have permission to access this page.";
    exit;
}


$sampleUsers = [
    // ["username" => "databranch", "password" => "dmb@ISURUPAYA", "userType" => "Owner", "email" => "dotmoegov@gmail.com", "phoneNumber" => "0773643424"]
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

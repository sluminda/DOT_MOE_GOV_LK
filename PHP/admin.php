<?php
session_start();

// Check if the session is expired
if (!isset($_SESSION['loginTime']) || (time() - $_SESSION['loginTime'] > 259200)) { // 259200 seconds = 3 days
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Check if the user is logged in and has the correct user type
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true || $_SESSION['userType'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

// Reset login time on each valid request to keep session active
$_SESSION['loginTime'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <!-- Admin content goes here -->
    <a href="logout.php">Logout</a>
</body>
</html>

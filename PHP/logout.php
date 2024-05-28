<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <meta http-equiv="refresh" content="3;url=login.php">
</head>
<body>
    <p>You have been logged out. You will be redirected to the <a href="login.php">login page</a> in 3 seconds.</p>
</body>
</html>

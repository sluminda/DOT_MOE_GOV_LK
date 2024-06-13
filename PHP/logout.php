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

    <link rel="apple-touch-icon" sizes="180x180" href="../Images/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Images/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Images/Favicon/favicon-16x16.png">
    <link rel="manifest" href="../Images/Favicon/site.webmanifest">

    <meta http-equiv="refresh" content="3;url=login.php">

    <style>
        p {
            text-align: center;
            padding: 3rem 0;
            font-size: 1.2rem;
            color: #e34040;
            font-weight: 800;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            white-space: pre;
        }

        a {
            color: #6969ee
        }
    </style>
</head>

<body>
    <p>You have been logged out.&nbsp; You will be redirected to the <a href="login.php">login page</a> in 3 seconds.</p>
</body>

</html>
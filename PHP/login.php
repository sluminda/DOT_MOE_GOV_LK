<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = htmlspecialchars(trim($_POST['username']));
    $pass = htmlspecialchars(trim($_POST['password']));

    $sql = "SELECT userPassword, userType FROM userlogin WHERE userName = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $user);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $row['userPassword'];
        $userType = $row['userType'];

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['userType'] = $userType;
            $_SESSION['loggedIn'] = true;
            $_SESSION['loginTime'] = time();
            
            if ($userType === "Admin") {
                header("Location: admin.php");
            } elseif ($userType === "Super Admin") {
                header("Location: superadmin.php");
            }
            exit;
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!-- HTML form (same as before) -->
<main class="DF PR FD-C">
    <div class="login-background_container DF PR center">
        <form class="login-form PR center" action="login.php" method="post">
            <div class="login_row DG PR center">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required>
            </div>
            <div class="login_row DG PR center">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div class="login_row DG PR">
                <a href="">Forgot Password</a>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</main>




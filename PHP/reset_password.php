<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = htmlspecialchars(trim($_POST['token']));
    $newPassword = htmlspecialchars(trim($_POST['newPassword']));
    $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT);

    // Validate the token
    $sql = "SELECT * FROM password_resets WHERE token = :token";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $row['email'];

        // Update the user's password
        $sql = "UPDATE userlogin SET userPassword = :password WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Delete the token
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }
} else if (isset($_GET['token'])) {
    $token = htmlspecialchars(trim($_GET['token']));
?>

<!-- HTML form for reset password -->
<main class="DF PR FD-C">
    <div class="login-background_container DF PR center">
        <form class="login-form PR center" action="reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <div class="login_row DG PR center">
                <label for="newPassword">New Password</label>
                <input id="newPassword" name="newPassword" type="password" required>
            </div>
            <div class="login_row DG PR">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</main>

<?php
} else {
    echo "Invalid request.";
}
?>

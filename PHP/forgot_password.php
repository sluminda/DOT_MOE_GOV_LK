<?php
session_start();
require './db_config.php';
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInput = trim($_POST['userInput']);

    try {
        // Check if input is an email
        if (filter_var($userInput, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM userlogin WHERE userEmail = :userInput";
        } else {
            // Assume input is a username
            $sql = "SELECT * FROM userlogin WHERE username = :userInput";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userInput', $userInput, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $row['userEmail']; // Get the email from the database
            $token = bin2hex(random_bytes(50)); // Generate a secure token
            $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiry time set to 1 hour

            // Insert token into password_resets table
            $sql = "INSERT INTO password_resets (email, token, expiry_time) VALUES (:email, :token, :expiry_time)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':expiry_time', $expiry_time, PDO::PARAM_STR);
            $stmt->execute();

            // Send email to user with the reset link
            $resetLink = "http://yourdomain.com/PHP/reset_form.php?token=$token";
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'dotmoegov@gmail.com';
                $mail->Password   = 'zjxkoytcmtkrocjq';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('dotmoegov@gmail.com', 'Password Reset');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body    = "Click the following link to reset your password: <a href='$resetLink'>$resetLink</a>. The link will expire in 1 hour.";

                $mail->send();
                $_SESSION['message'] = "A password reset link has been sent to your email.";
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['message'] = "No account found with that username or email address.";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Something went wrong. Please try again later.";
    }
    header('Location: ./forgot_password.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="message"><?php echo $_SESSION['message'];
                                    unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <form action="forgot_password.php" method="post">
            <div class="form-group">
                <label for="userInput">Username or Email</label>
                <input type="text" id="userInput" name="userInput" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>
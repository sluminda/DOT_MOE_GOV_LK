<?php
require 'db_config.php';
require './vendor/autoload.php'; // Ensure this path is correct and the file exists

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));

    try {
        $sql = "SELECT * FROM userlogin WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(50)); // Generate a secure token
            $sql = "INSERT INTO password_resets (email, token) VALUES (:email, :token)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            // Send email to user with the reset link
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = 0;                                      // Disable verbose debug output
                $mail->isSMTP();                                           // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
                $mail->Username   = 'dotmoegov@gmail.com';                // SMTP username
                $mail->Password   = 'zjxkoytcmtkrocjq';                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Enable TLS encryption
                $mail->Port       = 587;                                   // TCP port to connect to

                //Recipients
                $mail->setFrom('dotmoegov@gmail.com', 'Mailer');
                $mail->addAddress($email);                                 // Add a recipient

                // Content
                $mail->isHTML(true);                                       // Set email format to HTML
                $mail->Subject = 'Password Reset';
                $mail->Body    = "Click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";

                $mail->send();
                echo "A password reset link has been sent to your email.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "No account found with that email address.";
        }
    } catch (Exception $e) {
        echo "Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/Body/reset_password.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <form action="forgot_password.php" method="post">
                <h2>Forgot Password</h2>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div class="input-group">
                    <button type="submit">Send Reset Link</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>
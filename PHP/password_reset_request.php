<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure to include PHPMailer library

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));

    // Check if the email exists in the database
    $sql = "SELECT * FROM userlogin WHERE userEmail = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $token = bin2hex(random_bytes(32));
        $expires_at = date("Y-m-d H:i:s", strtotime('+15 minutes'));

        // Insert token into password_resets table
        $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires_at', $expires_at);
        $stmt->execute();

        // Send reset link via email
        $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // SMTP username
        $mail->Password = 'your-email-password'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        $mail->setFrom('no-reply@example.com', 'Your Website');
        $mail->addAddress($email); // Add a recipient

        $mail->isHTML(true); // Set email format to HTML

        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Please click on the following link to reset your password: <a href='$resetLink'>$resetLink</a>";

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Password reset link has been sent to your email address.';
        }
    } else {
        echo 'No user found with that email address.';
    }
}

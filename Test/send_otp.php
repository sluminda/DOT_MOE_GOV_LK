<?php
include 'db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function generateOtp()
{
    return rand(100000, 999999);
}

function hashOtp($otp)
{
    $salt = bin2hex(random_bytes(32));
    $hash = hash('sha256', $otp . $salt);
    return [$hash, $salt];
}

$email = $_POST['email'];
$otp = generateOtp();
list($otpHash, $salt) = hashOtp($otp);

// Save OTP hash and salt in the database
$stmt = $conn->prepare("INSERT INTO otp_verification (email, otp_hash, salt, created_at) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE otp_hash = ?, salt = ?, created_at = NOW()");
$stmt->bind_param("sssss", $email, $otpHash, $salt, $otpHash, $salt);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dotmoegov@gmail.com'; // SMTP username
        $mail->Password   = 'zjxkoytcmtkrocjq'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('dotmoegov@gmail.com', 'Mailer');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = 'Your OTP code is ' . $otp;

        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save OTP.']);
}

$conn->close();

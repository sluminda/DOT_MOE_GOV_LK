<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3308;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit();
}

$otp = random_int(100000, 999999);
$otpHash = password_hash($otp, PASSWORD_DEFAULT);
$expiresAt = time() + (15 * 60); // 15 minutes

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO otp_requests (email, otp_hash, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $email, $otpHash, $expiresAt);
$stmt->execute();
$stmt->close();
$conn->close();

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dotmoegov@gmail.com';
    $mail->Password = 'zjxkoytcmtkrocjq';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('dotmoegov@gmail.com', 'OTP Code');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #ffffff;'>
            <div style='text-align: center; padding-bottom: 20px;'>
                <h1 style='color: #333;'>Your OTP Code</h1>
            </div>
            <div style='border-top: 1px solid #e0e0e0; padding-top: 20px;'>
                <p style='font-size: 16px; color: #333;'>Dear User,</p>
                <p style='font-size: 16px; color: #333;'>Your OTP code is <strong style='color: #0077ff;'>$otp</strong>. It is valid for 15 minutes.</p>
                <p style='font-size: 16px; color: #333;'>Please use this code to complete your verification process.</p>
                <p style='margin-top: 20px; font-size: 16px; color: #333;'><br></p>
                <p style='font-size: 14px;'>Best regards,<br>Data Management Branch, <br>Ministry of Education</p>
            </div>
        </div>
    ";
    $mail->AltBody = "
        Dear User,\n\n
        Your OTP code is $otp. It is valid for 15 minutes.\n
        Please use this code to complete your verification process.\n\n\n
        Best regards,\n
        Data Management Branch,\n
        Ministry of Education.\n
    ";

    $mail->send();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}

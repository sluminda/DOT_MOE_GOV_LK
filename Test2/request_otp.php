<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assuming you have PHPMailer installed via Composer

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3306;

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

    $mail->setFrom('dotmoegov@gmail.com', 'dot_moe_gov_lk');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = 'Your OTP code is ' . $otp . '. It is valid for 15 minutes.';

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}

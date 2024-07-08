<?php
include '../PHP/db_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$otp = $data['otp'];



$stmt = $conn->prepare("SELECT otp_hash, expires_at FROM otp_requests WHERE email = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($otpHash, $expiresAt);
$stmt->fetch();
$stmt->close();

$current_time = time();
if ($current_time > $expiresAt) {
    echo json_encode(['success' => false, 'message' => 'OTP has expired.']);
    exit();
}

if (password_verify($otp, $otpHash)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP.']);
}

$conn->close();

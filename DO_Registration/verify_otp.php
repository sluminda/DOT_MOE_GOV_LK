<?php
include '../PHP/db_config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$otp = $data['otp'];

$stmt = $conn->prepare("SELECT otp_hash, expires_at FROM otp_requests WHERE email = :email ORDER BY id DESC LIMIT 1");
$stmt->bindParam(':email', $email);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$current_time = time();
if (!$result || $current_time > strtotime($result['expires_at'])) {
    echo json_encode(['success' => false, 'message' => 'OTP has expired.']);
    exit();
}

if (password_verify($otp, $result['otp_hash'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP.']);
}

$conn = null;

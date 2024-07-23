<?php
include '../PHP/db_config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$otp = $data['otp'];

try {
    $stmt = $conn->prepare("SELECT otp_hash, expires_at FROM otp_requests WHERE email = :email ORDER BY id DESC LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'No OTP request found for this email.']);
    exit();
}

$otpHash = $result['otp_hash'];
$expiresAt = $result['expires_at'];

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

$conn = null;

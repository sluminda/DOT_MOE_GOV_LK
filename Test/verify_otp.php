<?php
// verify_otp.php
include 'db_connect.php';

$email = $_POST['email'];
$otp = $_POST['otp'];

// Retrieve the OTP hash and salt from the database
$sql = "SELECT otp_hash, salt, created_at FROM otp_verification WHERE email = ? AND created_at > NOW() - INTERVAL 15 MINUTE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($otp_hash, $salt, $created_at);

if ($stmt->fetch()) {
    $stmt->close();
    $conn->close();

    // Validate the OTP
    $otp_to_verify = hash('sha256', $otp . $salt);
    if ($otp_to_verify === $otp_hash) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid OTP."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "OTP expired or not found."]);
    $stmt->close();
    $conn->close();
}

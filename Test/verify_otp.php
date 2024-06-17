<?php
require 'db_config.php';

$otp = $_POST['otp'];
if (!preg_match('/^[0-9]{6}$/', $otp)) {
    echo json_encode(["success" => false, "message" => "Invalid OTP format"]);
    exit;
}

$current_time = time();
$sql = "SELECT * FROM otp_verification WHERE otp = ? AND expiry > ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $otp, $current_time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response = ["success" => true];
} else {
    $response = ["success" => false, "message" => "Invalid or expired OTP"];
}

$stmt->close();
$conn->close();

echo json_encode($response);

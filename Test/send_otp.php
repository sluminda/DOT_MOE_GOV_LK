
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require './db_config.php';

$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email address"]);
    exit;
}

$otp = strval(mt_rand(100000, 999999));
$expiry = time() + (10 * 60);

$sql = "INSERT INTO otp_verification (email, otp, expiry) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE otp = VALUES(otp), expiry = VALUES(expiry)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $email, $otp, $expiry);

if ($stmt->execute()) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sluminda@gmail.com';
        $mail->Password = ' ';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sluminda@gmail.com', 'DOT_MOE_GOV_LK');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification Code';
        $mail->Body = "Your OTP code is: <b>$otp</b>";
        $mail->AltBody = "Your OTP code is: $otp";

        $mail->send();
        $response = ["success" => true];
    } catch (Exception $e) {
        $response = ["success" => false, "message" => "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}"];
    }
} else {
    $response = ["success" => false, "message" => "Failed to generate OTP. Please try again later."];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>

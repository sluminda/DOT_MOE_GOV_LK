<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../PHP/db_config.php';

// Collect form data
$fullName = $_POST['fullName'];
$nicNo = $_POST['nicNo'];
$email = $_POST['email'];
$contactNo = $_POST['contactNo'];
$dataOfficer = $_POST['dataOfficer'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Verify reCAPTCHA
$recaptchaSecret = '6LeuTxsqAAAAAISUja-FjaL-TJTZW6j_EO5m6nem';
$recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents("$recaptchaVerifyUrl?secret=$recaptchaSecret&response=$recaptchaResponse");
$responseData = json_decode($response);

if (!$responseData->success) {
    echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit();
}

// Save inquiry to the database
try {
    $stmt = $conn->prepare("INSERT INTO inquiries (fullName, nicNo, email, contactNo, dataOfficer, subject, message) VALUES (:fullName, :nicNo, :email, :contactNo, :dataOfficer, :subject, :message)");
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':nicNo', $nicNo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contactNo', $contactNo);
    $stmt->bindParam(':dataOfficer', $dataOfficer);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

// Email details
$inquirySubject = "Inquiry from $fullName - $subject";
$inquiryBody = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #ffffff;'>
        <h2>Inquiry Details</h2>
        <p><strong>Full Name:</strong> $fullName</p>
        <p><strong>NIC No:</strong> $nicNo</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Contact No:</strong> $contactNo</p>
        <p><strong>Data Officer:</strong> $dataOfficer</p>
        <p><strong>Subject:</strong> $subject</p>
        <p><strong>Message:</strong> $message</p>
    </div>
";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dotmoegov@gmail.com';
    $mail->Password = 'xwyjdwiphkgbxnmd';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sending inquiry to admin email
    $mail->setFrom('dotmoegov@gmail.com', 'Ministry of Education Inquiries');
    $mail->addAddress('dotmoegov@gmail.com'); // Replace with the admin email

    $mail->isHTML(true);
    $mail->Subject = $inquirySubject;
    $mail->Body = $inquiryBody;
    $mail->AltBody = strip_tags($inquiryBody);

    $mail->send();

    // Optionally, send a confirmation email to the user
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = 'Inquiry Confirmation';
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #ffffff;'>
            <h2>Thank you for your inquiry</h2>
            <p>Dear $fullName,</p>
            <p>We have received your inquiry and will get back to you shortly.</p>
            <p><strong>Inquiry Details:</strong></p>
            <p><strong>Full Name:</strong> $fullName</p>
            <p><strong>NIC No:</strong> $nicNo</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Contact No:</strong> $contactNo</p>
            <p><strong>Data Officer:</strong> $dataOfficer</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong> $message</p>
        </div>
    ";
    $mail->AltBody = strip_tags($mail->Body);
    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Inquiry submitted successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
}

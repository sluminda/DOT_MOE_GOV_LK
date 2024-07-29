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

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit();
}

// Save the inquiry to the database
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
    $mail->Password = '';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sending inquiry to admin email
    $mail->setFrom('dotmoegov@gmail.com', 'Data Officer Inquiries');
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
            <p>Best regards,<br>Data Management Branch,<br>Ministry of Education</p>
        </div>
    ";
    $mail->AltBody = "
        Dear $fullName,\n\n
        We have received your inquiry and will get back to you shortly.\n
        \n
        Inquiry Details:\n
        Full Name: $fullName\n
        NIC No: $nicNo\n
        Email: $email\n
        Contact No: $contactNo\n
        Data Officer: $dataOfficer\n
        Subject: $subject\n
        Message: $message\n
        \n
        Best regards,\n
        Data Management Branch,\n
        Ministry of Education\n
    ";

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Inquiry sent successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Mail Error: ' . $mail->ErrorInfo]);
}

<?php
session_start();
date_default_timezone_set('Asia/Colombo');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../PHP/db_config.php';

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$fullName = $contactNo = $nic = $email = $subject = $message = "";
$submittedAt = date("Y-m-d H:i:s");

// Generate a unique token and store it in the session
if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the form token
    if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
        die("Invalid form submission.");
    }

    // Unset the form token to prevent resubmission
    unset($_SESSION['form_token']);

    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
        $_SESSION['message'] = "Form has already been submitted.";
        $_SESSION['message_type'] = "error";
        header("Location: ./contact_us.php");
        exit();
    }

    $fullName = sanitizeInput($_POST["fullName"]);
    $contactNo = sanitizeInput($_POST["mobileNumber"]);
    $nic = sanitizeInput($_POST["nic"]);
    $email = sanitizeInput($_POST["email"]);
    $subject = sanitizeInput($_POST["subject"]);
    $message = sanitizeInput($_POST["message"]);

    if (empty($fullName) || !preg_match("/^[A-Za-z\s.]+$/", $fullName)) {
        $errors[] = "Full Name is required and can only contain letters, spaces, and dots.";
    }

    if (empty($contactNo) || !preg_match("/^0\d{9}$/", $contactNo)) {
        $errors[] = "Contact Number is required and must be 10 digits starting with 0.";
    }

    if (empty($nic) || !preg_match("/^(\d{9}[vV]|\d{12})$/", $nic)) {
        $errors[] = "NIC is required and must be 10 digits ending with 'v' or 'V', or 12 digits of only numbers.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (empty($subject) || str_word_count($subject) > 50) {
        $errors[] = "Subject is required and must be a maximum of 50 words.";
    }

    if (empty($message) || str_word_count($message) > 500) {
        $errors[] = "Message is required and must be a maximum of 500 words.";
    }

    if (empty($errors)) {
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO inquiries (fullName, contactNo, nic, email, subject, message, submittedAt) VALUES (:fullName, :contactNo, :nic, :email, :subject, :message, :submittedAt)");
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':contactNo', $contactNo);
        $stmt->bindParam(':nic', $nic);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':submittedAt', $submittedAt);
        $stmt->execute();

        // Send confirmation email to the user
        $userMail = new PHPMailer(true);

        try {
            $userMail->SMTPDebug = 0;
            $userMail->isSMTP();
            $userMail->Host = 'smtp.gmail.com';
            $userMail->SMTPAuth = true;
            $userMail->Username = 'dotmoegov@gmail.com';
            $userMail->Password = 'xwyjdwiphkgbxnmd';
            $userMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $userMail->Port = 587;

            $userMail->setFrom('dotmoegov@gmail.com', 'Contact Us');
            $userMail->addAddress($email, $fullName);

            $userMail->isHTML(true);
            $userMail->Subject = 'Contact Us Submission Confirmation';
            $userMail->Body = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #ffffff;'>
        <div style='text-align: center; padding-bottom: 20px;'>
            <h1 style='color: #333;'>Contact Us Form Submission Confirmation</h1>
        </div>
        <div style='border-top: 1px solid #e0e0e0; padding-top: 20px;'>
            <p style='font-size: 16px; color: #333;'>Dear $fullName,</p>
            <p style='font-size: 16px; color: #333;'>We have received your inquiry and will get back to you shortly.</p>
            <div style='padding-top: 20px;'>
                <h3 style='color: #333;'>Submitted Details:</h3>
                <div style='border-left: 3px solid #00aaff; padding-left: 15px; margin-left: 10px;'>
                    <p style='font-size: 14px; color: #333;'><strong>Full Name:</strong> $fullName</p>
                    <p style='font-size: 14px; color: #333;'><strong>Contact Number:</strong> $contactNo</p>
                    <p style='font-size: 14px; color: #333;'><strong>NIC:</strong> $nic</p>
                    <p style='font-size: 14px; color: #333;'><strong>Email:</strong> $email</p>
                    <p style='font-size: 14px; color: #333;'><strong>Subject:</strong> $subject</p>
                    <p style='font-size: 14px; color: #333;'><strong>Message:</strong> $message</p>
                </div>
            </div>
            <p style='margin-top: 20px; font-size: 16px; color: #333;'>Best regards,<br>Contact Management Team,<br>Ministry of Education.</p>
        </div>
    </div>";

            $userMail->AltBody = "
            Dear $fullName,\n\n
            Thank you for contacting us. Your message has been successfully received.\n\n
            Submitted Details:\n
            Full Name: $fullName\n
            Contact Number: $contactNo\n
            NIC: $nic\n
            Email: $email\n
            Subject: $subject\n
            Message: $message\n\n
            Best regards,\n
            Contact Management Team,
            Ministry of Education.
            ";

            $userMail->send();
        } catch (Exception $e) {
            $_SESSION['message'] = "Confirmation email could not be sent. Mailer Error: {$userMail->ErrorInfo}";
            $_SESSION['message_type'] = 'error';
            header('Location: ./contact_us.php');
            exit;
        }

        // Send inquiry details to the admin
        $adminMail = new PHPMailer(true);

        try {
            $adminMail->SMTPDebug = 0;
            $adminMail->isSMTP();
            $adminMail->Host = 'smtp.gmail.com';
            $adminMail->SMTPAuth = true;
            $adminMail->Username = 'dotmoegov@gmail.com';
            $adminMail->Password = 'xwyjdwiphkgbxnmd';
            $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $adminMail->Port = 587;

            $adminMail->setFrom('dotmoegov@gmail.com', 'Contact Us Form');
            $adminMail->addAddress('dotmoegov@gmail.com');

            $adminMail->isHTML(true);
            $adminMail->Subject = 'New Inquiry from Contact Us Form';
            $adminMail->Body = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #ffffff;'>
        <div style='text-align: center; padding-bottom: 20px;'>
            <h1 style='color: #333;'>New Inquiry Received</h1>
        </div>
        <div style='border-top: 1px solid #e0e0e0; padding-top: 20px;'>
            <p style='font-size: 16px; color: #333;'>You have received a new inquiry through the Contact Us form.</p>
            <div style='padding-top: 20px;'>
                <h3 style='color: #333;'>Inquiry Details:</h3>
                <div style='border-left: 3px solid #00aaff; padding-left: 15px; margin-left: 10px;'>
                    <p style='font-size: 14px; color: #333;'><strong>Full Name:</strong> $fullName</p>
                    <p style='font-size: 14px; color: #333;'><strong>Contact Number:</strong> $contactNo</p>
                    <p style='font-size: 14px; color: #333;'><strong>NIC:</strong> $nic</p>
                    <p style='font-size: 14px; color: #333;'><strong>Email:</strong> $email</p>
                    <p style='font-size: 14px; color: #333;'><strong>Subject:</strong> $subject</p>
                    <p style='font-size: 14px; color: #333;'><strong>Message:</strong> $message</p>
                </div>
            </div>
        </div>
    </div>";

            $adminMail->AltBody = "
            New Inquiry Received\n\n
            Inquiry Details:\n
            Full Name: $fullName\n
            Contact Number: $contactNo\n
            NIC: $nic\n
            Email: $email\n
            Subject: $subject\n
            Message: $message\n
            ";

            // Send the email to the admin
            $adminMail->send();

            $_SESSION['message'] = 'Form submitted successfully! A confirmation email has been sent.';
            $_SESSION['message_type'] = 'success';
            $_SESSION['form_submitted'] = true;
        } catch (Exception $e) {
            $_SESSION['message'] = "Message could not be sent. Mailer Error: {$adminMail->ErrorInfo}";
            $_SESSION['message_type'] = 'error';
        }

        // Redirect back to the form page
        header('Location: ./contact_us.php');
        exit;
    } else {
        $_SESSION['message'] = implode('<br>', $errors);
        $_SESSION['message_type'] = 'error';
        header('Location: ./contact_us.php');
        exit;
    }
} else {
    $_SESSION['message'] = "Invalid form submission.";
    $_SESSION['message_type'] = "error";
    header("Location: ./contact_us.php");
    exit();
}

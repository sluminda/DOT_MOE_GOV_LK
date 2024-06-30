<?php
session_start();
date_default_timezone_set('Asia/Colombo');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3308;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$fullName = $nameWithInitials = $nic = $email = $whatsappNumber = $mobileNumber = $headOfInstituteName = $headOfInstituteContactNo = $currentWorkingPlace = "";
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
        header("Location: ./data_officer_registration.php");
        exit();
    }

    $fullName = sanitizeInput($_POST["fullName"]);
    $nameWithInitials = sanitizeInput($_POST["nameWithInitials"]);
    $nic = sanitizeInput($_POST["nic"]);
    $email = sanitizeInput($_POST["email"]);
    $whatsappNumber = sanitizeInput($_POST["whatsappNumber"]);
    $mobileNumber = sanitizeInput($_POST["mobileNumber"]);
    $currentWorkingPlace = sanitizeInput($_POST["currentWorkingPlace"]);
    $otpVerified = sanitizeInput($_POST["otpVerified"]);

    if ($otpVerified !== "true") {
        $errors[] = "OTP not verified.";
    }

    if (empty($fullName) || !preg_match("/^[A-Za-z\s.]+$/", $fullName)) {
        $errors[] = "Full Name is required and can only contain letters, spaces, and dots.";
    }

    if (empty($nameWithInitials) || !preg_match("/^[A-Za-z\s.]+$/", $nameWithInitials)) {
        $errors[] = "Name with Initials is required and can only contain letters, spaces, and dots.";
    }

    if (empty($nic) || !preg_match("/^(\d{9}[vV]|\d{12})$/", $nic)) {
        $errors[] = "NIC is required and must be 10 digits ending with 'v' or 'V', or 12 digits of only numbers.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (empty($whatsappNumber) || !preg_match("/^0\d{9}$/", $whatsappNumber)) {
        $errors[] = "WhatsApp Number is required and must be 10 digits starting with 0.";
    }

    if (empty($mobileNumber) || !preg_match("/^0\d{9}$/", $mobileNumber)) {
        $errors[] = "Mobile Number is required and must be 10 digits starting with 0.";
    }

    if ($currentWorkingPlace === "school") {
        $selectedInstituteName = ($_POST["schoolName"]);
        $headOfInstituteName = sanitizeInput($_POST["principleName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["principleContact"]);
    } elseif ($currentWorkingPlace === "provincialOffice") {
        $selectedInstituteName = ($_POST["provincialName"]);
        $headOfInstituteName = sanitizeInput($_POST["provincialHeadOfInstituteName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["provincialHeadOfInstituteContact"]);
    } elseif ($currentWorkingPlace === "zonalOffice") {
        $selectedInstituteName = ($_POST["zonalName"]);
        $headOfInstituteName = sanitizeInput($_POST["zonalHeadOfInstituteName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["zonalHeadOfInstituteContact"]);
    } elseif ($currentWorkingPlace === "divisionalOffice") {
        $selectedInstituteName = ($_POST["divisionalName"]);
        $headOfInstituteName = sanitizeInput($_POST["divisionalHeadOfInstituteName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["divisionalHeadOfInstituteContact"]);
    }

    if (empty($headOfInstituteName) || !preg_match("/^[A-Za-z\s.]+$/", $headOfInstituteName)) {
        $errors[] = "Head of Institute Name is required and can only contain letters, spaces, and dots.";
    }

    if (empty($headOfInstituteContactNo) || !preg_match("/^0\d{9}$/", $headOfInstituteContactNo)) {
        $errors[] = "Head of Institute Contact No is required and must be 10 digits starting with 0.";
    }

    if (empty($errors)) {
        // Insert into history table
        $stmt = $conn->prepare("INSERT INTO workplace_details_history (fullName, nameWithInitials, nic, email, whatsappNumber, mobileNumber, headOfInstituteName, headOfInstituteContactNo, currentWorkingPlace, selectedInstituteName, submittedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $fullName, $nameWithInitials, $nic, $email, $whatsappNumber, $mobileNumber, $headOfInstituteName, $headOfInstituteContactNo, $currentWorkingPlace, $selectedInstituteName, $submittedAt);
        $stmt->execute();

        // Check if NIC and email already exist
        $stmt = $conn->prepare("SELECT id FROM workplace_details WHERE nic=? AND email=?");
        $stmt->bind_param("ss", $nic, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing record
            $stmt = $conn->prepare("UPDATE workplace_details SET fullName=?, nameWithInitials=?, whatsappNumber=?, mobileNumber=?, headOfInstituteName=?, headOfInstituteContactNo=?, currentWorkingPlace=?, selectedInstituteName=?, submittedAt=? WHERE nic=? AND email=?");
            $stmt->bind_param("sssssssssss", $fullName, $nameWithInitials, $whatsappNumber, $mobileNumber, $headOfInstituteName, $headOfInstituteContactNo, $currentWorkingPlace, $selectedInstituteName, $submittedAt, $nic, $email);
            $stmt->execute();
        } else {
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO workplace_details (fullName, nameWithInitials, nic, email, whatsappNumber, mobileNumber, headOfInstituteName, headOfInstituteContactNo, currentWorkingPlace, selectedInstituteName, submittedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $fullName, $nameWithInitials, $nic, $email, $whatsappNumber, $mobileNumber, $headOfInstituteName, $headOfInstituteContactNo, $currentWorkingPlace, $selectedInstituteName, $submittedAt);
            $stmt->execute();
        }

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dotmoegov@gmail.com';
            $mail->Password = 'zjxkoytcmtkrocjq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('dotmoegov@gmail.com', 'Mailer');
            $mail->addAddress($email, $nameWithInitials);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Form Submission Confirmation';
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #f9f9f9;'>
                    <div style='text-align: center; padding-bottom: 20px;'>
                        <h1 style='color: #333;'>Form Submission Confirmation</h1>
                    </div>
                    <div style='border-top: 1px solid #e0e0e0; padding-top: 20px;'>
                        <p style='font-size: 16px; color: #333;'>Dear $nameWithInitials,</p>
                        <p style='font-size: 16px; color: #333;'>Thank you for submitting the form. Your details have been successfully recorded.</p>
                        <div style='padding-top: 20px;'>
                            <h3 style='color: #333;'>Submitted Details:</h3>
                            <div style='border-left: 3px solid #00aaff; padding-left: 15px; margin-left: 10px;'>
                                <p><strong>Full Name:</strong> $fullName</p>
                                <p><strong>Name with Initials:</strong> $nameWithInitials</p>
                                <p><strong>NIC:</strong> $nic</p>
                                <p><strong>Email:</strong> $email</p>
                                <p><strong>WhatsApp Number:</strong> $whatsappNumber</p>
                                <p><strong>Mobile Number:</strong> $mobileNumber</p>
                                <p><strong>Head of Institute Name:</strong> $headOfInstituteName</p>
                                <p><strong>Head of Institute Contact No:</strong> $headOfInstituteContactNo</p>
                                <p><strong>Current Working Place:</strong> $currentWorkingPlace</p>
                                <p><strong>Selected Institute Name:</strong> $selectedInstituteName</p>
                            </div>
                        </div>
                        <p style='margin-top: 20px;'>Best regards,<br>Team</p>
                    </div>
                </div>
            ";
            $mail->AltBody = "
                Dear $nameWithInitials,\n\n
                Thank you for submitting the form. Your details have been successfully recorded.\n\n
                Submitted Details:\n
                Full Name: $fullName\n
                Name with Initials: $nameWithInitials\n
                NIC: $nic\n
                Email: $email\n
                WhatsApp Number: $whatsappNumber\n
                Mobile Number: $mobileNumber\n
                Head of Institute Name: $headOfInstituteName\n
                Head of Institute Contact No: $headOfInstituteContactNo\n
                Current Working Place: $currentWorkingPlace\n
                Selected Institute Name: $selectedInstituteName\n\n
                Best regards,\n
                Team
            ";

            $mail->send();
            $_SESSION['message'] = 'Form submitted successfully! A confirmation email has been sent.';
            $_SESSION['message_type'] = 'success';
            $_SESSION['form_submitted'] = true;
        } catch (Exception $e) {
            $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $_SESSION['message_type'] = 'error';
        }

        // Redirect back to the form page
        header('Location: ./data_officer_registration.php');
        exit;
    } else {
        $_SESSION['message'] = 'Errors: ' . implode(", ", $errors);
        $_SESSION['message_type'] = 'error';

        // Redirect back to the form page with errors
        header('Location: ./error.php');
        exit;
    }
} else {
    header('Location: ./error.php');
    exit;
}

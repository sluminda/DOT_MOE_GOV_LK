<?php
session_start();
date_default_timezone_set('Asia/Colombo');

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
        $_SESSION['message'] = "Form has already been submitted.";
        $_SESSION['message_type'] = "error";
        header("Location: index.php");
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

        $_SESSION['form_submitted'] = true;
        $_SESSION['message'] = "Form submitted successfully!";
        $_SESSION['message_type'] = "success";
        session_destroy();

        // Redirect to avoid form resubmission
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "error";
        header("Location: index.php");
        exit();
    }
}

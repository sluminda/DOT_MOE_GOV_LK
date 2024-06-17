<?php
require 'db_config.php';

function validateInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$fullname = validateInput($_POST['fullname']);
$name_with_initials = validateInput($_POST['name_with_initials']);
$nic = validateInput($_POST['nic']);
$email = validateInput($_POST['email']);
$whatsapp_number = validateInput($_POST['whatsapp_number']);
$phone_number = validateInput($_POST['phone_number']);
$working_place = validateInput($_POST['working_place']);
$school_cencode = $working_place === 'School' ? validateInput($_POST['school_search']) : null;
$officer_in_charge = validateInput($_POST['officer_in_charge']);
$designation = validateInput($_POST['designation']);
$contact_number = validateInput($_POST['school_contact_number']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email address"]);
    exit;
}

if (!preg_match('/^0\d{9}$/', $whatsapp_number) || !preg_match('/^0\d{9}$/', $phone_number)) {
    echo json_encode(["success" => false, "message" => "Invalid phone number"]);
    exit;
}

if (!preg_match('/^\d{9}[Vv]|\d{12}$/', $nic)) {
    echo json_encode(["success" => false, "message" => "Invalid NIC"]);
    exit;
}

$sql = "INSERT INTO registrations (fullname, name_with_initials, nic, email, whatsapp_number, phone_number, working_place, school_cencode, officer_in_charge, designation, contact_number)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssssssss', $fullname, $name_with_initials, $nic, $email, $whatsapp_number, $phone_number, $working_place, $school_cencode, $officer_in_charge, $designation, $contact_number);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed. Please try again."]);
}

$stmt->close();
$conn->close();

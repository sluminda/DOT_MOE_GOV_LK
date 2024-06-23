<?php
session_start();
include 'db_connect.php';

if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
    echo json_encode(["success" => false, "message" => "Form already submitted."]);
    exit;
}

$_SESSION['form_submitted'] = true;

$fullName = $_POST['fullName'];
$initials = $_POST['initials'];
$nic = $_POST['nic'];
$email = $_POST['email'];
$whatsapp = $_POST['whatsapp'];
$phone = $_POST['phone'];
$workplace = $_POST['workplace'];
$schoolName = $_POST['schoolName'] ?? null;
$provinceName = $_POST['provinceName'] ?? null;
$zone = $_POST['zone'] ?? null;
$division = $_POST['division'] ?? null;
$institutionName = $_POST['principleName'] ?? $_POST['headOfInstituteName'] ?? null; // Common column
$contactNo = $_POST['principleContactNo'] ?? $_POST['headOfInstituteContactNo'] ?? null; // Common column
$ip_address = $_SERVER['REMOTE_ADDR'];

$sql = "INSERT INTO data_officer_registration 
    (fullName, initials, nic, email, whatsapp, phone, workplace, schoolName, institutionName, contactNo, provinceName, zone, division, ip_address, submitted_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE 
    fullName = VALUES(fullName), initials = VALUES(initials), email = VALUES(email), whatsapp = VALUES(whatsapp), phone = VALUES(phone), workplace = VALUES(workplace), 
    schoolName = VALUES(schoolName), institutionName = VALUES(institutionName), contactNo = VALUES(contactNo), provinceName = VALUES(provinceName), 
    zone = VALUES(zone), division = VALUES(division), 
    ip_address = VALUES(ip_address), submitted_at = NOW()";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssssss",
    $fullName,
    $initials,
    $nic,
    $email,
    $whatsapp,
    $phone,
    $workplace,
    $schoolName,
    $institutionName,
    $contactNo,
    $provinceName,
    $zone,
    $division,
    $ip_address
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to submit the form."]);
}
$stmt->close();

$sql = "INSERT INTO data_officer_registration_history 
    (fullName, initials, nic, email, whatsapp, phone, workplace, schoolName, institutionName, contactNo, provinceName, zone, division, ip_address, submitted_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssssss",
    $fullName,
    $initials,
    $nic,
    $email,
    $whatsapp,
    $phone,
    $workplace,
    $schoolName,
    $institutionName,
    $contactNo,
    $provinceName,
    $zone,
    $division,
    $ip_address
);

$stmt->execute();
$stmt->close();

$conn->close();

// Reset the session form submission flag after some time (optional)
unset($_SESSION['form_submitted']);

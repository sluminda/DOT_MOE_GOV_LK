<?php
// submit_form.php
include 'db_connect.php';

$fullName = $_POST['fullName'];
$initials = $_POST['initials'];
$nic = $_POST['nic'];
$email = $_POST['email'];
$whatsapp = $_POST['whatsapp'];
$phone = $_POST['phone'];
$workplace = $_POST['workplace'];
$schoolName = $_POST['schoolName'] ?? null;
$principleName = $_POST['principleName'] ?? null;
$principleContactNo = $_POST['principleContactNo'] ?? null;
$provinceName = $_POST['provinceName'] ?? null;
$headOfInstituteName = $_POST['headOfInstituteName'] ?? null;
$headOfInstituteContactNo = $_POST['headOfInstituteContactNo'] ?? null;
$zone = $_POST['zone'] ?? null;
$division = $_POST['division'] ?? null;
$ip_address = $_SERVER['REMOTE_ADDR'];

$schoolName = $schoolName ?: null;
$principleName = $principleName ?: null;
$principleContactNo = $principleContactNo ?: null;
$provinceName = $provinceName ?: null;
$headOfInstituteName = $headOfInstituteName ?: null;
$headOfInstituteContactNo = $headOfInstituteContactNo ?: null;
$zone = $zone ?: null;
$division = $division ?: null;

$sql = "INSERT INTO form_submissions 
    (fullName, initials, nic, email, whatsapp, phone, workplace, schoolName, principleName, principleContactNo, provinceName, headOfInstituteName, headOfInstituteContactNo, zone, division, ip_address, submitted_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE 
    fullName = VALUES(fullName), initials = VALUES(initials), nic = VALUES(nic), email = VALUES(email), whatsapp = VALUES(whatsapp), phone = VALUES(phone), workplace = VALUES(workplace), 
    schoolName = VALUES(schoolName), principleName = VALUES(principleName), principleContactNo = VALUES(principleContactNo), provinceName = VALUES(provinceName), 
    headOfInstituteName = VALUES(headOfInstituteName), headOfInstituteContactNo = VALUES(headOfInstituteContactNo), zone = VALUES(zone), division = VALUES(division), 
    ip_address = VALUES(ip_address), submitted_at = NOW()";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssssssss",
    $fullName,
    $initials,
    $nic,
    $email,
    $whatsapp,
    $phone,
    $workplace,
    $schoolName,
    $principleName,
    $principleContactNo,
    $provinceName,
    $headOfInstituteName,
    $headOfInstituteContactNo,
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

$sql = "INSERT INTO form_submissions_history 
    (fullName, initials, nic, email, whatsapp, phone, workplace, schoolName, principleName, principleContactNo, provinceName, headOfInstituteName, headOfInstituteContactNo, zone, division, ip_address, submitted_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssssssss",
    $fullName,
    $initials,
    $nic,
    $email,
    $whatsapp,
    $phone,
    $workplace,
    $schoolName,
    $principleName,
    $principleContactNo,
    $provinceName,
    $headOfInstituteName,
    $headOfInstituteContactNo,
    $zone,
    $division,
    $ip_address
);

$stmt->execute();
$stmt->close();

$conn->close();

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
$school = $_POST['school'];
$sample1 = $_POST['sample1'];
$sample2 = $_POST['sample2'];
$office1 = $_POST['office1'];
$office2 = $_POST['office2'];
$office3 = $_POST['office3'];
$ip_address = $_SERVER['REMOTE_ADDR'];

// Insert or update form data
$sql = "INSERT INTO form_submissions (fullName, initials, nic, email, whatsapp, phone, workplace, school, sample1, sample2, office1, office2, office3, ip_address, submitted_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE 
        fullName = VALUES(fullName), initials = VALUES(initials), nic = VALUES(nic), whatsapp = VALUES(whatsapp), phone = VALUES(phone), workplace = VALUES(workplace), school = VALUES(school), 
        sample1 = VALUES(sample1), sample2 = VALUES(sample2), office1 = VALUES(office1), office2 = VALUES(office2), office3 = VALUES(office3), ip_address = VALUES(ip_address), 
        submitted_at = NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssss", $fullName, $initials, $nic, $email, $whatsapp, $phone, $workplace, $school, $sample1, $sample2, $office1, $office2, $office3, $ip_address);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to submit the form."]);
}
$stmt->close();

// Insert record into form_submissions_history
$sql = "INSERT INTO form_submissions_history (fullName, initials, nic, email, whatsapp, phone, workplace, school, sample1, sample2, office1, office2, office3, ip_address, submitted_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssss", $fullName, $initials, $nic, $email, $whatsapp, $phone, $workplace, $school, $sample1, $sample2, $office1, $office2, $office3, $ip_address);

$stmt->execute();
$stmt->close();

$conn->close();

<?php
require 'db_config.php';

$query = $_POST['query'];
$sql = "SELECT cencode, institutionname FROM institutes WHERE schooltype IN (1, 3) AND (cencode LIKE ? OR institutionname LIKE ?)";
$stmt = $conn->prepare($sql);
$search = "%{$query}%";
$stmt->bind_param('ss', $search, $search);
$stmt->execute();
$result = $stmt->get_result();

$schools = [];
while ($row = $result->fetch_assoc()) {
    $schools[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($schools);

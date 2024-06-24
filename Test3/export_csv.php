<?php
include 'db_connect.php';

$table = isset($_GET['table']) && $_GET['table'] === 'history' ? 'workplace_details_history' : 'workplace_details';

$whereClauses = [];
$params = [];
$types = "";

if (!empty($_GET['name'])) {
    $whereClauses[] = "fullName LIKE ?";
    $params[] = "%" . $_GET['name'] . "%";
    $types .= "s";
}
if (!empty($_GET['nic'])) {
    $whereClauses[] = "nic LIKE ?";
    $params[] = "%" . $_GET['nic'] . "%";
    $types .= "s";
}
if (!empty($_GET['submittedAt_start']) && !empty($_GET['submittedAt_end'])) {
    $whereClauses[] = "submittedAt BETWEEN ? AND ?";
    $params[] = $_GET['submittedAt_start'];
    $params[] = $_GET['submittedAt_end'];
    $types .= "ss";
}
if (!empty($_GET['currentWorkingPlace'])) {
    $whereClauses[] = "currentWorkingPlace LIKE ?";
    $params[] = "%" . $_GET['currentWorkingPlace'] . "%";
    $types .= "s";
}
if (!empty($_GET['selectedInstituteName'])) {
    $whereClauses[] = "selectedInstituteName LIKE ?";
    $params[] = "%" . $_GET['selectedInstituteName'] . "%";
    $types .= "s";
}

$whereSql = '';
if ($whereClauses) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

$query = "SELECT * FROM $table $whereSql";
$stmt = $conn->prepare($query);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$filename = "filtered_data_" . date('Y-m-d_H-i-s') . ".csv";
header('Content-Type: text/csv');
header("Content-Disposition: attachment;filename=$filename");

$output = fopen('php://output', 'w');

$columns = [
    'id' => 'ID',
    'fullName' => 'Full Name',
    'nameWithInitials' => 'Name With Initials',
    'nic' => 'NIC',
    'email' => 'Email',
    'whatsappNumber' => 'WhatsApp Number',
    'mobileNumber' => 'Mobile Number',
    'headOfInstituteName' => 'Head Of Institute Name',
    'headOfInstituteContactNo' => 'Head Of Institute Contact No',
    'currentWorkingPlace' => 'Current Working Place',
    'selectedInstituteName' => 'Selected Institute Name',
    'submittedAt' => 'Submitted At'
];

$visibleColumns = explode(',', $_GET['columns']);
$headers = array_intersect_key($columns, array_flip($visibleColumns));
fputcsv($output, array_values($headers));

while ($row = $result->fetch_assoc()) {
    $data = array_intersect_key($row, array_flip($visibleColumns));
    fputcsv($output, $data);
}

fclose($output);

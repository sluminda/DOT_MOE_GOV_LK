<?php
require 'db_connect.php';

// Get the table name and columns from the query parameters
$table = isset($_GET['table']) && $_GET['table'] === 'history' ? 'workplace_details_history' : 'workplace_details';
$columns = isset($_GET['columns']) ? explode(',', $_GET['columns']) : [];
$columnList = implode(", ", array_map('htmlspecialchars', $columns));

// Build the WHERE clause based on filters
$whereClauses = [];
$params = [];

if (!empty($_GET['name'])) {
    $whereClauses[] = "fullName LIKE :name";
    $params[':name'] = "%" . $_GET['name'] . "%";
}
if (!empty($_GET['nic'])) {
    $whereClauses[] = "nic LIKE :nic";
    $params[':nic'] = "%" . $_GET['nic'] . "%";
}
if (!empty($_GET['submittedAt_start']) && !empty($_GET['submittedAt_end'])) {
    $whereClauses[] = "submittedAt BETWEEN :submittedAt_start AND :submittedAt_end";
    $params[':submittedAt_start'] = $_GET['submittedAt_start'];
    $params[':submittedAt_end'] = $_GET['submittedAt_end'];
}
if (!empty($_GET['currentWorkingPlace'])) {
    $whereClauses[] = "currentWorkingPlace LIKE :currentWorkingPlace";
    $params[':currentWorkingPlace'] = "%" . $_GET['currentWorkingPlace'] . "%";
}
if (!empty($_GET['selectedInstituteName'])) {
    $whereClauses[] = "selectedInstituteName LIKE :selectedInstituteName";
    $params[':selectedInstituteName'] = "%" . $_GET['selectedInstituteName'] . "%";
}

$whereSql = '';
if ($whereClauses) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Prepare the SQL query
$query = "SELECT $columnList FROM $table $whereSql";
$stmt = $conn->prepare($query);
foreach ($params as $key => &$val) {
    $stmt->bindParam($key, $val);
}
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate a filename with the current date and time
$date = new DateTime();
$filename = 'workplace_details_' . $date->format('Y-m-d_H-i-s') . '.csv';

// Set the headers for the CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=' . $filename);

// Open the output stream and write the CSV data
$output = fopen('php://output', 'w');
fputcsv($output, $columns);
foreach ($data as $row) {
    fputcsv($output, array_intersect_key($row, array_flip($columns)));
}
fclose($output);

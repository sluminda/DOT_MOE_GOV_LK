<?php
require 'db_connect.php';

$table = isset($_GET['table']) && $_GET['table'] === 'history' ? 'workplace_details_history' : 'workplace_details';
$columns = isset($_GET['columns']) ? explode(',', $_GET['columns']) : [];
$columnList = implode(", ", array_map('htmlspecialchars', $columns));

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
if (!empty($_GET['province'])) {
    $whereClauses[] = "province LIKE :province";
    $params[':province'] = "%" . $_GET['province'] . "%";
}
if (!empty($_GET['district'])) {
    $whereClauses[] = "district LIKE :district";
    $params[':district'] = "%" . $_GET['district'] . "%";
}
if (!empty($_GET['zone'])) {
    $whereClauses[] = "zone LIKE :zone";
    $params[':zone'] = "%" . $_GET['zone'] . "%";
}
if (!empty($_GET['division'])) {
    $whereClauses[] = "division LIKE :division";
    $params[':division'] = "%" . $_GET['division'] . "%";
}

$whereSql = '';
if ($whereClauses) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Debugging
error_log("SQL Query: SELECT $columnList FROM $table $whereSql");
error_log("Params: " . json_encode($params));

$query = "SELECT $columnList FROM $table $whereSql";
$stmt = $conn->prepare($query);
foreach ($params as $key => &$val) {
    $stmt->bindParam($key, $val);
}
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$date = new DateTime();
$filename = 'workplace_details_' . $date->format('Y-m-d_H-i-s') . '.csv';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=' . $filename);

$output = fopen('php://output', 'w');
fputcsv($output, $columns);
foreach ($data as $row) {
    fputcsv($output, array_intersect_key($row, array_flip($columns)));
}
fclose($output);

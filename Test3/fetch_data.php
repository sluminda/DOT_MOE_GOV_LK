<?php
include 'db_connect.php';

$table = isset($_GET['table']) && $_GET['table'] === 'history' ? 'workplace_details_history' : 'workplace_details';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 50;
$offset = ($page - 1) * $limit;

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

$query = "SELECT * FROM $table $whereSql LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$response = [
    'data' => $data,
    'page' => $page,
    'limit' => $limit
];

echo json_encode($response);

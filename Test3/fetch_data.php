<?php
include 'db_connect.php';

try {
    $table = isset($_GET['table']) && $_GET['table'] === 'history' ? 'workplace_details_history' : 'workplace_details';

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

    $query = "SELECT * FROM $table $whereSql";
    $stmt = $conn->prepare($query);

    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }

    if ($stmt->execute() === false) {
        throw new Exception('Error executing statement: ' . implode(', ', $stmt->errorInfo()));
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        throw new Exception('Error fetching data: ' . implode(', ', $stmt->errorInfo()));
    }

    echo json_encode(['data' => $result]);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}

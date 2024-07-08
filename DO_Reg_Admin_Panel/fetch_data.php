<?php
include '../PHP/db_config.php';

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

    if (!empty($_GET['selectedInstituteCode'])) {
        $whereClauses[] = "selectedInstituteCode LIKE :selectedInstituteCode";
        $params[':selectedInstituteCode'] = "%" . $_GET['selectedInstituteCode'] . "%";
    }

    if (!empty($_GET['selectedInstituteName'])) {
        $whereClauses[] = "selectedInstituteName LIKE :selectedInstituteName";
        $params[':selectedInstituteName'] = "%" . $_GET['selectedInstituteName'] . "%";
    }
    if (!empty($_GET['province'])) {
        $whereClauses[] = "Province LIKE :province";
        $params[':province'] = "%" . $_GET['province'] . "%";
    }
    if (!empty($_GET['district'])) {
        $whereClauses[] = "District LIKE :district";
        $params[':district'] = "%" . $_GET['district'] . "%";
    }
    if (!empty($_GET['zone'])) {
        $whereClauses[] = "Zone LIKE :zone";
        $params[':zone'] = "%" . $_GET['zone'] . "%";
    }
    if (!empty($_GET['division'])) {
        $whereClauses[] = "Division LIKE :division";
        $params[':division'] = "%" . $_GET['division'] . "%";
    }

    $whereSql = '';
    if ($whereClauses) {
        $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
    }

    $itemsPerPage = 10;
    $offset = (isset($_GET['page']) ? $_GET['page'] - 1 : 0) * $itemsPerPage;


    $countQuery = "SELECT COUNT(*) as total FROM $table $whereSql";
    $countStmt = $conn->prepare($countQuery);
    foreach ($params as $key => &$val) {
        $countStmt->bindParam($key, $val);
    }
    if ($countStmt->execute() === false) {
        throw new Exception('Error executing statement: ' . implode(', ', $countStmt->errorInfo()));
    }

    $totalCount = $countStmt->fetchColumn();
    $totalPages = ceil($totalCount / $itemsPerPage);


    $query = "SELECT * FROM $table $whereSql LIMIT $itemsPerPage OFFSET $offset";
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

    echo json_encode(['data' => $result, 'page' => isset($_GET['page']) ? $_GET['page'] : 1, 'totalPages' => $totalPages]);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}

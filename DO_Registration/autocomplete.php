<?php
include '../PHP/db_config.php';

$input = json_decode(file_get_contents("php://input"), true);
$query = $input['query'];
$type = $input['type'];

if ($type === 'school') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM institutions 
                            WHERE InstType = 'SC' 
                            AND (New_CenCode LIKE :query OR New_InstitutionName LIKE :query) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bindParam(':query', $likeQuery);
} elseif ($type === 'provincial') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM institutions 
                            WHERE InstType = 'PD' 
                            AND (New_CenCode LIKE :query OR New_InstitutionName LIKE :query) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bindParam(':query', $likeQuery);
} elseif ($type === 'zonal') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM institutions 
                            WHERE InstType = 'ZN' 
                            AND (New_CenCode LIKE :query OR New_InstitutionName LIKE :query) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bindParam(':query', $likeQuery);
} elseif ($type === 'divisional') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM institutions 
                            WHERE InstType = 'ED' 
                            AND (New_CenCode LIKE :query OR New_InstitutionName LIKE :query) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bindParam(':query', $likeQuery);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);

$conn = null;

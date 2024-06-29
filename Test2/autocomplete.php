<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3308;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents("php://input"), true);
$query = $input['query'];
$type = $input['type'];

if ($type === 'school') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM Institutions 
                            WHERE InstType = 'SC' 
                            AND (New_CenCode LIKE ? OR New_InstitutionName LIKE ?) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
} elseif ($type === 'provincial') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM Institutions 
                            WHERE InstType = 'PD' 
                            AND (New_CenCode LIKE ? OR New_InstitutionName LIKE ?) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
} elseif ($type === 'zonal') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM Institutions 
                            WHERE InstType = 'ZN' 
                            AND (New_CenCode LIKE ? OR New_InstitutionName LIKE ?) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
} elseif ($type === 'divisional') {
    $stmt = $conn->prepare("SELECT New_CenCode, New_InstitutionName 
                            FROM Institutions 
                            WHERE InstType = 'ED' 
                            AND (New_CenCode LIKE ? OR New_InstitutionName LIKE ?) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
}

$stmt->execute();
$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);

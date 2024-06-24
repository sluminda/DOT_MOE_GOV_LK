<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents("php://input"), true);
$query = $input['query'];
$type = $input['type'];

if ($type === 'school') {
    $stmt = $conn->prepare("SELECT cencode, institutionname 
                            FROM institutes 
                            WHERE schooltype IN (1, 3) 
                            AND (cencode LIKE ? OR institutionname LIKE ?) 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
} elseif ($type === 'provincial') {
    $stmt = $conn->prepare("SELECT institutionname 
                            FROM institutes 
                            WHERE institutionname LIKE ? 
                            AND schooltype = 8 
                            AND institutionname LIKE '%PROVINCIAL DEPARTMENT OF EDUCATION%' 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("s", $likeQuery);
} elseif ($type === 'zonal') {
    $stmt = $conn->prepare("SELECT institutionname 
                            FROM institutes 
                            WHERE institutionname LIKE ? 
                            AND schooltype = 8 
                            AND institutionname LIKE '%ZONAL EDUCATION OFFICE%' 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("s", $likeQuery);
} elseif ($type === 'divisional') {
    $stmt = $conn->prepare("SELECT institutionname 
                            FROM institutes 
                            WHERE institutionname LIKE ? 
                            AND schooltype = 8 
                            AND institutionname LIKE '%DIVISIONAL EDUCATION OFFICE%' 
                            LIMIT 10");
    $likeQuery = "%$query%";
    $stmt->bind_param("s", $likeQuery);
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

<?php
// fetch_suggestions.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3308;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['q'];
$sql = "SELECT school_name FROM schools WHERE school_name LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);
$like_query = "%{$query}%";
$stmt->bind_param('s', $like_query);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['school_name'];
    }
}

$stmt->close();
$conn->close();
echo json_encode($suggestions);

<?php
// fetch_suggestions_province.php
include 'db_connect.php';

$query = $_GET['q'];
$sql = "SELECT institutionname
    FROM institutes
    WHERE institutionname LIKE ?
    AND schooltype = 8
    AND institutionname LIKE '%PROVINCIAL DEPARTMENT OF EDUCATION%'
    LIMIT 10";

$stmt = $conn->prepare($sql);
$like_query = "%{$query}%"; // This line is correct for preparing LIKE query
$stmt->bind_param('s', $like_query); // Only one parameter is needed here
$stmt->execute();
$result = $stmt->get_result();

$suggestions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['institutionname']; // Only push institutionname to suggestions array
    }
}

$stmt->close();
$conn->close();
echo json_encode($suggestions);

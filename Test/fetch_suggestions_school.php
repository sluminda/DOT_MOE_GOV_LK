<?php
// fetch_suggestions_school.php
include 'db_connect.php';

$query = $_GET['q'];
$sql = "SELECT cencode, institutionname 
    FROM institutes 
    WHERE schooltype IN (1, 3) 
    AND (cencode LIKE ? OR institutionname LIKE ?) 
    LIMIT 10";

$stmt = $conn->prepare($sql);
$like_query = "%{$query}%";
$stmt->bind_param('ss', $like_query, $like_query);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row;
    }
}

$stmt->close();
$conn->close();
echo json_encode($suggestions);

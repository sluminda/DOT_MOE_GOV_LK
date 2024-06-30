<?php
include 'db_connect.php';

try {
    if (!isset($_POST['id'])) {
        throw new Exception('ID is required');
    }

    $id = $_POST['id'];
    $fullName = $_POST['fullName'];
    // Retrieve other fields similarly

    $query = "UPDATE workplace_details SET 
        fullName = :fullName,
        -- add other fields here
        WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
    // Bind other parameters similarly

    if ($stmt->execute() === false) {
        throw new Exception('Error executing statement: ' . implode(', ', $stmt->errorInfo()));
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}

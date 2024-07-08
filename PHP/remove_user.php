<?php
session_start();
require './db_config.php';

if (!isset($_SESSION['loggedIn'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userType = $_SESSION['userType'];
$loggedInUser = $_SESSION['userName'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // Query to check the user's type
    $sql = "SELECT userType FROM userlogin WHERE userName = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['userType'] === 'owner') {
            echo json_encode(['success' => false, 'message' => 'Cannot remove owner']);
            exit;
        }

        if ($userType === 'Super Admin' && $result['userType'] !== 'Admin') {
            echo json_encode(['success' => false, 'message' => 'Super Admin can only remove Admins']);
            exit;
        }

        if ($username === $loggedInUser) {
            echo json_encode(['success' => false, 'message' => 'Cannot remove your own account']);
            exit;
        }

        // Query to delete the user
        $sql = "DELETE FROM userlogin WHERE userName = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove user']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

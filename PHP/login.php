<?php
include './db_connect.php';

session_start();

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['uname'];
    $password = $_POST['pwd'];

    try {
        $sql = "SELECT * FROM userlogin WHERE userName = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['userPassword'])) {
            $_SESSION['username'] = $user['userName'];
            $response['status'] = 'success';
            $response['redirect'] = './welcome.php'; 
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Wrong! Invalid username or password.';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>

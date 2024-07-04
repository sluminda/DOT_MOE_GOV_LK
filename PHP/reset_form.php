<?php
session_start();
require './db_config.php';


// Check if the session is expired
// if (!isset($_SESSION['loginTime']) || (time() - $_SESSION['loginTime'] > 259200)) { // 259200 seconds = 3 days
//     session_unset();
//     session_destroy();
//     header("Location: ../PHP/login.php");
//     exit;
// }

// Check if the user is logged in
// if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
//     header("Location: ../PHP/login.php");
//     exit;
// }

// Check if the user has one of the specified user types
// $allowedUserTypes = ['Admin', 'Super Admin', 'Owner'];
// if (!in_array($_SESSION['userType'], $allowedUserTypes)) {
//     header("Location: ../PHP/login.php");
//     exit;
// }

// Reset login time on each valid request to keep session active
// $_SESSION['loginTime'] = time();

// User is logged in and has the correct user type
// $userLoggedIn = true;
// $userName = $_SESSION['userName'];
// $userType = $_SESSION['userType'];




function redirectToErrorPage()
{
    header('Location: ./error.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['message'] = "Passwords do not match.";
        header('Location: ./reset_form.php?token=' . $token);
        exit();
    }

    try {
        // Begin a transaction
        $conn->beginTransaction();

        // Check if the token is valid and not expired
        $sql = "SELECT email, expiry_time FROM password_resets WHERE token = :token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $row['email'];
            $expiry_time = $row['expiry_time'];

            if (new DateTime() > new DateTime($expiry_time)) {
                $conn->rollBack();
                redirectToErrorPage();
            }

            // Update the user's password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $updateSql = "UPDATE userlogin SET userPassword = :newPassword WHERE userEmail = :email";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);
            $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $updateStmt->execute();

            // Delete the token from the password_resets table
            $deleteSql = "DELETE FROM password_resets WHERE token = :token";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bindParam(':token', $token, PDO::PARAM_STR);
            $deleteStmt->execute();

            // Commit the transaction
            $conn->commit();

            $_SESSION['message'] = "Your password has been reset successfully.";
            header('Location: ./login.php');
            exit();
        } else {
            $conn->rollBack();
            redirectToErrorPage();
        }
    } catch (Exception $e) {
        $conn->rollBack();
        redirectToErrorPage();
    }
} else {
    $token = $_GET['token'];

    // Validate the token and its expiry time before displaying the form
    $sql = "SELECT expiry_time FROM password_resets WHERE token = :token";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0 || new DateTime() > new DateTime($stmt->fetchColumn())) {
        redirectToErrorPage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../CSS/Body/reset_form.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="message"><?php echo $_SESSION['message'];
                                    unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <form action="reset_form.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>

</html>
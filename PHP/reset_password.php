<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../CSS/Body/reset_password.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <form action="forgot_password.php" method="post">
                <h2>Forgot Password</h2>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div class="input-group">
                    <button type="submit">Send Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
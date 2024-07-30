<?php
session_start();
require './db_config.php';
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInput = trim($_POST['userInput']);

    try {

        if (filter_var($userInput, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM userlogin WHERE userEmail = :userInput";
        } else {
            $sql = "SELECT * FROM userlogin WHERE username = :userInput";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userInput', $userInput, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $row['userEmail'];
            $token = bin2hex(random_bytes(50));
            $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiry time set to 1 hour


            $sql = "INSERT INTO password_resets (email, token, expiry_time) VALUES (:email, :token, :expiry_time)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':expiry_time', $expiry_time, PDO::PARAM_STR);
            $stmt->execute();


            $resetLink = "localhost/DOT_MOE_GOV_LK/PHP/reset_form.php?token=$token";
            $mail = new PHPMailer(true);

            try {

                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'dotmoegov@gmail.com';
                $mail->Password   = '';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;


                $mail->setFrom('dotmoegov@gmail.com', 'Password Reset');
                $mail->addAddress($email);


                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body    = "
                            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; padding: 20px; background-color: #ffffff;'>
                                <div style='text-align: center; padding-bottom: 20px;'>
                                    <h1 style='color: #333;'>Password Reset Request</h1>
                                </div>
                                <div style='border-top: 1px solid #e0e0e0; padding-top: 20px;'>
                                    <p style='font-size: 16px; color: #333;'>Dear User,</p>
                                    <p style='font-size: 16px; color: #333;'>We received a request to reset your password. Click the button below to reset your password.</p>
                                    <div style='text-align: center; margin: 20px 0;'>
                                        <a href='$resetLink' style='padding: 10px 20px; background-color: #0077ff; color: #ffffff; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                                    </div>
                                    <p style='font-size: 16px; color: #333;'>If you did not request a password reset, please ignore this email. This password reset link is valid for 1 hour.</p>
                                    <p style='margin-top: 20px; font-size: 16px; color: #333;'><br></p>
                                    <p style='font-size: 14px;'>Best regards,<br>Data Management Branch, <br>Ministry of Education</p>
                                </div>
                            </div>
                                ";

                $mail->AltBody = "
                                Dear User,\n\n
                                We received a request to reset your password. Click the link below to reset your password.\n\n
                                $resetLink\n\n
                                If you did not request a password reset, please ignore this email. This password reset link is valid for 1 hour.\n\n
                                Best regards,\n
                                Data Management Branch,\n
                                Ministry of Education.\n
                            ";

                $mail->send();
                $_SESSION['message'] = "A password reset link has been sent to your email.";
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['message'] = "No account found with that username or email address.";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Something went wrong. Please try again later.";
    }
    header('Location: ./forgot_password.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../Images/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Images/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Images/Favicon/favicon-16x16.png">
    <link rel="manifest" href="../Images/Favicon/site.webmanifest">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../CSS/fonts.css">
    <link rel="stylesheet" href="../CSS/Template/header.css">
    <link rel="stylesheet" href="../CSS/Body/forget_password.css">
    <link rel="stylesheet" href="../CSS/Template/footer.css">

    <script defer src="../JS/header.js"></script>

<body>

    <!-- Header Section -->

    <header class="DF PR">
        <!-- Mobile Navigation Icon-->
        <div class="mobile-nav-container open">
            <i class="fa-solid fa-2x fa-bars"></i>
        </div>

        <div class="mobile-nav-container close hidden">
            <i class="fa-solid fa-2x fa-xmark"></i>
        </div>

        <!-- Mobile Navigation -->
        <nav class="mobile-nav hidden-effect">
            <ul>
                <li><a href="../index.html">
                        <div><i class="fa-solid fa-house"></i></div>
                        <h3>Home</h3>
                    </a>
                </li>

                <li><a href="../Pages/Contributors.html">
                        <div><i class="fa-solid fa-handshake-angle"></i></div>
                        <h3>Contributors</h3>
                    </a>
                </li>

                <li><a href="../Pages/Gallery.html">
                        <div><i class="fa-regular fa-images"></i></div>
                        <h3>Gallery</h3>
                    </a>
                </li>

                <li><a href="../Contact_Us/contact_us.php">
                        <i class="fa-solid fa-phone"></i>
                        <h3>Contact</h3>
                    </a>
                </li>
            </ul>
        </nav>



        <!-- Mobile Navigation Logo -->
        <div class="mobile-gov-logo-container mbglc1">
            <img src="../Images/Header/MOE logo Light mode.png" alt="Mobile_Gov_Logo">
        </div>

        <!-- Mobile Navigation Logo -->
        <div class="mobile-gov-logo-container mbglc2 hidden">
            <img src="../Images/Header/MOE logo Darkmode.png" alt="Mobile_Gov_Logo">
        </div>

        <!-- Header Logo Container  -->
        <div class=" gov-logo-container DG PR center">

            <!-- Header Logo Grid Left -->
            <div class="gov-logo DF">
                <img loading="lazy" draggable="false" src="../Images/Header/gov_logo.png" alt="GOV_LOGO">
            </div>

            <!-- Header Logo Grid Right -->
            <div class="gov-logo-title">
                <h1>අධ්‍යාපන අමාත්‍යාංශය</h1>
                <h1>கல்வி அமைச்சு</h1>
                <h1>Ministry of Education</h1>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="wide_navigation">
            <ul class="DF PR center">
                <li>
                    <a class="DF FD-R center" href="../index.html">
                        <div>
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <h3>Home</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="../Pages/Contributors.html">
                        <div>
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h3>Contributors</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="../Pages/Gallery.html">
                        <div>
                            <i class="fa-regular fa-images"></i>
                        </div>
                        <h3>Gallery</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="../Contact_Us/contact_us.php">
                        <div>
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <h3>Contact</h3>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Data Officer Logo -->
        <div class="data-officer-logo-container DF PR dolc1">
            <img loading="lazy" class="PR" src="../Images/Header/Data_Officer Logo White.png" alt="Data_officer_Logo">
        </div>

        <div class="data-officer-logo-container DF PR dolc2 hidden">
            <img loading="lazy" class="PR" src="../Images/Header/Data_Officer Logo Dark.png" alt="Data_officer_Logo">
        </div>

        <!-- Dark Mode  -->
        <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" />
                <div class="slider round"></div>
            </label>
            <em class="mode1">Enable Dark Mode</em>
            <em class="mode2 hidden">Disable Dark Mode</em>
        </div>

    </header>


    <div class="container">
        <div>
            <h2>Forgot Password</h2>
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="message"><?php echo $_SESSION['message'];
                                        unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <form action="forgot_password.php" method="post">
                <div class="form-group">
                    <label for="userInput">Username or Email</label>
                    <input type="text" id="userInput" name="userInput" required>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>


    <!-- Footer Starts Here -->
    <footer class="footer DF FD-C PR">
        <!-- Contact Section -->
        <section class="contact DG PR">
            <!-- Google Map Column -->
            <div class="location DF FD-C PR center">
                <h3>Google Map</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3960.9941086631047!2d79.930527!3d6.891307!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2517dc82a9fef%3A0xa2cb100ac511407c!2sMinistry%20of%20Education!5e0!3m2!1sen!2sus!4v1712734841372!5m2!1sen!2sus" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div id="contact" class="contact_details DF FD-C PR">
                <h3>Contact Details</h3>
                <div>
                    <div class="address DF FD-R PR center">
                        <i class="fa-solid fa-1x fa-location-dot"></i>
                        <p>
                            Data Management Branch,<br>
                            3rd Floor,<br>
                            Ministry of Education,<br>
                            Isurupaya,<br>
                            Battaramulla,<br>
                            SriLanka.
                        </p>
                    </div>

                    <div class="phone DF FD-R PR">
                        <i class="fa-solid fa-1x fa-phone"></i>
                        <p>+94 11-2784837</p>
                    </div>

                    <div class="phone DF FD-R PR">
                        <i class="fa-solid fa-1x fa-phone"></i>
                        <p>+94 11-2075854</p>
                    </div>

                    <div class="email DF FD-R PR">
                        <i class="fa-solid fa-envelope"></i>
                        <p>dataofficermoe@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="links DF FD-C PR center">
                <h3>Related Links</h3>
                <ul class="DF FD-C PR ">
                    <li><a target="_blank" href="https://moe.gov.lk/">Ministry of Education</a></li>
                    <li><a target="_blank" href="https://www.doenets.lk/">Department of Examinations</a></li>
                    <li><a target="_blank" href="http://www.edupub.gov.lk/">Education Publication Department</a></li>
                    <li><a target="_blank" href="http://www.statistics.gov.lk/">Department of Census and Statics</a>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Horizontal Line -->
        <div class="horizontal-line-footer"></div>
        <!-- Section Copyright -->

        <section class="copyright">
            <p>Copyright © 2024 Data Management Branch,
                Ministry of Education.</p>
        </section>
    </footer>

</body>

</html>
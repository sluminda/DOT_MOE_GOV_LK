<?php
session_start();
require 'db_connect.php';

$fullName_error = '';
$nameWithInitials_error = '';
$nic_error = '';
$contactNo_error = '';
$general_error = '';
$success_message = '';

$fullName = $nameWithInitials = $nic = $schoolName = $schoolSensusNo = $district = $province = $zone = $contactNo = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = htmlspecialchars(trim($_POST['fullName']));
    $nameWithInitials = htmlspecialchars(trim($_POST['nameWithInitials']));
    $nic = htmlspecialchars(trim($_POST['nic']));
    $schoolName = htmlspecialchars(trim($_POST['schoolName']));
    $schoolSensusNo = htmlspecialchars(trim($_POST['schoolSensusNo']));
    $district = htmlspecialchars(trim($_POST['district']));
    $province = htmlspecialchars(trim($_POST['province']));
    $zone = htmlspecialchars(trim($_POST['zone']));
    $contactNo = htmlspecialchars(trim($_POST['contactNo']));
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify reCAPTCHA
    $secretKey = "YOUR_SECRET_KEY";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        $general_error = "Please complete the CAPTCHA.";
    } else {
        // Validate fields
        if (!preg_match("/^[a-zA-Z ]*$/", $fullName)) {
            $fullName_error = "Only letters and white space allowed in Full Name.";
        }
        if (!preg_match("/^[a-zA-Z. ]*$/", $nameWithInitials)) {
            $nameWithInitials_error = "Only letters and white space allowed in Name with Initials.";
        }
        if (!preg_match("/^[0-9A-Za-z]{9,12}$/", $nic)) {


            $nic_error = "NIC must be 9-12 letters and numbers.";
        }
        if (!preg_match("/^0[0-9]{9}$/", $contactNo)) {
            $contactNo_error = "Contact number must be 10 digits and start with 0.";
        }

        if (empty($fullName_error) && empty($nameWithInitials_error) && empty($nic_error) && empty($contactNo_error)) {
            try {
                $sql = "INSERT INTO data_officers (fullName, nameWithInitials, nic, schoolName, schoolSensusNo, district, province, zone, contactNo) VALUES (:fullName, :nameWithInitials, :nic, :schoolName, :schoolSensusNo, :district, :province, :zone, :contactNo)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':fullName', $fullName);
                $stmt->bindParam(':nameWithInitials', $nameWithInitials);
                $stmt->bindParam(':nic', $nic);
                $stmt->bindParam(':schoolName', $schoolName);
                $stmt->bindParam(':schoolSensusNo', $schoolSensusNo);
                $stmt->bindParam(':district', $district);
                $stmt->bindParam(':province', $province);
                $stmt->bindParam(':zone', $zone);
                $stmt->bindParam(':contactNo', $contactNo);
                $stmt->execute();

                $success_message = "Data Officer registered successfully!";
                // Clear the form values after successful registration
                $fullName = $nameWithInitials = $nic = $schoolName = $schoolSensusNo = $district = $province = $zone = $contactNo = '';
            } catch (PDOException $e) {
                $general_error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Officer Registration</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../Images/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Images/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Images/Favicon/favicon-16x16.png">
    <link rel="manifest" href="../Images/Favicon/site.webmanifest">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../CSS/fonts.css">
    <link rel="stylesheet" href="../CSS/Template/header.css">
    <link rel="stylesheet" href="../CSS/Body/data_officer_registration.css">
    <link rel="stylesheet" href="../CSS/Template/footer.css">

    <script defer src="../JS/header.js"></script>
    <script defer src="../JS/data_officer_registration.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

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

                <li><a href="#contact">
                        <div><i class="fa-regular fa-address-book"></i></div>
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

    <!-- Body Content Starts -->
    <main class="login-background_container DF PR FD-C">
        <div class="DF FD-C PR center">
            <header class="DF FD-R PR center">
                <i class="fa-solid fa-2x fa-user-plus"></i>
                <h2> Data Officer Registration</h2>
            </header>
            <?php if ($general_error) : ?>
                <div id="general-error" class="message error-message"><?php echo $general_error; ?></div>
            <?php endif; ?>
            <?php if ($fullName_error) : ?>
                <div id="fullName-error" class="message error-message"><?php echo $fullName_error; ?></div>
            <?php endif; ?>
            <?php if ($nameWithInitials_error) : ?>
                <div id="nameWithInitials-error" class="message error-message"><?php echo $nameWithInitials_error; ?></div>
            <?php endif; ?>
            <?php if ($nic_error) : ?>
                <div id="nic-error" class="message error-message"><?php echo $nic_error; ?></div>
            <?php endif; ?>
            <?php if ($contactNo_error) : ?>
                <div id="contactNo-error" class="message error-message"><?php echo $contactNo_error; ?></div>
            <?php endif; ?>
            <?php if ($success_message) : ?>
                <div id="success-message" class="message success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form class="login-form DF FD-C PR center" action="./data_officer_registration.php" method="post" onsubmit="return validateForm();">
                <div class="login_row DG PR">
                    <label for="fullName">Full Name</label>
                    <input id="fullName" name="fullName" type="text" value="<?php echo htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div id="fullName-error" class="message error-message" style="display: none;"></div>
                </div>

                <div class="login_row DG PR">
                    <label for="nameWithInitials">Name with Initials</label>
                    <input id="nameWithInitials" name="nameWithInitials" type="text" value="<?php echo htmlspecialchars($nameWithInitials, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div id="nameWithInitials-error" class="message error-message" style="display: none;"></div>
                </div>

                <div class="login_row DG PR">
                    <label for="nic">NIC</label>
                    <input id="nic" name="nic" type="text" value="<?php echo htmlspecialchars($nic, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div id="nic-error" class="message error-message" style="display: none;"></div>
                </div>

                <div class="login_row DG PR">
                    <label for="schoolName">School Name</label>
                    <textarea rows="3" name="schoolName" id="schoolName" value="<?php echo htmlspecialchars($schoolName, ENT_QUOTES, 'UTF-8'); ?>" required></textarea>

                </div>

                <div class="login_row DG PR">
                    <label for="schoolSensusNo">School Sensus No</label>
                    <input id="schoolSensusNo" name="schoolSensusNo" type="text" value="<?php echo htmlspecialchars($schoolSensusNo, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div id="schoolSensusNo-error" class="message error-message" style="display: none;"></div>
                </div>


                <div class="login_row DG PR">
                    <label for="province">Province</label>
                    <select id="province" name="province" required>
                        <option value="" disabled selected>Select Province</option>
                        <option value="Central Province">Central Province</option>
                        <option value="Eastern Province">Eastern Province</option>
                        <option value="Northern Province">Northern Province</option>
                        <option value="Southern Province">Southern Province</option>
                        <option value="Western Province">Western Province</option>
                        <option value="North Western Province">North Western Province</option>
                        <option value="North Central Province">North Central Province</option>
                        <option value="Uva Province">Uva Province</option>
                        <option value="Sabaragamuwa Province">Sabaragamuwa Province</option>
                    </select>
                </div>

                <div class="login_row DG PR">
                    <label for="district">District</label>
                    <select id="district" name="district" required disabled>
                        <option value="" disabled selected>Select District</option>
                    </select>
                </div>

                <div class="login_row DG PR">
                    <label for="zone">Zone</label>
                    <input id="zone" name="zone" type="text" value="<?php echo htmlspecialchars($zone, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="login_row DG PR">
                    <label for="contactNo">Contact No</label>
                    <input id="contactNo" name="contactNo" type="text" value="<?php echo htmlspecialchars($contactNo, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div id="contactNo-error" class="message error-message" style="display: none;"></div>
                </div>
                <br>
                <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
                <div class="login_row DG PR"><br>
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </main>

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
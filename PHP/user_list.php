<?php
session_start();
require './db_config.php';

// Ensure that the user is logged in
if (!isset($_SESSION['loggedIn'])) {
    header("Location: ./login.php");
    exit;
}

// Store the logged-in username for comparison
$loggedInUser = $_SESSION['userName'];

// User is logged in, set user details
$userLoggedIn = true;
$userName = $_SESSION['userName'];
$userType = $_SESSION['userType'];

// Ensure that only Super Admin and Owner can access this page
if (!in_array($userType, ['Super Admin', 'Owner'])) {
    header("Location: ./login.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../Images/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Images/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Images/Favicon/favicon-16x16.png">
    <link rel="manifest" href="../Images/Favicon/site.webmanifest">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../CSS/fonts.css">
    <link rel="stylesheet" href="../CSS/Template/header.css">
    <link rel="stylesheet" href="../CSS/Body/user_list.css">
    <link rel="stylesheet" href="../CSS/Template/footer.css">

    <script defer src="../JS/header.js"></script>
    <script src="../JS/user_list.js"></script>
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
                <?php if ($userLoggedIn) : ?>
                    <li class="mobile_login_container">
                        <div class="user_info_container">
                            <img src="../Images/Header/profile.png" alt="User Image" class="user_image">
                            <div class="user_info">
                                <span class="user_name"><?php echo htmlspecialchars("Hello " . $userName); ?></span>
                                <span class="user_type"><?php echo htmlspecialchars($userType); ?></span>
                            </div>
                            <form class="DF PR" action="logout.php" method="post">
                                <button type="submit" class="logout_btn">Log Out</button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
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
                <li><a class="DF FD-R center" href="./Contact_Us/contact_us.php">
                        <div>
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <h3>Contact</h3>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Wide Login Container -->
        <div class="wide_login_container <?php echo $userLoggedIn ? '' : 'hidden'; ?>">
            <div class="user_icon_container">
                <i class="fa-solid fa-user"></i>
                <span class="greeting_text">Hello, <br><em><?php echo htmlspecialchars($userName); ?></em></span>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <?php if ($userLoggedIn) : ?>
                <div class="dropdown">
                    <div class="user_info_container">
                        <img src="../Images/Header/profile.png" alt="User Image" class="user_image">
                        <div class="user_info">
                            <span class="user_name"><?php echo htmlspecialchars($userName); ?></span>
                            <span class="user_type"><?php echo htmlspecialchars($userType); ?></span>
                        </div>
                    </div>
                    <form action="logout.php" method="post">
                        <button type="submit" class="logout_btn">Log Out</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

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
    <main class="main_container DF PR FD-C">
        <header> - User List - </header>

        <div class="create_button_container">
            <button onclick="window.location.href='./register.php'">Create User</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>User Type</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to select data from the userlogin table using PDO
                $sql = "SELECT userName, userEmail, userPhoneNumber, userType FROM userlogin";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($results) {
                    // Output data of each row
                    foreach ($results as $row) {
                        echo "<tr id='user-" . htmlspecialchars($row["userName"]) . "'>
                    <td>" . htmlspecialchars($row["userName"]) . "</td>
                    <td>" . htmlspecialchars($row["userEmail"]) . "</td>
                    <td>" . htmlspecialchars($row["userPhoneNumber"]) . "</td>
                    <td>" . htmlspecialchars($row["userType"]) . "</td>
                    <td class='actions'>";

                        // Owner can remove anyone except themselves
                        if ($userType === 'Owner' && $row["userName"] !== $loggedInUser) {
                            echo "<button onclick=\"removeUser('" . htmlspecialchars($row["userName"]) . "')\">Remove</button>";
                        }

                        // Super Admin can only remove Admins and not themselves
                        if ($userType === 'Super Admin' && $row["userType"] === 'Admin' && $row["userName"] !== $loggedInUser) {
                            echo "<button onclick=\"removeUser('" . htmlspecialchars($row["userName"]) . "')\">Remove</button>";
                        }

                        echo "</td>
                  </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
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



<body>

</body>

</html>
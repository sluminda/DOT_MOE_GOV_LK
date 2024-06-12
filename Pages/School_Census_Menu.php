<?php
session_start();

if (isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];
}

$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'sinhala';


$sinhalaTranslations = [
    'header' => '- වාර්ෂික පාසල් සංගණනය -',
    'census2023' => 'පාසල් සංගණනය 2023',
    'censusRecords' => 'සංගණන ලේඛන',
    'trainingMaterials' => 'පුහුණු ආධාරක',
    'census2022Records' => 'පාසල් සංගණන ලේඛන 2022'
];

$tamilTranslations = [
    'header' => '- வருடாந்த பாடசாலை கணக்கெடுப்பு -',
    'census2023' => ' பாடசாலை கணக்கெடுப்பு 2023',
    'censusRecords' => 'கணக்கெடுப்பு ஆவணங்கள்',
    'trainingMaterials' => 'பயிற்சி உதவிச் சாதனங்கள்',
    'census2022Records' => 'பாடசாலை கணக்கெடுப்பு 2022'
];

$translations = $language === 'tamil' ? $tamilTranslations : $sinhalaTranslations;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../CSS/fonts.css">
    <link rel="stylesheet" href="../CSS/Template/header.css">
    <link rel="stylesheet" href="../CSS/Body/school_census_menu.css">
    <link rel="stylesheet" href="../CSS/Template/footer.css">

    <script defer src="../JS/header.js"></script>
    <script defer src="../JS/census_menu.js"></script>
    <script defer src="../JS/census_translate.js"></script>
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

                <li><a href="./Contributors.html">
                        <div><i class="fa-solid fa-handshake-angle"></i></div>
                        <h3>Contributors</h3>
                    </a>
                </li>

                <li><a href="./Gallery.html">
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
                <li><a class="DF FD-R center" href="./Contributors.html">
                        <div>
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h3>Contributors</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="./Gallery.html">
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


    <main class="census_container DF PR FD-C">
        <header><?php echo $translations['header']; ?></header>
        <section class="census_menu_container DG PR">
            <div class="census_menu_left DF PR center">
                <div id="year2023" class="census_modules_container AA DF selected">
                    <h4>2023</h4>
                </div>
                <div id="year2022" class="census_modules_container BB DF">
                    <h4>2022</h4>
                </div>
            </div>

            <div class="census_menu_right DF FD-C PR">
                <div class="census_btns_container CC PR">
                    <header><?php echo $translations['census2023']; ?></header>
                    <div class="btn_box_1 DF FD-R PR">
                        <a href="#"><?php echo $translations['censusRecords']; ?></a>
                    </div>
                    <div class="btn_box_2 DF FD-R PR">
                        <a href="#"><?php echo $translations['trainingMaterials']; ?></a>
                    </div>
                </div>
                <div class="census_btns_container DD PR center hidden">
                    <header><?php echo $translations['census2022Records']; ?></header>
                    <div class="btn_box_3 DF FD-R PR">
                        <a href="#"><?php echo $translations['censusRecords']; ?></a>
                    </div>
                    <div class="btn_box_4 DF FD-R PR">
                        <a href="#"><?php echo $translations['trainingMaterials']; ?></a>
                    </div>
                </div>
            </div>

        </section>
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="./CSS/fonts.css">
    <link rel="stylesheet" href="./CSS/Template/header.css">
    <link rel="stylesheet" href="./CSS/Body/home.css">
    <link rel="stylesheet" href="./CSS/Template/footer.css">

    <script defer src="./JS/home.js"></script>
    <script defer src="./JS/header.js"></script>
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
                <li><a href="./index.html">
                        <div><i class="fa-solid fa-house"></i></div>
                        <h3>Home</h3>
                    </a>
                </li>

                <li><a href="#training-module">
                        <div><i class="fa-solid fa-person-chalkboard"></i></div>
                        <h3>Training Module</h3>
                    </a>
                </li>

                <li><a href="./Pages/Contributors.html">
                        <div><i class="fa-solid fa-handshake-angle"></i></i></div>
                        <h3>Contributors</h3>
                    </a>
                </li>

                <li><a href="#notices">
                        <div><i class="fa-regular fa-flag"></i></div>
                        <h3>Notices</h3>
                    </a>
                </li>

                <li><a href="#news">
                        <div><i class="fa-regular fa-newspaper"></i></div>
                        <h3>News</h3>
                    </a>
                </li>

                <li><a href="./Pages/Gallery.html">
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
            <img src="./Images/Header/MOE logo Light mode.png" alt="Mobile_Gov_Logo">
        </div>

        <!-- Mobile Navigation Logo -->
        <div class="mobile-gov-logo-container mbglc2 hidden">
            <img src="./Images/Header/MOE logo Darkmode.png" alt="Mobile_Gov_Logo">
        </div>

        <!-- Header Logo Container  -->
        <div class=" gov-logo-container DG PR center">

            <!-- Header Logo Grid Left -->
            <div class="gov-logo DF">
                <img loading="lazy" draggable="false" src="./Images/Header/gov_logo.png" alt="GOV_LOGO">
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
                    <a class="DF FD-R center" href="./index.html">
                        <div>
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <h3>Home</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="./Pages/Contributors.html">
                        <div>
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h3>Contributors</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="./Pages/Gallery.html">
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
            <img loading="lazy" class="PR" src="./Images/Header/Data_Officer Logo White.png" alt="Data_officer_Logo">
        </div>

        <div class="data-officer-logo-container DF PR dolc2 hidden">
            <img loading="lazy" class="PR" src="./Images/Header/Data_Officer Logo Dark.png" alt="Data_officer_Logo">
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
    <main class="DF PR FD-C">

        <!-- Section Hero -->
        <section class="hero DG PR">
            <figure class="DF PR">
                <img loading="lazy" src="./Images/Body/Home/slider-2.png" alt="ClipArt">
            </figure>
            <article class=" DF FD-C center">
                <h1>National, Provincial, Zonal, Divisional and School Level Data officers</h1>

                <p>The Data Officer's primary focus is to ensure that an organization's data is accurate, consistent,
                    and secure while also being accessibl and available to authorized users for analysis and
                    decision-making.
                    The data officer is typically responsible for creating and implementing policies and procedures to
                    ensure the effective and efficient use of data and they may work closely with other organizations
                    to establish data governance frameworks. They may also be responsible for managing data quality,
                    developing data architectures, and overseeing data-related projects and initiatives.</p>
            </article>
        </section>

        <!-- Horizontal Line -->
        <!-- <div class="horizontal-line"></div> -->

        <!-- Section Objectives -->
        <section class="objectives DG PR">

            <!-- left side -->
            <div class="object_container DF FD-C PR center">
                <figure class="DF FD-R center">
                    <i class="fa-regular fa-2x fa-eye"></i>
                    <figcaption>Vision</figcaption>
                </figure>
                <p>Enhance the efficiency and equity of general education through an educational data culture in Sri
                    Lanka.</p>
            </div>

            <!-- Right Side  -->
            <div class="object_container DF FD-C PR center">
                <figure class="DF FD-R center">
                    <i class="fa-solid fa-2x fa-bullseye"></i>
                    <figcaption>Mission</figcaption>
                </figure>
                <p>Ensure accurate and timely general educational data to advance general education sector in Sri Lanka.
                </p>
            </div>
        </section>

        <!-- Horizontal Line -->
        <!-- <div class="horizontal-line"></div> -->

        <!-- Section Training Area -->
        <section id="training-module" class="training DG PR">
            <div class="module_title_container DF FD-R PR center">

                <h2>
                    <i class="fa-regular fa-circle-right fa-beat-fade" style="color: red; --fa-beat-fade-opacity: 0.1; --fa-beat-fade-scale: 1.1; font-size: 30px;"></i>

                    &nbsp; &nbsp;Training Modules For Data Officers At Provincial, Zonal, Divisional And School
                    Level


                    <!-- <i class="fa-solid fa-certificate fa-beat-fade"
                        style="color: red; --fa-beat-fade-opacity: 0.1; --fa-beat-fade-scale: 1.25;"></i> -->
                </h2>


            </div>

            <!-- Training Modules  -->
            <div class=" training_modules DG">

                <div class="modules_container DF FD-C PR">
                    <h3>Guideline for School Data Officer</h3>
                    <ul class="guidline-box DF PR FD-R">
                        <li><a href="./PDF/userguide_sinhala.pdf">Sinhala</a></li>
                        <li><a href="./PDF/userguide_tamil.pdf">Tamil</a></li>
                        <li><a href="./PDF/userguide_english.pdf">English</a></li>
                    </ul>
                </div>

                <div class="modules_container DF FD-C PR">
                    <h3>Data Officer Self Registration</h3>
                    <ul class="DF PR FD-R">
                        <li><a href="./PHP/data_officer_registration.php">Register</a></li>
                    </ul>
                </div>

                <div class="modules_container DF FD-C PR">
                    <h3>Data Officer Trainings</h3>
                    <ul class="DF PR FD-R">
                        <li><a href="https://tt.e-thaksalawa.moe.gov.lk/login/index.php">Enroll</a></li>
                    </ul>
                </div>

                <div class="modules_container DF FD-C PR">
                    <h3>Annual School Census</h3>
                    <form action="./Pages/School_Census_Menu.php" method="POST">
                        <ul class="DF PR FD-R">
                            <li><button type="submit" name="language" value="sinhala">Sinhala</button></li>
                            <li><button type="submit" name="language" value="tamil">Tamil</button></li>
                        </ul>
                    </form>
                </div>

                <div class="modules_container DF FD-C PR">
                    <h3>Data Officer Detail List</h3>
                    <ul class="DF PR FD-R">
                        <li><a href="./PHP/login.php">View</a></li>
                    </ul>
                </div>

                <div class="modules_container DF FD-C PR">
                    <h3>Other Trainings</h3>
                    <ul class="DF PR FD-R">
                        <li><a href="#">View</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Horizontal Line -->
        <!-- <div class="horizontal-line"></div> -->

        <section class="programme">
            <article class="DF FD-C PR center">

                <h2>Sri Lankan Education Data Management Revolution Begins...</h2>

                <p>Korea International Cooperation Agency (KOICA) and Korean Educational Development Institute
                    (KEDI) are striving to carry out development cooperation programmes with the Ministry of
                    Education (MoE), Sri Lanka under the mission of promoting the sustainability of educational data
                    management.
                </p>

                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis autem culpa, voluptas, explicabo id
                    soluta quae iste amet ad dolor, magni architecto qui asperiores ullam! Nostrum perspiciatis
                    voluptatibus tempora illum?

                    <a href="./PDF/Data-Management.pdf">Read More..</a>
                </p>

            </article>
        </section>

        <!-- Horizontal Line -->
        <!-- <div class="horizontal-line"></div> -->

        <!-- Statement Section -->
        <section class="statements DF PR FD-R">

            <!-- Susil Premajayantha -->
            <article>
                <figure>
                    <img loading="lazy" src="./Images/Body/Home/Statement/Susil-min.jpg" alt="Minister">
                    <figcaption>Statement of the Hon. Minister of Education</figcaption>
                </figure>
                <p>Capacity building is one of the vital facts in the improvement of efficiency and effectiveness of
                    organizations as well as individuals. It helps to identify the strength and weaknesses...</p>
                <a href="./Pages/Susil_Premajayantha.html">Read More..</a>
            </article>

            <!-- Thilaka Jayasundara -->
            <article>
                <figure>
                    <img loading="lazy" src="./Images/Body/Statements/Jayasundara_cropped-min.jpg" alt="Secretary">
                    <figcaption>Statement of the Secretary of Education</figcaption>
                </figure>
                <p>The role of the data officer is a complex one that requires a range of technical and analytical
                    skills, as well as an understanding of education policies and practices.Therefore, it is...</p>
                <a href="./Pages/Thilaka_Jayasundara.html">Read More..</a>
            </article>

            <!-- K.P Munagamuwa -->
            <article>
                <figure>
                    <img loading="lazy" src="./Images/Body/Statements/Munagama.jpg" alt="Additional Secretary">
                    <figcaption>Statement of the Additional Secretary of Education</figcaption>
                </figure>
                <p>As the Additional Secretary to the Information Technology and Digital Education, I strongly believe
                    that training of data officers in educational organizations is essential for the successful...</p>
                <a href="./Pages/K.P._Munagama.html">Read More..</a>
            </article>

            <!-- Dakshina Kasthuriarachchi -->
            <article>
                <figure>
                    <img loading="lazy" src="./Images/Body/Statements/Dakshina.jpg" alt="Director">
                    <figcaption>Statement of the Director of Education</figcaption>
                </figure>
                <p>As the Director of Education (DM and ISDU), I believe that training of data officers in educational
                    organizations is critical for ensuring that data is managed effectively and used to...</p>
                <a href="./Pages/Dakshina_Kasturiarachchi.html">Read More..</a>
            </article>

            <!-- H. A. S. P. Senarathne -->
            <article>
                <figure>
                    <img loading="lazy" src="./Images/Body/Statements/Saumya.jpg" alt="Deputy Director">
                    <figcaption>Statement of the Deputy Director of Education</figcaption>
                </figure>
                <p>As the subject officer who involved in nominating data officers at provincial, zonal, divisional and
                    school levels in educational organizations, I strongly believe that training and...</p>
                <a href="./Pages/H.A.S.P._Senarathne.html">Read More..</a>
            </article>
        </section>

        <!-- Horizontal Line -->
        <!-- <div class="horizontal-line"></div> -->

        <!-- Notice Section -->
        <section class="noticeboard DG PR ">
            <!-- Special Notice -->
            <article class="DF FD-C PR">
                <header class="DF PR FD-R center">
                    <h2>-</h2>
                    <i class="fa-regular fa-2x fa-flag"></i>
                    <h2 id="notices">Notices -</h2>
                </header>
                <ul class="DF FD-C PR">
                    <li>Annual School Census 2023</li>
                    <p>The process of entering student information into the new online system will begin on 29 th May
                        2022</p>
                    <li>Annual School Census 2023</li>
                    <p>Based on March 1, 2023, School Principals and Teachers information should be provided at the
                        school level by 31 st May 2023 through Google Form. Due date is 31 st May 2023.</p>
                </ul>
            </article>

            <!-- News SlideShow -->
            <div class="slideshow DF FD-C PR">
                <header class="DF PR FD-R center">
                    <h2>-</h2>
                    <i class="fa-regular fa-2x fa-newspaper"></i>
                    <h2 id="news">News -</h2>
                </header>

                <!-- Slideshow container -->
                <div class="slideshow-container DF FD-C center">

                    <!-- Full-width images with number and caption text -->
                    <div class="mySlides fade center PR">
                        <div class="numbertext PR">1 / 3</div>
                        <img loading="lazy" src="./Images/Body/Home/SlideShow/1.jpg">
                    </div>

                    <div class="mySlides fade center PR">
                        <div class="numbertext">2 / 3</div>
                        <img loading="lazy" src="./Images/Body/Home/SlideShow/2.jpg">
                    </div>

                    <div class="mySlides fade center PR">
                        <div class="numbertext">3 / 3</div>
                        <img loading="lazy" src="./Images/Body/Home/SlideShow/3.jpg">
                    </div>

                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>

                    <!-- The dots/circles -->
                    <div class="footer_btn">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
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
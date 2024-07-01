<?php
session_start();
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
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
    <link rel="stylesheet" href="../CSS/Body/data_officer_register.css">
    <link rel="stylesheet" href="../CSS/Template/footer.css">

    <script defer src="../JS/header.js"></script>
    <script defer src="../JS/register_form.js"></script>
</head>


<body>
    <?php
    if (isset($_SESSION['message'])) {
        $messageType = $_SESSION['message_type'];
        $messageContent = $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
            unset($_SESSION['form_submitted']);
            echo "<script>localStorage.removeItem('formData');</script>"; // Clear form data in local storage
        }
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showPopup('$messageContent', '$messageType');
                });
              </script>";
    }
    ?>

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



    <!-- Body Content Starts -->
    <main>
        <form id="detailsForm" action="submit_form.php" method="POST">

            <!-- Include form token for CSRF protection -->
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
            <div class="headTitle">
                <h1><i class="fa-solid fa-user-plus"></i></h1>
                <h1>Data Officer Registration Form</h1>
            </div>

            <!-- Personal Details -->
            <fieldset>
                <legend class="legend1">
                    <h2><i class="fa-solid fa-user"></i></h2>
                    <h2>Personal Details</h2>
                </legend>
                <div>
                    <label for="fullName"></i>Full Name:</label>
                    <span id="fullNameError" class="error"></span>
                    <input type="text" id="fullName" name="fullName" required>

                </div>
                <div>
                    <label for="nameWithInitials">Name with Initials:</label>
                    <span id="nameWithInitialsError" class="error"></span>
                    <input type="text" id="nameWithInitials" name="nameWithInitials" required>

                </div>
                <div>
                    <label for="nic">NIC:</label>
                    <span id="nicError" class="error"></span>
                    <input type="text" id="nic" name="nic" required>

                </div>
                <div>
                    <label for="email">Email:</label>
                    <span id="emailError" class="error"></span>
                    <input type="email" id="email" name="email" required>

                    <button type="button" id="sendOtp">Send OTP</button>

                    <!-- form fields go here, as in the original form HTML -->
                    <input type="hidden" id="otpVerified" name="otpVerified" value="false">
                    <div id="otpSection">
                        <div class="msg_contain">
                            <label for="otp">OTP:</label>
                            <div id="otpMessage" class="message" style="display:none;"></div>
                        </div>
                        <input type="text" id="otp" name="otp">
                        <button type="button" id="verifyOtp">Verify OTP</button>
                    </div>

                </div>

                <div>
                    <label for="whatsappNumber">WhatsApp Number:</label>
                    <span id="whatsappNumberError" class="error"></span>
                    <input type="text" id="whatsappNumber" name="whatsappNumber" required>

                </div>
                <div>
                    <label for="mobileNumber">Mobile Number:</label>
                    <span id="mobileNumberError" class="error"></span>
                    <input type="text" id="mobileNumber" name="mobileNumber" required>

                </div>
            </fieldset>

            <!-- Workplace Details -->
            <fieldset>
                <legend class="legend2">
                    <h2><i class="fa-solid fa-briefcase"></i></h2>
                    <h2>Workplace Details</h2>
                </legend>
                <div>
                    <label for="currentWorkingPlace">Current Working Place:</label>
                    <select id="currentWorkingPlace" name="currentWorkingPlace" required>
                        <option value="">Select</option>
                        <option value="school">School</option>
                        <option value="provincialOffice">Provincial Department of Education</option>
                        <option value="zonalOffice">Zonal Education Office</option>
                        <option value="divisionalOffice">Divisional Education Office</option>
                    </select>
                </div>

                <!-- School Details -->
                <div id="schoolDetails" class="workplaceDetails">
                    <label for="schoolName">School Name or Census Code:</label>
                    <span id="schoolNameError" class="error"></span>
                    <input type="text" id="schoolName" name="schoolName">
                    <input type="hidden" id="schoolCodeInput" name="schoolCode" />
                    <input type="hidden" id="schoolNameInput" name="schoolName" />
                    <div id="schoolNameError" class="error-message"></div>
                    <div id="autocompleteSuggestions" class="autocomplete-suggestions"></div>


                    <label for="principleName">Principal Name:</label>
                    <span id="principleNameError" class="error"></span>
                    <input type="text" id="principleName" name="principleName">

                    <label for="principleContact">Principal Contact Number:</label>
                    <span id="principleContactError" class="error"></span>
                    <input type="text" id="principleContact" name="principleContact">
                </div>

                <!-- Provincial Office Details -->
                <div id="provincialDetails" class="workplaceDetails">
                    <label for="provincialName">Name of the Provincial Department of Education:</label>
                    <span id="provincialNameError" class="error"></span>
                    <input type="text" id="provincialName" name="provincialName">
                    <input type="hidden" id="provincialCodeInput" name="provincialCode" />
                    <input type="hidden" id="provincialNameInput" name="provincialName" />
                    <div id="provincialNameError" class="error-message"></div>
                    <div id="autocompleteSuggestionsProvincial" class="autocomplete-suggestions"></div>

                    <label for="provincialHeadOfInstituteName">Head of Institute Name:</label>
                    <span id="provincialHeadOfInstituteNameError" class="error"></span>
                    <input type="text" id="provincialHeadOfInstituteName" name="provincialHeadOfInstituteName">

                    <label for="provincialHeadOfInstituteContact">Head of Institute Contact Number:</label>
                    <span id="provincialHeadOfInstituteContactError" class="error"></span>
                    <input type="text" id="provincialHeadOfInstituteContact" name="provincialHeadOfInstituteContact">
                </div>

                <!-- Zonal Office Details -->
                <div id="zonalDetails" class="workplaceDetails">
                    <label for="zonalName">Name of the Zonal Education Office:</label>
                    <span id="zonalNameError" class="error"></span>
                    <input type="text" id="zonalName" name="zonalName">
                    <input type="hidden" id="zonalCodeInput" name="zonalCode" />
                    <input type="hidden" id="zonalNameInput" name="zonalName" />
                    <div id="zonalNameError" class="error-message"></div>
                    <div id="autocompleteSuggestionsZonal" class="autocomplete-suggestions"></div>

                    <label for="zonalHeadOfInstituteName">Head of Institute Name:</label>
                    <span id="zonalHeadOfInstituteNameError" class="error"></span>
                    <input type="text" id="zonalHeadOfInstituteName" name="zonalHeadOfInstituteName">

                    <label for="zonalHeadOfInstituteContact">Head of Institute Contact Number:</label>
                    <span id="zonalHeadOfInstituteContactError" class="error"></span>
                    <input type="text" id="zonalHeadOfInstituteContact" name="zonalHeadOfInstituteContact">
                </div>

                <!-- Divisional Office Details -->
                <div id="divisionalDetails" class="workplaceDetails">
                    <label for="divisionalName">Divisional Education Office Name:</label>
                    <span id="divisionalNameError" class="error"></span>
                    <input type="text" id="divisionalName" name="divisionalName">
                    <input type="hidden" id="divisionalCodeInput" name="divisionalCode" />
                    <input type="hidden" id="divisionalNameInput" name="divisionalName" />
                    <div id="divisionalNameError" class="error-message"></div>
                    <div id="autocompleteSuggestionsDivisional" class="autocomplete-suggestions"></div>

                    <label for="divisionalHeadOfInstituteName">Head of Institute Name:</label>
                    <span id="divisionalHeadOfInstituteNameError" class="error"></span>
                    <input type="text" id="divisionalHeadOfInstituteName" name="divisionalHeadOfInstituteName">

                    <label for="divisionalHeadOfInstituteContact">Head of Institute Contact Number:</label>
                    <span id="divisionalHeadOfInstituteContactError" class="error"></span>
                    <input type="text" id="divisionalHeadOfInstituteContact" name="divisionalHeadOfInstituteContact">
                </div>

                <button type="submit">Submit</button>
            </fieldset>
        </form>

        <div id="popup" class="popup-overlay">
            <div class="popup-box">
                <span class="popup-close" onclick="closePopup()">×</span>
                <div id="popupMessage"></div>
            </div>
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

    <script>
        function showPopup(message, type) {
            const popup = document.getElementById('popup');
            const popupMessage = document.getElementById('popupMessage');
            const popupBox = document.querySelector('.popup-box');
            popupBox.classList.add(type);
            popupMessage.innerText = message;
            popup.classList.add('show');
        }

        function closePopup() {
            const popup = document.getElementById('popup');
            popup.classList.remove('show');
            setTimeout(() => {
                window.location.href = '../index.html';
            }, 500);
        }
    </script>
    <script src="./script.js"></script>
</body>

</html>
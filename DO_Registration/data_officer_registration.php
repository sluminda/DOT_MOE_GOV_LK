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
    <title>Advanced Form</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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



    <form id="detailsForm" action="submit_form.php" method="POST">
        <!-- Include form token for CSRF protection -->
        <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
        <div class="headTitle">
            <h1><i class="fa-solid fa-user-plus"></i></h1>
            <h1>Data Officer Registration Form</h1>
        </div>
        <!-- Personal Details -->
        <fieldset>
            <legend>
                <h2><i class="fas fa-user fa-icon"></i></h2>
                <h2>Personal Details</h2>
            </legend>
            <div>
                <label for="fullName"></i>Full Name:</label>
                <input type="text" id="fullName" name="fullName" required>
                <span id="fullNameError" class="error"></span>
            </div>
            <div>
                <label for="nameWithInitials">Name with Initials:</label>
                <input type="text" id="nameWithInitials" name="nameWithInitials" required>
                <span id="nameWithInitialsError" class="error"></span>
            </div>
            <div>
                <label for="nic">NIC:</label>
                <input type="text" id="nic" name="nic" required>
                <span id="nicError" class="error"></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span id="emailError" class="error"></span>
                <button type="button" id="sendOtp">Send OTP</button>

                <!-- form fields go here, as in the original form HTML -->
                <input type="hidden" id="otpVerified" name="otpVerified" value="false">
                <div id="otpSection">
                    <label for="otp">OTP:</label>
                    <input type="text" id="otp" name="otp">
                    <button type="button" id="verifyOtp">Verify OTP</button>
                </div>
                <div id="otpMessage" class="message" style="display:none;"></div>
            </div>

            <div>
                <label for="whatsappNumber">WhatsApp Number:</label>
                <input type="text" id="whatsappNumber" name="whatsappNumber" required>
                <span id="whatsappNumberError" class="error"></span>
            </div>
            <div>
                <label for="mobileNumber">Mobile Number:</label>
                <input type="text" id="mobileNumber" name="mobileNumber" required>
                <span id="mobileNumberError" class="error"></span>
            </div>
        </fieldset>

        <!-- Workplace Details -->
        <fieldset>
            <legend>
                <h2><i class="fas fa-briefcase fa-icon"></i></h2>
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
                <label for="schoolName">School Name:</label>
                <input type="text" id="schoolName" name="schoolName">
                <span id="schoolNameError" class="error"></span>
                <input type="hidden" id="selectedSchoolCencode" name="selectedSchoolCencode">
                <div id="autocompleteSuggestions" class="autocomplete-suggestions"></div>
                <div id="schoolNameError" class="error-message"></div>

                <label for="principleName">Principal Name:</label>
                <input type="text" id="principleName" name="principleName">
                <span id="principleNameError" class="error"></span>

                <label for="principleContact">Principal Contact Number:</label>
                <input type="text" id="principleContact" name="principleContact">
                <span id="principleContactError" class="error"></span>
            </div>

            <!-- Provincial Office Details -->
            <div id="provincialDetails" class="workplaceDetails">
                <label for="provincialName">Name of the Provincial Department of Education:</label>
                <input type="text" id="provincialName" name="provincialName">
                <span id="provincialNameError" class="error"></span>
                <div id="autocompleteSuggestionsProvincial" class="autocomplete-suggestions"></div>
                <div id="provincialNameError" class="error-message"></div>

                <label for="provincialHeadOfInstituteName">Head of Institute Name:</label>
                <input type="text" id="provincialHeadOfInstituteName" name="provincialHeadOfInstituteName">
                <span id="provincialHeadOfInstituteNameError" class="error"></span>

                <label for="provincialHeadOfInstituteContact">Head of Institute Contact Number:</label>
                <input type="text" id="provincialHeadOfInstituteContact" name="provincialHeadOfInstituteContact">
                <span id="provincialHeadOfInstituteContactError" class="error"></span>
            </div>

            <!-- Zonal Office Details -->
            <div id="zonalDetails" class="workplaceDetails">
                <label for="zonalName">Name of the Zonal Education Office:</label>
                <input type="text" id="zonalName" name="zonalName">
                <span id="zonalNameError" class="error"></span>
                <div id="autocompleteSuggestionsZonal" class="autocomplete-suggestions"></div>
                <div id="zonalNameError" class="error-message"></div>

                <label for="zonalHeadOfInstituteName">Head of Institute Name:</label>
                <input type="text" id="zonalHeadOfInstituteName" name="zonalHeadOfInstituteName">
                <span id="zonalHeadOfInstituteNameError" class="error"></span>

                <label for="zonalHeadOfInstituteContact">Head of Institute Contact Number:</label>
                <input type="text" id="zonalHeadOfInstituteContact" name="zonalHeadOfInstituteContact">
                <span id="zonalHeadOfInstituteContactError" class="error"></span>
            </div>

            <!-- Divisional Office Details -->
            <div id="divisionalDetails" class="workplaceDetails">
                <label for="divisionalName">Divisional Education Office Name:</label>
                <input type="text" id="divisionalName" name="divisionalName">
                <span id="divisionalNameError" class="error"></span>
                <div id="autocompleteSuggestionsDivisional" class="autocomplete-suggestions"></div>
                <div id="divisionalNameError" class="error-message"></div>

                <label for="divisionalHeadOfInstituteName">Head of Institute Name:</label>
                <input type="text" id="divisionalHeadOfInstituteName" name="divisionalHeadOfInstituteName">
                <span id="divisionalHeadOfInstituteNameError" class="error"></span>

                <label for="divisionalHeadOfInstituteContact">Head of Institute Contact Number:</label>
                <input type="text" id="divisionalHeadOfInstituteContact" name="divisionalHeadOfInstituteContact">
                <span id="divisionalHeadOfInstituteContactError" class="error"></span>
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Populate form with previous data if available in local storage
            const formData = JSON.parse(localStorage.getItem('formData'));
            if (formData) {
                for (const key in formData) {
                    if (formData.hasOwnProperty(key)) {
                        const element = document.getElementById(key);
                        if (element) {
                            element.value = formData[key];
                        }
                    }
                }
            }

            // Save form data to local storage on change
            document.getElementById('detailsForm').addEventListener('input', (event) => {
                const formData = {};
                new FormData(document.getElementById('detailsForm')).forEach((value, key) => {
                    formData[key] = value;
                });
                localStorage.setItem('formData', JSON.stringify(formData));
            });

            // Clear form data in local storage if form submission was successful
            if (<?php echo isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] ? 'true' : 'false'; ?>) {
                localStorage.removeItem('formData');
            }
        });
    </script>
    <script src="./script.js"></script>
</body>

</html>
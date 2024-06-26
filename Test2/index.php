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
</head>

<body>
    <form id="detailsForm" action="./submit_form.php" method="POST">

        <!-- Personal Details -->
        <fieldset>
            <legend>
                <h2>Personal Details</h2>
            </legend>
            <div>
                <label for="fullName">Full Name:</label>
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
                <h2>Workplace Details</h2>
            </legend>
            <div>
                <label for="currentWorkingPlace">Current Working Place:</label>
                <select id="currentWorkingPlace" name="currentWorkingPlace" required>
                    <option value="">Select</option>
                    <option value="school">School</option>
                    <option value="provincialOffice">Provincial Office</option>
                    <option value="zonalOffice">Zonal Office</option>
                    <option value="divisionalOffice">Divisional Office</option>
                </select>
            </div>

            <!-- School Details -->
            <div id="schoolDetails" class="workplaceDetails">
                <label for="schoolName">School Name:</label>
                <span id="schoolNameError" class="error"></span>
                <input type="text" id="schoolName" name="schoolName">
                <input type="hidden" id="selectedSchoolCencode" name="selectedSchoolCencode">
                <div id="autocompleteSuggestions" class="autocomplete-suggestions"></div>

                <label for="principleName">Principal Name:</label>
                <input type="text" id="principleName" name="principleName">
                <span id="principleNameError" class="error"></span>

                <label for="principleContact">Principal Contact Number:</label>
                <input type="text" id="principleContact" name="principleContact">
                <span id="principleContactError" class="error"></span>
            </div>

            <!-- Provincial Office Details -->
            <div id="provincialDetails" class="workplaceDetails">
                <label for="provincialName">Institute Name:</label>
                <span id="provincialNameError" class="error"></span>
                <input type="text" id="provincialName" name="provincialName">
                <div id="autocompleteSuggestionsProvincial" class="autocomplete-suggestions"></div>

                <label for="provincialHeadOfInstituteName">Head of Institute Name:</label>
                <input type="text" id="provincialHeadOfInstituteName" name="provincialHeadOfInstituteName">
                <span id="provincialHeadOfInstituteNameError" class="error"></span>

                <label for="provincialHeadOfInstituteContact">Head of Institute Contact Number:</label>
                <input type="text" id="provincialHeadOfInstituteContact" name="provincialHeadOfInstituteContact">
                <span id="provincialHeadOfInstituteContactError" class="error"></span>
            </div>

            <!-- Zonal Office Details -->
            <div id="zonalDetails" class="workplaceDetails">
                <label for="zonalName">Institute Name:</label>
                <span id="zonalNameError" class="error"></span>
                <input type="text" id="zonalName" name="zonalName">
                <div id="autocompleteSuggestionsZonal" class="autocomplete-suggestions"></div>

                <label for="zonalHeadOfInstituteName">Head of Institute Name:</label>
                <input type="text" id="zonalHeadOfInstituteName" name="zonalHeadOfInstituteName">
                <span id="zonalHeadOfInstituteNameError" class="error"></span>

                <label for="zonalHeadOfInstituteContact">Head of Institute Contact Number:</label>
                <input type="text" id="zonalHeadOfInstituteContact" name="zonalHeadOfInstituteContact">
                <span id="zonalHeadOfInstituteContactError" class="error"></span>
            </div>

            <!-- Divisional Office Details -->
            <div id="divisionalDetails" class="workplaceDetails">
                <label for="divisionalName">Institute Name:</label>
                <span id="divisionalNameError" class="error"></span>
                <input type="text" id="divisionalName" name="divisionalName">
                <div id="autocompleteSuggestionsDivisional" class="autocomplete-suggestions"></div>

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

    <script src="script.js"></script>
</body>

</html>
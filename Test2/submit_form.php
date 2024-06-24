<?php
session_start();
date_default_timezone_set('Asia/Colombo');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$fullName = $nameWithInitials = $nic = $email = $whatsappNumber = $mobileNumber = $headOfInstituteName = $headOfInstituteContactNo = $currentWorkingPlace = "";
$submittedAt = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = sanitizeInput($_POST["fullName"]);
    $nameWithInitials = sanitizeInput($_POST["nameWithInitials"]);
    $nic = sanitizeInput($_POST["nic"]);
    $email = sanitizeInput($_POST["email"]);
    $whatsappNumber = sanitizeInput($_POST["whatsappNumber"]);
    $mobileNumber = sanitizeInput($_POST["mobileNumber"]);
    $currentWorkingPlace = sanitizeInput($_POST["currentWorkingPlace"]);
    $currentWorkingPlace = sanitizeInput($_POST["currentWorkingPlace"]);
    $otpVerified = sanitizeInput($_POST["otpVerified"]);

    if ($otpVerified !== "true") {
        $errors[] = "OTP not verified.";
    }

    if (empty($fullName) || !preg_match("/^[A-Za-z\s.]+$/", $fullName)) {
        $errors[] = "Full Name is required and can only contain letters, spaces, and dots.";
    }

    if (empty($nameWithInitials) || !preg_match("/^[A-Za-z\s.]+$/", $nameWithInitials)) {
        $errors[] = "Name with Initials is required and can only contain letters, spaces, and dots.";
    }

    if (empty($nic) || !preg_match("/^(\d{9}[vV]|\d{12})$/", $nic)) {
        $errors[] = "NIC is required and must be 10 digits ending with 'v' or 'V', or 12 digits of only numbers.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (empty($whatsappNumber) || !preg_match("/^0\d{9}$/", $whatsappNumber)) {
        $errors[] = "WhatsApp Number is required and must be 10 digits starting with 0.";
    }

    if (empty($mobileNumber) || !preg_match("/^0\d{9}$/", $mobileNumber)) {
        $errors[] = "Mobile Number is required and must be 10 digits starting with 0.";
    }

    if ($currentWorkingPlace === "school") {
        $selectedInstituteName = sanitizeInput($_POST["selectedSchoolCencode"]);
        $headOfInstituteName = sanitizeInput($_POST["principleName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["principleContact"]);
    } elseif ($currentWorkingPlace === "provincialOffice") {
        $provincialName = sanitizeInput($_POST["provincialName"]);
        $headOfInstituteName = sanitizeInput($_POST["provincialHeadOfInstituteName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["provincialHeadOfInstituteContact"]);
    } elseif ($currentWorkingPlace === "zonalOffice") {
        $selectedInstituteName = sanitizeInput($_POST["zonalName"]);
        $headOfInstituteName = sanitizeInput($_POST["zonalHeadOfInstituteName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["zonalHeadOfInstituteContact"]);
    } elseif ($currentWorkingPlace === "divisionalOffice") {
        $selectedInstituteName = sanitizeInput($_POST["divisionalName"]);
        $headOfInstituteName = sanitizeInput($_POST["divisionalHeadOfInstituteName"]);
        $headOfInstituteContactNo = sanitizeInput($_POST["divisionalHeadOfInstituteContact"]);
    }

    if (empty($headOfInstituteName) || !preg_match("/^[A-Za-z\s.]+$/", $headOfInstituteName)) {
        $errors[] = "Head of Institute Name is required and can only contain letters, spaces, and dots.";
    }

    if (empty($headOfInstituteContactNo) || !preg_match("/^0\d{9}$/", $headOfInstituteContactNo)) {
        $errors[] = "Head of Institute Contact No is required and must be 10 digits starting with 0.";
    }

    if (empty($errors)) {
        // Insert into history table
        $stmt = $conn->prepare("INSERT INTO workplace_details_history (fullName, nameWithInitials, nic, email, whatsappNumber, mobileNumber, headOfInstituteName, headOfInstituteContactNo, currentWorkingPlace, selectedInstituteName,  submittedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("sssssssssss", $fullName, $nameWithInitials, $nic, $email, $whatsappNumber, $mobileNumber, $headOfInstituteName, $headOfInstituteContactNo, $currentWorkingPlace, $selectedInstituteName, $submittedAt);
        $stmt->execute();

        // Check if NIC and email already exist
        $stmt = $conn->prepare("SELECT id FROM workplace_details WHERE nic=? AND email=?");
        $stmt->bind_param("ss", $nic, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing record
            $stmt = $conn->prepare("UPDATE workplace_details SET fullName=?, nameWithInitials=?, whatsappNumber=?, mobileNumber=?, headOfInstituteName=?, headOfInstituteContactNo=?, currentWorkingPlace=?,  selectedInstituteName=?, submittedAt=? WHERE nic=? AND email=?");
            $stmt->bind_param("sssssssssss", $fullName, $nameWithInitials, $whatsappNumber, $mobileNumber, $headOfInstituteName, $headOfInstituteContactNo, $currentWorkingPlace,  $selectedInstituteName, $submittedAt, $nic, $email);
            $stmt->execute();
        } else {
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO workplace_details (fullName, nameWithInitials, nic, email, whatsappNumber, mobileNumber, headOfInstituteName, headOfInstituteContactNo, currentWorkingPlace, selectedInstituteName, submittedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $fullName, $nameWithInitials, $nic, $email, $whatsappNumber, $mobileNumber, $headOfInstituteName, $headOfInstituteContactNo, $currentWorkingPlace, $selectedInstituteName, $submittedAt);
            $stmt->execute();
        }

        $_SESSION['message'] = "Form submitted successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: ./submit_form.php");
        exit();
    } else {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link rel="stylesheet" href="./styles.css">

    <style>
        .message {
            display: flex;
            text-align: center;
            justify-content: center;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message.success {
            color: green;
            border: 1px solid green;
        }

        .message.error {
            color: red;
            border: 1px solid red;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="message <?php echo $_SESSION['message_type']; ?>">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        </div>
    <?php endif; ?>
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
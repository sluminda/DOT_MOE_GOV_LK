<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3308; // Adjust port as necessary

// Function to sanitize input data
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validation function for fields
function validateForm()
{
    $errors = array();

    // Validate fullName
    if (empty($_POST['fullName'])) {
        $errors['fullName'] = "Full Name is required";
    } else {
        $fullName = sanitize_input($_POST['fullName']);
        // Additional validation if needed
    }

    // Validate nameWithInitials
    if (empty($_POST['nameWithInitials'])) {
        $errors['nameWithInitials'] = "Name with Initials is required";
    } else {
        $nameWithInitials = sanitize_input($_POST['nameWithInitials']);
        // Additional validation if needed
    }

    // Validate nic
    if (empty($_POST['nic'])) {
        $errors['nic'] = "NIC is required";
    } else {
        $nic = sanitize_input($_POST['nic']);
        // Additional validation if needed
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    } else {
        $email = sanitize_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    // Validate whatsappNumber
    if (empty($_POST['whatsappNumber'])) {
        $errors['whatsappNumber'] = "WhatsApp Number is required";
    } else {
        $whatsappNumber = sanitize_input($_POST['whatsappNumber']);
        // Additional validation if needed
    }

    // Validate mobileNumber
    if (empty($_POST['mobileNumber'])) {
        $errors['mobileNumber'] = "Mobile Number is required";
    } else {
        $mobileNumber = sanitize_input($_POST['mobileNumber']);
        // Additional validation if needed
    }

    // Validate currentWorkingPlace
    if (empty($_POST['currentWorkingPlace'])) {
        $errors['currentWorkingPlace'] = "Current Working Place is required";
    } else {
        $currentWorkingPlace = sanitize_input($_POST['currentWorkingPlace']);
        // Additional validation if needed
    }

    // Validate WorkPlaceName based on currentWorkingPlace
    if ($currentWorkingPlace === "school") {
        if (empty($_POST['schoolName'])) {
            $errors['schoolName'] = "School Name is required";
        } else {
            $schoolName = sanitize_input($_POST['schoolName']);
            // Additional validation if needed
        }
    } elseif ($currentWorkingPlace === "provincialOffice" || $currentWorkingPlace === "zonalOffice" || $currentWorkingPlace === "divisionalOffice") {
        if (empty($_POST['WorkPlaceName'])) {
            $errors['WorkPlaceName'] = "Institute Name is required";
        } else {
            $WorkPlaceName = sanitize_input($_POST['WorkPlaceName']);
            // Additional validation if needed
        }
    }

    // Validate headOfInstituteName
    if (empty($_POST['headOfInstituteName'])) {
        $errors['headOfInstituteName'] = "Head of Institute Name is required";
    } else {
        $headOfInstituteName = sanitize_input($_POST['headOfInstituteName']);
        // Additional validation if needed
    }

    // Validate headOfInstituteContact
    if (empty($_POST['headOfInstituteContact'])) {
        $errors['headOfInstituteContact'] = "Head of Institute Contact Number is required";
    } else {
        $headOfInstituteContact = sanitize_input($_POST['headOfInstituteContact']);
        // Additional validation if needed
    }

    return $errors;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateForm();

    if (count($errors) === 0) {
        try {
            // Create connection using PDO
            $dsn = "mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8mb4";
            $conn = new PDO($dsn, $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Begin transaction for atomicity
            $conn->beginTransaction();

            // Check if a record with same nic and email exists
            $stmt_check = $conn->prepare("SELECT id FROM main_submission WHERE nic = :nic AND email = :email");
            $stmt_check->bindParam(':nic', $_POST['nic']);
            $stmt_check->bindParam(':email', $_POST['email']);
            $stmt_check->execute();
            $existing_submission = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($existing_submission) {
                // Update existing record in main_submission
                $mainSubmissionId = $existing_submission['id'];
                $stmt_update = $conn->prepare("UPDATE main_submission SET 
                    fullName = :fullName,
                    nameWithInitials = :nameWithInitials,
                    whatsappNumber = :whatsappNumber,
                    mobileNumber = :mobileNumber,
                    currentWorkingPlace = :currentWorkingPlace,
                    WorkPlaceName = :WorkPlaceName,
                    headOfInstituteName = :headOfInstituteName,
                    headOfInstituteContact = :headOfInstituteContact,
                    ipAddress = :ipAddress,
                    submittedDate = :submittedDate,
                    submittedTime = :submittedTime
                    WHERE id = :mainSubmissionId");

                // Bind parameters for update
                $stmt_update->bindParam(':fullName', $_POST['fullName']);
                $stmt_update->bindParam(':nameWithInitials', $_POST['nameWithInitials']);
                $stmt_update->bindParam(':whatsappNumber', $_POST['whatsappNumber']);
                $stmt_update->bindParam(':mobileNumber', $_POST['mobileNumber']);
                $stmt_update->bindParam(':currentWorkingPlace', $_POST['currentWorkingPlace']);
                $stmt_update->bindParam(':WorkPlaceName', $_POST['WorkPlaceName']);
                $stmt_update->bindParam(':headOfInstituteName', $_POST['headOfInstituteName']);
                $stmt_update->bindParam(':headOfInstituteContact', $_POST['headOfInstituteContact']);
                $stmt_update->bindParam(':ipAddress', $_SERVER['REMOTE_ADDR']);
                $stmt_update->bindParam(':submittedDate', date('Y-m-d'));
                $stmt_update->bindParam(':submittedTime', date('H:i:s'));
                $stmt_update->bindParam(':mainSubmissionId', $mainSubmissionId);
                $stmt_update->execute();
            } else {
                // Insert new record into main_submission
                $stmt_insert = $conn->prepare("INSERT INTO main_submission 
                    (fullName, nameWithInitials, nic, email, whatsappNumber, mobileNumber, currentWorkingPlace, WorkPlaceName, headOfInstituteName, headOfInstituteContact, ipAddress, submittedDate, submittedTime) 
                    VALUES 
                    (:fullName, :nameWithInitials, :nic, :email, :whatsappNumber, :mobileNumber, :currentWorkingPlace, :WorkPlaceName, :headOfInstituteName, :headOfInstituteContact, :ipAddress, :submittedDate, :submittedTime)");

                // Bind parameters for insert
                $stmt_insert->bindParam(':fullName', $_POST['fullName']);
                $stmt_insert->bindParam(':nameWithInitials', $_POST['nameWithInitials']);
                $stmt_insert->bindParam(':nic', $_POST['nic']);
                $stmt_insert->bindParam(':email', $_POST['email']);
                $stmt_insert->bindParam(':whatsappNumber', $_POST['whatsappNumber']);
                $stmt_insert->bindParam(':mobileNumber', $_POST['mobileNumber']);
                $stmt_insert->bindParam(':currentWorkingPlace', $_POST['currentWorkingPlace']);
                $stmt_insert->bindParam(':WorkPlaceName', $_POST['WorkPlaceName']);
                $stmt_insert->bindParam(':headOfInstituteName', $_POST['headOfInstituteName']);
                $stmt_insert->bindParam(':headOfInstituteContact', $_POST['headOfInstituteContact']);
                $stmt_insert->bindParam(':ipAddress', $_SERVER['REMOTE_ADDR']);
                $stmt_insert->bindParam(':submittedDate', date('Y-m-d'));
                $stmt_insert->bindParam(':submittedTime', date('H:i:s'));
                $stmt_insert->execute();

                // Get the ID of the inserted record
                $mainSubmissionId = $conn->lastInsertId();
            }

            // Log the submission in submission_history
            $stmt_history = $conn->prepare("INSERT INTO submission_history 
(mainSubmissionId, fullName, nameWithInitials, nic, email, whatsappNumber, mobileNumber, currentWorkingPlace, WorkPlaceName, headOfInstituteName, headOfInstituteContact, ipAddress, submittedDate, submittedTime) 
VALUES 
(:mainSubmissionId, :fullName, :nameWithInitials, :nic, :email, :whatsappNumber, :mobileNumber, :currentWorkingPlace, :WorkPlaceName, :headOfInstituteName, :headOfInstituteContact, :ipAddress, :submittedDate, :submittedTime)");

            // Bind parameters for history insert
            $stmt_history->bindParam(':mainSubmissionId', $mainSubmissionId);
            $stmt_history->bindParam(':fullName', $_POST['fullName']);
            $stmt_history->bindParam(':nameWithInitials', $_POST['nameWithInitials']);
            $stmt_history->bindParam(':nic', $_POST['nic']);
            $stmt_history->bindParam(':email', $_POST['email']);
            $stmt_history->bindParam(':whatsappNumber', $_POST['whatsappNumber']);
            $stmt_history->bindParam(':mobileNumber', $_POST['mobileNumber']);
            $stmt_history->bindParam(':currentWorkingPlace', $_POST['currentWorkingPlace']);
            $stmt_history->bindParam(':WorkPlaceName', $_POST['WorkPlaceName']);
            $stmt_history->bindParam(':headOfInstituteName', $_POST['headOfInstituteName']);
            $stmt_history->bindParam(':headOfInstituteContact', $_POST['headOfInstituteContact']);
            $stmt_history->bindParam(':ipAddress', $_SERVER['REMOTE_ADDR']);
            $stmt_history->bindParam(':submittedDate', date('Y-m-d'));
            $stmt_history->bindParam(':submittedTime', date('H:i:s'));
            $stmt_history->execute();

            // Commit the transaction
            $conn->commit();
            echo "New record created successfully";
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    } else {
        echo "Validation errors occurred: " . json_encode($errors);
    }
}

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dot_moe_gov_lk";
$port = 3308;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];

if ($action == "search") {
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $working_place = $_POST['working_place'];
    $institute_code = $_POST['institute_code'];
    $institute_name = $_POST['institute_name'];
    $table = $_POST['table'];

    $sql = "SELECT * FROM $table WHERE 1=1";

    if (!empty($name)) {
        $sql .= " AND fullName LIKE '%$name%'";
    }
    if (!empty($nic)) {
        $sql .= " AND nic LIKE '%$nic%'";
    }
    if (!empty($from_date) && !empty($to_date)) {
        $sql .= " AND submittedAt BETWEEN '$from_date' AND '$to_date'";
    }
    if (!empty($working_place)) {
        $sql .= " AND currentWorkingPlace LIKE '%$working_place%'";
    }
    if (!empty($institute_code)) {
        $sql .= " AND selectedInstituteCode LIKE '%$institute_code%'";
    }
    if (!empty($institute_name)) {
        $sql .= " AND selectedInstituteName LIKE '%$institute_name%'";
    }

    $result = $conn->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

if ($action == "export") {
    $table = $_POST['table'];

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=export.csv');

    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $csv = fopen('php://output', 'w');
        $header = false;

        while ($row = $result->fetch_assoc()) {
            if (!$header) {
                fputcsv($csv, array_keys($row));
                $header = true;
            }
            fputcsv($csv, $row);
        }

        fclose($csv);
    }
}

$conn->close();

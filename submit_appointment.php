<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}
if ($_SESSION['loggedin']){
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        $table = 'admin_info';
        $id_column = 'USER_ID';
        $userR = "Admin";
    } else if ($role === 'staff') {
        $table = 'staff_info';
        $id_column = 'STAFF_ID';
        $userR = "Staff";
    } else {
        $table = 'user_info';
        $id_column = 'USER_ID';
        $userR = "Patient";
    }
}

// Database Details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Establish connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get user info
$user_info = $connection->prepare("SELECT * FROM $table WHERE $id_column=?");
$user_info->bind_param("s", $userid);
$user_info->execute();
$user_result = $user_info->get_result();
$user = $user_result->fetch_assoc();

$fname = $user['FIRSTNAME'];
$lname = $user['LASTNAME'];
$pnum = $user['NO_TEL'];
$email = $user['EMAIL'];
$ic = $user['IC'];
$usertype = $user['USERTYPE'];

// Get appointment data from POST
$date = $_POST['appointment_date'];
$time = $_POST['appointment_time'];
$reason = $_POST['reason_for_visit'];

// Check if an appointment exists on the same date and time
$check_appointment = $connection->prepare("SELECT * FROM appointment_info WHERE appointment_date = ? AND appointment_time = ?");
$check_appointment->bind_param("ss", $date, $time);
$check_appointment->execute();
$appointment_result = $check_appointment->get_result();

if ($appointment_result->num_rows > 0) {
    echo "Error: An appointment already exists for the selected date and time.";
} else {
    // Fetch the last queue number
    $query = "SELECT queue_number FROM appointment_info ORDER BY queue_number DESC LIMIT 1";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_queue_number = $row['queue_number'] + 1;
    } else {
        // If no appointments exist, start with 1
        $new_queue_number = 1;
    }

    // Prepare and execute insert query
    $insert_stmt = $connection->prepare("INSERT INTO appointment_info (userid, fname, lname, number, email, ic, appointment_date, appointment_time, reason_for_visit, queue_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("sssssssssi", $userid, $fname, $lname, $pnum, $email, $ic, $date, $time, $reason, $new_queue_number);

    if ($insert_stmt->execute()) {
        echo "Appointment added successfully!";
    } else {
        echo "Error: " . $insert_stmt->error;
    }

    // Close the insert statement
    $insert_stmt->close();
}

// Close the connections
$check_appointment->close();
$connection->close();
?>

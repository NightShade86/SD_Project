<?php
// Start session and enable error reporting
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in.";
    header("Location: login_guess.php");
    exit();
}

// Get user details from session
$userid = $_SESSION['USER_ID'];
$role = $_SESSION['role'];

// Determine user role and corresponding table
switch ($role) {
    case 'admin':
        $table = 'admin_info';
        $id_column = 'USER_ID';
        $userR = "Admin";
        break;
    case 'staff':
        $table = 'staff_info';
        $id_column = 'STAFF_ID';
        $userR = "Staff";
        break;
    default:
        $table = 'user_info';
        $id_column = 'USER_ID';
        $userR = "Patient";
        break;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Establish the database connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve user information
$user_info = $connection->prepare("SELECT * FROM $table WHERE $id_column = ?");
$user_info->bind_param("s", $userid);
$user_info->execute();
$user_result = $user_info->get_result();
$user = $user_result->fetch_assoc();

// Extract user details
$fname = $user['FIRSTNAME'];
$lname = $user['LASTNAME'];
$pnum = $user['NO_TEL'];
$email = $user['EMAIL'];
$ic = $user['IC'];
$usertype = $user['USERTYPE'];

// Get appointment data from POST request
$date = $_POST['appointment_date'];
$time = $_POST['appointment_time'];
$reason = $_POST['reason_for_visit'];

// Check for existing appointment on the selected date and time
$check_appointment = $connection->prepare("SELECT * FROM appointment_info WHERE appointment_date = ? AND appointment_time = ?");
$check_appointment->bind_param("ss", $date, $time);
$check_appointment->execute();
$appointment_result = $check_appointment->get_result();

if ($appointment_result->num_rows > 0) {
    $_SESSION['error_message'] = "An appointment already exists for the selected date and time. Please choose another slot.";
    header("Location: index_patient.php");
    exit();
}

// Fetch the last queue number and determine the next one
$query = "SELECT queue_number FROM appointment_info ORDER BY queue_number DESC LIMIT 1";
$result = $connection->query($query);

$new_queue_number = ($result->num_rows > 0) ? $result->fetch_assoc()['queue_number'] + 1 : 1;

// Prepare and execute the insert query for the appointment
$insert_stmt = $connection->prepare("
    INSERT INTO appointment_info (userid, fname, lname, number, email, ic, appointment_date, appointment_time, reason_for_visit, queue_number)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$insert_stmt->bind_param("sssssssssi", $userid, $fname, $lname, $pnum, $email, $ic, $date, $time, $reason, $new_queue_number);

if ($insert_stmt->execute()) {
    $_SESSION['success_message'] = "Appointment added successfully!";
} else {
    $_SESSION['error_message'] = "Error: " . $insert_stmt->error;
}

// Close the prepared statements and database connection
$insert_stmt->close();
$check_appointment->close();
$connection->close();

// Redirect back to the patient's index page with a success or error message
header("Location: index_patient.php");
exit();
?>

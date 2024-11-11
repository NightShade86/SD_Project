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

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if appointment_id is set
if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    // Prepare and execute delete query
    $stmt = $connection->prepare("DELETE FROM appointment_info WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Appointment canceled successfully.";
    } else {
        $_SESSION['error_message'] = "Error canceling appointment: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    $_SESSION['error_message'] = "No appointment ID provided.";
}

// Close the connection
$connection->close();

if (!isset($_GET["patient_id"])) {
    // Redirect based on the existing session variable for user role
    if (isset($_SESSION['userRole'])) {
        if ($_SESSION['userRole'] === 'admin') {
            header("Location: admin_dashboard.php?section=appointment");
        } elseif ($_SESSION['userRole'] === 'staff') {
            header("Location: staff_dashboard.php?section=appointment");
        }
    }
}
// Redirect back to the previous page or a default location
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>

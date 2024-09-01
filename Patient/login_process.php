<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "dtcmsdb";

// Establish connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['login'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    // Admin login
    if ($uname === 'admin' && $pwd === 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'admin';
        header("Location: dashboard.php");
        exit;
    }

    // Staff login
    $staff_sql = "SELECT * FROM staff_info WHERE USER_ID=? AND PASSWORD=?";
   // $stmt = $connection->prepare($staff_sql);
    //$stmt->bind_param("ss", $uname, $pwd);
    //$stmt->execute();
    //$staff_result = $stmt->get_result();

    if ($staff_result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'staff';
        header("Location: dashboard.php");
        exit;
    }

    // Patient/Guest login
    $user_sql = "SELECT * FROM user_info WHERE USER_ID=? AND PASSWORD=?";
    $stmt = $connection->prepare($user_sql);
    $stmt->bind_param("ss", $uname, $pwd);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'patient';  // Assuming patients and guests are treated similarly
        header("Location: index_patient.html");
        exit;
    }

    // If login fails
    $_SESSION['error'] = "Invalid username or password. Please try again.";
    header("Location: login_guess.html");
    exit;
}

$connection->close();
?>

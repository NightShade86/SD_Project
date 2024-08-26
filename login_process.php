<?php
session_start();
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

if (isset($_POST['login'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    // Admin login
    if ($uname === 'admin' && $pwd === 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit;
    }

    // Staff login
    $staff_sql = "SELECT * FROM staff_info WHERE USER_ID='$uname' AND PASSWORD='$pwd'";
    $staff_result = $connection->query($staff_sql);

    if ($staff_result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'staff';
        header("Location: staff_dashboard.html");
        exit;
    }

    // Patient/Guest login
    $user_sql = "SELECT * FROM user_info WHERE USER_ID='$uname' AND PASSWORD='$pwd'";
    $user_result = $connection->query($user_sql);

    if ($user_result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'patient';  // Assuming patients and guests are treated similarly
        header("Location: homepage_patient.php");
        exit;
    }

    // If login fails
    echo "Invalid username or password. Please try again.";
}

$connection->close();
?>

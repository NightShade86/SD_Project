<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        header("Location:Admin/admin_dashboard.html");

        exit;
    }

    // Staff login
    $staff_sql = $connection->prepare("SELECT * FROM staff_info WHERE STAFF_ID=?");
    $staff_sql->bind_param("s", $uname);
    $staff_sql->execute();
    $staff_result = $staff_sql->get_result();

    if ($staff_result->num_rows == 1) {
         $staff = $staff_result->fetch_assoc();
        if (password_verify($pwd, $staff['PASSWORD'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = 'staff';
            header("Location: dashboard.php");
            exit;
        }
    }

    // Patient/Guest login
    $user_sql = $connection->prepare("SELECT * FROM user_info WHERE USER_ID=?");
    $user_sql->bind_param("s", $uname);
    $user_sql->execute();
    $user_result = $user_sql->get_result();

    if ($user_result->num_rows == 1) {
        $user = $user_result->fetch_assoc();
        if (password_verify($pwd, $user['PASSWORD'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = 'patient';  // Assuming patients and guests are treated similarly
            header("Location: index_patient.html");
            exit;
        }
    }

    // If login fails
    $_SESSION['error'] = "Invalid username or password. Please try again.";
    header("Location: login_guess.html");
    exit;

}

$connection->close();
?>

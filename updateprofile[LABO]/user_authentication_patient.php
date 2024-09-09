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

        // Patient/Guest login
        $user_sql = $connection->prepare("SELECT * FROM user_info WHERE USER_ID=? OR EMAIL=?");
        $user_sql->bind_param("ss", $uname, $uname);
        $user_sql->execute();
        $user_result = $user_sql->get_result();
    
        if ($user_result->num_rows == 1) {
            $user = $user_result->fetch_assoc();
            if (password_verify($pwd, $user['PASSWORD'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'patient';  // Assuming patients and guests are treated similarly
                $_SESSION['success'] = "Welcome back!";
                header("Location: index_patient.php");
                exit;
            }
        }
        // If login fails
    $_SESSION['error'] = "Invalid username or password. Please try again.";
    header("Location: login_guess.php");
    exit;

}

$connection->close();
?>
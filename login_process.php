<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "markingdb";

// Establish connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['login'])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    if ($uname === 'admin' && $pwd === 'admin') {
        // Default login credentials, redirect to index_teacher.php
        $_SESSION['loggedin'] = true;
        header("Location: index_teacher.php");
        exit;
    } else {
        // Check credentials against the database
        $sql = "SELECT * FROM teachers WHERE username='$uname' AND password='$pwd'";
        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            // Login successful
            $_SESSION['loggedin'] = true;
            header("Location: index_student.php");
            exit;
        } else {
            // Login failed
            echo "Invalid username or password. Please try again.";
        }
    }
}

$connection->close();
?>

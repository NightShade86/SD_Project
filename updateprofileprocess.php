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

// Retrieve form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$ic = $_POST['ic'];
$email = $_POST['email'];

// Check if the user exists
$sql_check = "SELECT * FROM user_info WHERE USER_ID = ?";
$stmt_check = $connection->prepare($sql_check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // User exists, update the record
    $sql_update = "UPDATE user_info 
                   SET FIRSTNAME = ?, LASTNAME = ?, NO_TEL = ?, EMAIL = ?, IC = ? 
                   WHERE USER_ID = ?";
                   
    $stmt_update = $connection->prepare($sql_update);
    $stmt_update->bind_param("ssssss", $firstname, $lastname, $phone, $email, $ic, $username);

    if ($stmt_update->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
} else {
    echo "User not found";
}

// Close connections
$stmt_check->close();
$stmt_update->close();
$connection->close();
?>

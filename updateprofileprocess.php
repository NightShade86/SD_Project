<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username_db = "root";
$password = "";
$dbname = "dtcmsdb";

// Establish connection
$connection = new mysqli($servername, $username_db, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve form data and check if variables are set
$firstname = $_POST['firstname'] ?? null;
$lastname = $_POST['lastname'] ?? null;
$username = $_POST['username'] ?? null;  // Check if 'username' is set
$ic = $_POST['ic'] ?? null;
$email = $_POST['email'] ?? null;

// Ensure the username is provided before proceeding
if ($username) {
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
        // Close the statement
        $stmt_update->close();
    } else {
        echo "User not found";
    }

    // Close the check statement
    $stmt_check->close();
} else {
    echo "Username is missing.";
}

// Close the database connection
$connection->close();
?>

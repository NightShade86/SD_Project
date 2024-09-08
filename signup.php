<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Database connection setup
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "dtcmsdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get and sanitize form data
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $no_tel = $conn->real_escape_string($_POST['no_tel']);
    $email = $conn->real_escape_string($_POST['email']);
    $ic = $conn->real_escape_string($_POST['ic']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $pass = $conn->real_escape_string($_POST['password']);
    $pass_confirm = $conn->real_escape_string($_POST['password_confirmation']);

    // === EMAIL VALIDATION ===
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email, e.g., example@email.com");
    }

    // === PASSWORD VALIDATION ===
    if (strlen($pass) < 6) {
        die("Password must be at least 6 characters long.");
    }

    if (!preg_match('/[A-Z]/', $pass)) {
        die("Password must contain at least one uppercase letter.");
    }

    if (!preg_match('/[0-9]/', $pass)) {
        die("Password must contain at least one number.");
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $pass)) {
        die("Password must contain at least one special character.");
    }

    // Check if password confirmation matches
    if ($pass !== $pass_confirm) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Set user type to 'patient'
    $usertype = '2'; // assume 2 as patient

    // Check for existing email or username in the database
    $check_sql = "SELECT * FROM user_info WHERE EMAIL = ? OR USER_ID = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Email or Username already exists.");
    }

    // Insert user data into the database
    $sql = "INSERT INTO user_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, USER_ID, PASSWORD, USERTYPE) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $firstname, $lastname, $no_tel, $email, $ic, $user_id, $hashed_password, $usertype);

    if ($stmt->execute() === TRUE) {
        header("Location: login_patient.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

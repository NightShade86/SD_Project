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
    $_SESSION['form_data'] = $_POST; // Save all form data in session
    
      // === PHONE NUMBER VALIDATION ===
      if (!preg_match('/^[0-9]+$/', $no_tel)) {
        $_SESSION['error_message'] = "Please enter a valid phone number containing only digits.";
        header("Location: register_guess.php");
        exit();
    }

    // === EMAIL VALIDATION ===
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Please enter a valid email, e.g., example@email.com";
        header("Location: register_guess.php");
        exit();
    }

    // === PASSWORD VALIDATION ===
    if (strlen($pass) < 6) {
        $_SESSION['error_message'] = "Password must be at least 6 characters long.";
        header("Location: register_guess.php");
        exit();
    }

    if (!preg_match('/[A-Z]/', $pass)) {
        $_SESSION['error_message'] = "Password must contain at least one uppercase letter.";
        header("Location: register_guess.php");
        exit();
    }

    if (!preg_match('/[0-9]/', $pass)) {
        $_SESSION['error_message'] = "Password must contain at least one number.";
        header("Location: register_guess.php");
        exit();
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $pass)) {
        $_SESSION['error_message'] = "Password must contain at least one special character.";
        header("Location: register_guess.php");
        exit();
    }

    if ($pass !== $pass_confirm) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header("Location: register_guess.php");
        exit();
    }

// Check if email exists with a verification token (not yet registered)
    $check_sql = "SELECT * FROM user_info WHERE EMAIL = ? AND verify_token_hash IS NOT NULL";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Set user type to 'patient'
    $usertype = '2'; // assume 2 as patient

    if ($result->num_rows > 0) {
        // Update the existing record with user data
        $sql = "UPDATE user_info SET FIRSTNAME = ?, LASTNAME = ?, NO_TEL = ?, IC = ?, USER_ID = ?, PASSWORD = ?, USERTYPE = ?, verify_token_hash = NULL, verify_token_expires_at = NULL WHERE EMAIL = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssis", $firstname, $lastname, $no_tel, $ic, $user_id, $hashed_password, $usertype, $email);
    } else {
        // Insert a new record if the email does not exist
        $sql = "INSERT INTO user_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, USER_ID, PASSWORD, USERTYPE) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $firstname, $lastname, $no_tel, $email, $ic, $user_id, $hashed_password, $usertype);
    }

// Execute the query
    if ($stmt->execute() === TRUE) {
        $_SESSION['success_message'] = "Registration successful!";
        header("Location: login_guess.php");
    } else {
        $_SESSION['error_message'] = "There was an issue with the registration. Please try again.";
        header("Location: register_guess.php");
    }


    $stmt->close();
    $conn->close();
}
?>

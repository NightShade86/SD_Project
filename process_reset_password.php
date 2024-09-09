<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the token from the form
    $token = $_POST["token"];

    // Hash the token to compare with the stored hash in the database
    $token_hash = hash("sha256", $token);

    // Include the database connection
    $mysqli = require __DIR__ . "/db_conn.php";

    // Prepare the query to find the user by the reset token hash
    $sql = "SELECT * FROM user_info WHERE reset_token_hash = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user with the provided token exists
    if ($user === null) {
        $_SESSION['message'] = "Token not found or invalid.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    // Check if the token has expired
    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        $_SESSION['message'] = "Token has expired.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    // Retrieve the new password from the form
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    // Check if the passwords match
    if ($password !== $password_confirmation) {
        $_SESSION['message'] = "Passwords do not match.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    // === Password Validation ===
    if (strlen($password) < 6) {
        $_SESSION['message'] = "Password must be at least 6 characters long.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $_SESSION['message'] = "Password must contain at least one capital letter.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $_SESSION['message'] = "Password must contain at least one lowercase letter.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    if (!preg_match('/[0-9]/', $password)) {
        $_SESSION['message'] = "Password must contain at least one number.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $_SESSION['message'] = "Password must contain at least one special character.";
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
        header("Location: reset_password_feedback.php");
        exit();
    }

    // Hash the new password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $sql = "UPDATE user_info
            SET PASSWORD = ?, 
                reset_token_hash = NULL, 
                reset_token_expires_at = NULL 
            WHERE EMAIL = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password_hash, $user["EMAIL"]);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Your password has been successfully reset.';
        $_SESSION['message_type'] = 'success';
        unset($_SESSION['token']); // Clear the token since reset was successful
    } else {
        $_SESSION['message'] = "Error updating password: " . $stmt->error;
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
    }

    // Redirect to feedback page
    header("Location: reset_password_feedback.php");
    exit();
}
?>

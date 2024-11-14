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

    // Check all tables (`user_info`, `staff_info`, `admin_info`) for the token
    $table_found = null;
    $user = null;

    // Prepare the query to find the user by the reset token hash
    $sql = "SELECT 'user_info' AS source, EMAIL, reset_token_expires_at 
            FROM user_info WHERE reset_token_hash = ?
            UNION 
            SELECT 'staff_info' AS source, EMAIL, reset_token_expires_at 
            FROM staff_info WHERE reset_token_hash = ?
            UNION 
            SELECT 'admin_info' AS source, EMAIL, reset_token_expires_at 
            FROM admin_info WHERE reset_token_hash = ?";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $token_hash, $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $table_found = $user['source']; // Identify the table where the token is found
    }

    // If the token is not found, redirect with an error
    if (!$user) {
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

    // Update the password in the appropriate table
    $update_sql = "UPDATE $table_found
                   SET PASSWORD = ?, 
                       reset_token_hash = NULL, 
                       reset_token_expires_at = NULL 
                   WHERE EMAIL = ?";

$update_stmt = $mysqli->prepare($update_sql);
$update_stmt->bind_param("ss", $password_hash, $user["EMAIL"]);

    // Execute the query
    if ($update_stmt->execute()) {
        $_SESSION['message'] = 'Your password has been successfully reset.';
        $_SESSION['message_type'] = 'success';
        unset($_SESSION['token']); // Clear the token since reset was successful
    } else {
        $_SESSION['message'] = "Error updating password: " . $update_stmt->error;
        $_SESSION['message_type'] = 'error';
        $_SESSION['token'] = $token; // Save token for redirection
    }

    // Redirect to feedback page
    header("Location: reset_password_feedback.php");
    exit();
}
?>

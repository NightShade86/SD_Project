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
        die("Token not found or invalid.");
    }

    // Check if the token has expired
    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Token has expired.");
    }

    // Retrieve the new password from the form
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    // === Password Validation ===
    
    // Check for password length
    if (strlen($password) < 6) {
        die("Password must be at least 6 characters long.");
    }

    // Check for at least one capital letter
    if (!preg_match('/[A-Z]/', $password)) {
        die("Password must contain at least one capital letter.");
    }

    // Check for at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        die("Password must contain at least one lowercase letter.");
    }

    // Check for at least one number
    if (!preg_match('/[0-9]/', $password)) {
        die("Password must contain at least one number.");
    }

    // Check for at least one special character
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        die("Password must contain at least one special character.");
    }

    // Check if passwords match
    if ($password !== $password_confirmation) {
        die("Passwords must match.");
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
        echo "Password updated successfully. You can now log in.";
    } else {
        echo "Error updating password: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();
}
?>

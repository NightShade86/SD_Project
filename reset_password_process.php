<?php
// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new password, confirmation, and token from the form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    // Validate the new password
    if (strlen($new_password) < 8) {
        echo 'Password must be at least 8 characters long.';
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo 'Passwords do not match.';
        exit;
    }

    // Validate the token
    $reset_sql = $connection->prepare("SELECT email FROM password_resets WHERE token=?");
    $reset_sql->bind_param("s", $token);
    if (!$reset_sql->execute()) {
        echo "Error executing query: " . $reset_sql->error;
        exit;
    }
    $reset_result = $reset_sql->get_result();

    if ($reset_result->num_rows == 0) {
        echo 'Invalid token.';
        exit;
    }

    $row = $reset_result->fetch_assoc();
    $email = $row['email'];

    // Update the password in the user_info table
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password
    $update_sql = $connection->prepare("UPDATE user_info SET password=? WHERE email=?");
    $update_sql->bind_param("ss", $new_password_hashed, $email);
    if (!$update_sql->execute()) {
        echo "Error updating password: " . $update_sql->error;
        exit;
    }

    // Delete the reset request from the password_resets table
    $delete_sql = $connection->prepare("DELETE FROM password_resets WHERE token=?");
    $delete_sql->bind_param("s", $token);
    if (!$delete_sql->execute()) {
        echo "Error deleting reset request: " . $delete_sql->error;
        exit;
    }

    // Success message
    echo "Password reset successfully!";
}

// Close the database connection
$connection->close();
?>

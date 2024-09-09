<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $repeat_new_password = $_POST['repeat_new_password'];

    // Check if the user is logged in
    if (!isset($_SESSION['USER_ID'])) {
        $_SESSION['error_message'] = "You need to be logged in to change your password.";
        header("Location: profile.php");
        exit;
    }

    // Database connection
    $mysqli = require __DIR__ . "/db_conn.php";
    $user_id = $_SESSION['USER_ID'];

    // Query for current password hash in the database
    $stmt = $mysqli->prepare("SELECT PASSWORD FROM user_info WHERE USER_ID = ?");
    if (!$stmt) {
        error_log("Prepare statement failed: " . $mysqli->error);
        $_SESSION['error_message'] = "Database error.";
        header("Location: profile.php");
        exit;
    }

    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password_from_db);
    $stmt->fetch();
    $stmt->close();

    // Check if user exists and current password is correct
    if (empty($hashed_password_from_db) || !password_verify($current_password, $hashed_password_from_db)) {
        $_SESSION['error_message'] = "Current password is incorrect!";
        header("Location: profile.php");
        exit;
    }

    // Ensure new passwords match
    if ($new_password !== $repeat_new_password) {
        $_SESSION['error_message'] = "New passwords do not match!";
        header("Location: profile.php");
        exit;
    }

    // Validate new password
    if (strlen($new_password) < 6 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) ||
        !preg_match('/[0-9]/', $new_password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new_password)) {
        $_SESSION['error_message'] = "Password does not meet the security requirements.";
        header("Location: profile.php");
        exit;
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in the database
    $update_stmt = $mysqli->prepare("UPDATE user_info SET PASSWORD = ? WHERE USER_ID = ?");
    if (!$update_stmt) {
        error_log("Prepare statement failed: " . $mysqli->error);
        $_SESSION['error_message'] = "Database error.";
        header("Location: profile.php");
        exit;
    }

    $update_stmt->bind_param('ss', $new_hashed_password, $user_id);
    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = "Password updated successfully!";
    } else {
        error_log("Error updating password: " . $update_stmt->error);
        $_SESSION['error_message'] = "Error updating password.";
    }

    $update_stmt->close();
    $mysqli->close();

    // Redirect to profile page
    header("Location: profile.php");
    exit;
}
?>

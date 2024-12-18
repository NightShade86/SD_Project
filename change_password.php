<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $repeat_new_password = $_POST['repeat_new_password'];

    if (!isset($_SESSION['USER_ID'])) {
        $_SESSION['error_message'] = "You need to be logged in to change your password.";
        header("Location: profile.php");
        exit;
    }

    $mysqli = require __DIR__ . "/db_conn.php";
    $user_id = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];

    if ($role === 'admin') {
        $table = 'admin_info';
        $id_column = 'USER_ID';
    } else if ($role === 'staff') {
        $table = 'staff_info';
        $id_column = 'STAFF_ID';
    } else {
        $table = 'user_info';
        $id_column = 'USER_ID';
    }

    $stmt = $mysqli->prepare("SELECT PASSWORD FROM $table WHERE $id_column = ?");
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

    if (empty($hashed_password_from_db) || !password_verify($current_password, $hashed_password_from_db)) {
        $_SESSION['error_message'] = "Current password is incorrect!";
        header("Location: profile.php");
        exit;
    }

    if ($new_password !== $repeat_new_password) {
        $_SESSION['error_message'] = "New passwords do not match!";
        header("Location: profile.php");
        exit;
    }

    if (strlen($new_password) < 6 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) ||
        !preg_match('/[0-9]/', $new_password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new_password)) {
        $_SESSION['error_message'] = "Password does not meet security requirements.";
        header("Location: profile.php");
        exit;
    }

    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_stmt = $mysqli->prepare("UPDATE $table SET PASSWORD = ? WHERE $id_column = ?");
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

    header("Location: profile.php");
    exit;
}

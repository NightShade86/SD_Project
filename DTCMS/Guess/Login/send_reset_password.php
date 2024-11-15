<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = $_POST["email"];

// Generate the reset token and its hash
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // Token valid for 30 minutes

// Database connection
$mysqli = require "C:/xampp/htdocs/clinicdb/SD_Project/db_conn.php";

// Check which table contains the email
$table_found = null;
$sql = "SELECT 'user_info' AS source FROM user_info WHERE EMAIL = ?
        UNION
        SELECT 'staff_info' AS source FROM staff_info WHERE EMAIL = ?
        UNION
        SELECT 'admin_info' AS source FROM admin_info WHERE EMAIL = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $email, $email, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the email is found, determine the table name
    $row = $result->fetch_assoc();
    $table_found = $row['source'];
}

// If email is found in one of the tables, update the corresponding table
if ($table_found) {
    $update_sql = "UPDATE $table_found
                   SET reset_token_hash = ?, 
                       reset_token_expires_at = ?
                   WHERE EMAIL = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    $update_stmt->bind_param("sss", $token_hash, $expiry, $email);
    $update_stmt->execute();

    if ($mysqli->affected_rows) {
        // Send the password reset email
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("thongclinic@gmail.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END
        Click <a href="https://www.drthong-clinic.uk/clinicdb/SD_Project/reset_password.php?token=$token">here</a> 
        to reset your password.
        END;

        try {
            $mail->send();
            $_SESSION['message'] = 'Password reset link sent! Please check your inbox.';
            $_SESSION['message_type'] = 'success';  // For SweetAlert 'success' icon
        } catch (Exception $e) {
            $_SESSION['message'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            $_SESSION['message_type'] = 'error';  // For SweetAlert 'error' icon
        }
    } else {
        $_SESSION['message'] = "Failed to update reset token.";
        $_SESSION['message_type'] = 'error';
    }
} else {
    // If email not found in any table
    $_SESSION['message'] = "Email not found in our records.";
    $_SESSION['message_type'] = 'error';
}

// Redirect to feedback page
header("Location: reset_password_feedback.php");
exit;
?>

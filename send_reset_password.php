<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require "C:/xampp/htdocs/clinicdb/SD_Project/db_conn.php";


$sql = "UPDATE user_info
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE EMAIL = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();


if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("thongclinic@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost/clinicdb/SD_Project/reset_password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {
        $mail->send();
        // Store a success message in the session
        $_SESSION['message'] = 'Password reset link sent! Please check your inbox.';
        $_SESSION['message_type'] = 'success';  // For SweetAlert 'success' icon
    } catch (Exception $e) {
        // Store an error message in the session
        $_SESSION['message'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        $_SESSION['message_type'] = 'error';  // For SweetAlert 'error' icon
    }
} else {
    // Store an error message if the email is not found
    $_SESSION['message'] = "Email not found.";
    $_SESSION['message_type'] = 'error';
}

// Redirect to a page that will handle showing the message
header("Location: reset_password_feedback.php");
exit;
?>

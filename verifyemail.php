<?php

$email = $_POST["emailverify"];

$token = bin2hex(random_bytes(16));  // Generate token
$token_hash = hash("sha256", $token);  // Hash the token

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);  // Token expires in 30 minutes

$mysqli = require "C:/xampp/htdocs/clinicdb/SD_Project/db_conn.php";

// Insert or update the user with the token, even if not registered yet
$sql = "INSERT INTO user_info (EMAIL, verify_token_hash, verify_token_expires_at)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE verify_token_hash = VALUES(verify_token_hash),
        verify_token_expires_at = VALUES(verify_token_expires_at)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $email, $token_hash, $expiry);
$stmt->execute();


if ($mysqli->affected_rows) {
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("thongclinic@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Email Verification";
    $mail->Body = <<<END
        Click <a href="http://localhost/clinicdb/SD_Project/register_guess.php?token=$token">here</a> 
        to verify your email.
    END;

    try {
        $mail->send();
        $_SESSION['message'] = 'Verification email sent! Please check your inbox.';
        $_SESSION['message_type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['message'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        $_SESSION['message_type'] = 'error';
    }
}
header("Location: reset_password_feedback.php");
exit;

?>

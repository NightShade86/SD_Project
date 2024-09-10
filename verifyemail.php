<?php

$email = $_POST["emailverify"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() +19800+ 60 * 30);

$mysqli = require "C:/xampp/htdocs/clinicdb/SD_Project/db_conn.php";


$sql = "UPDATE user_info
        SET verify_token_hash = ?,
            verify_token_expires_at = ?
        WHERE EMAIL = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

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
        // Store a success message in the session
        $_SESSION['message'] = 'Password reset link sent! Please check your inbox.';
        $_SESSION['message_type'] = 'success';  // For SweetAlert 'success' icon
    } catch (Exception $e) {
        // Store an error message in the session
        $_SESSION['message'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        $_SESSION['message_type'] = 'error';  // For SweetAlert 'error' icon
    }

} else {
    // Store an error message if the email is not found
    $_SESSION['message'] = "Email not found.";
    $_SESSION['message_type'] = 'error';

}
// Redirect to a page that will handle showing the message
echo "Message sent, please check your inbox.";
header("Location: reset_password_feedback.php");
exit;
?>

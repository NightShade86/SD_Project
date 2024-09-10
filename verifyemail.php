<?php

$email = $_POST["emailverify"];

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
    $mail->Subject = "Email Verification";
    $mail->Body = <<<END

    Click <a href="http://localhost/clinicdb/SD_Project/register_guess.php?token=$token">here</a> 
    to verify your email.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}

echo "Message sent, please check your inbox.";

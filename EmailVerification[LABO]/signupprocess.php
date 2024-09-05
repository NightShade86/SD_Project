<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtcmsdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $no_tel = $conn->real_escape_string($_POST['no_tel']);
    $email = $conn->real_escape_string($_POST['email']);
    $ic = $conn->real_escape_string($_POST['ic']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $pass = $conn->real_escape_string($_POST['password']);

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Set user type to 'patient'
    $usertype = 2; // Assume 2 as patient

    // Insert user data into the database
    $sql = "INSERT INTO user_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, USER_ID, PASSWORD, USERTYPE) 
            VALUES ('$firstname', '$lastname', '$no_tel', '$email', '$ic', '$user_id', '$hashed_password', '$usertype')";

    if ($conn->query($sql) === TRUE) {
        $userId = $conn->insert_id; // Get the ID of the newly inserted user

        // Generate verification token
        $token = bin2hex(random_bytes(16));
        $expiresAt = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');

        // Insert token into the database
        $sqlToken = "INSERT INTO email_verification_tokens (user_id, token, expires_at) VALUES ('$userId', '$token', '$expiresAt')";
        if ($conn->query($sqlToken) === TRUE) {
            // Send verification email
            $to = $email;
            $subject = 'Email Verification';
            $message = "Please verify your email by clicking the following link: http://localhost/verify.php?token=$token";
            $headers = 'From: no-reply@yourdomain.com' . "\r\n" .
                       'Reply-To: no-reply@yourdomain.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                echo "A verification email has been sent. Please check your inbox.";
            } else {
                echo "Failed to send verification email.";
            }
        } else {
            echo "Error inserting token: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

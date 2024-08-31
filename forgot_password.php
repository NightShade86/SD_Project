<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Check if the email exists in the user_info table
    $user_sql = $connection->prepare("SELECT * FROM user_info WHERE email=?");
    $user_sql->bind_param("s", $email);
    if (!$user_sql->execute()) {
        echo "Error executing query: " . $user_sql->error;
        exit;
    }
    $user_result = $user_sql->get_result();

    if ($user_result->num_rows == 0) {
        echo "No account found with that email.";
        exit;
    }

    // Generate a unique token using a CSPRNG
    try {
        $token = bin2hex(random_bytes(50));
    } catch (Exception $e) {
        echo "Error generating random token: " . $e->getMessage();
        exit;
    }

    // Insert the reset request into the password_resets table
    $reset_sql = $connection->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
    $reset_sql->bind_param("ss", $email, $token);
    if (!$reset_sql->execute()) {
        echo "Error inserting reset request: " . $reset_sql->error;
        exit;
    }

    // Send the reset email
    $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
    $subject = "Password Reset Request";
    $message = "Please click the following link to reset your password: <a href='" . $reset_link . "'>" . $reset_link . "</a>";
    $headers = "From: thongclinic@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "Reply-To: thongclinic@gmail.com\r\n";

    if (mail($email, $subject, $message, $headers)) {
        echo "<p>A password reset link has been sent to your email. Please check your inbox and follow the instructions to reset your password.</p>";
    } else {
        echo "Failed to send email.";
    }
}

$connection->close();
?>

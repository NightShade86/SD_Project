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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $token = $_GET['token'] ?? '';

    // Check if the token is valid
    $reset_sql = $connection->prepare("SELECT * FROM password_resets WHERE token=?");
    $reset_sql->bind_param("s", $token);
    if (!$reset_sql->execute()) {
        echo "Error executing query: " . $reset_sql->error;
        exit;
    }
    $reset_result = $reset_sql->get_result();

    if ($reset_result->num_rows == 0) {
        echo "Invalid token.";
        exit;
    }

    // Get the email address associated with the token
    $row = $reset_result->fetch_assoc();
    $email = $row['email'];
} else {
    // Redirect to forgot password page if token is missing
    header("Location: forgot_password.html");
    exit;
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Add some basic styling */
        .reset-password-section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(to bottom, #f7f7f7, #fff);
        }
        .auto-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-style-one {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-style-one:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Reset Password Section -->
    <section class="reset-password-section">
        <div class="auto-container">
            <h2 style="text-align: center; color: #333;">Reset Password</h2>
            <form method="post" action="reset_password_process.php">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn-style-one">Reset Password</button>
            </form>
        </div>
    </section>
</body>
</html>

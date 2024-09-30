<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET["token"])) {
    echo "<script>Swal.fire('Error', 'No token provided', 'error');</script>";
    exit();
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

// Make sure the path to database.php is correct
$mysqli = require __DIR__ . "/db_conn.php";

$sql = "SELECT * FROM user_info WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    // Show error message using SweetAlert
    echo "<script>Swal.fire('Error', 'Token not found', 'error');</script>";
    exit();
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    // Show error message using SweetAlert
    echo "<script>Swal.fire('Error', 'Token has expired', 'error');</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Custom styles for SweetAlert to match your project's fonts */
        .swal2-popup {
            font-family: inherit; /* Inherits the font from your page */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <form method="post" action="process_reset_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="form-group">
                <label for="password">New password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Repeat password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</body>
</html>

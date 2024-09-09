<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET["token"])) {
    echo "<script>alert('No token provided');</script>";
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
     // Show error message using regular alert
     echo "<script>alert('Token not found');</script>";
     exit();
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    // Show error message using regular alert
    echo "<script>alert('Token has expired');</script>";
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Reset Password</h1>
    <form method="post" action="process_reset_password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="password">New password</label>
        <input type="password" id="password" name="password">
        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
        <button>Send</button>
    </form>
</body>
</html>

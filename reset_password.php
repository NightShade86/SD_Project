<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET["token"])) {
    die("No token provided");
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
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
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

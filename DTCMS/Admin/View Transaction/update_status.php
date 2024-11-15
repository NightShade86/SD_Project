<?php
session_start();

// Prevent session_start() from being called again in this page
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'staff'])) {
    echo "error";
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if bill_id and status are provided
if (isset($_POST['bill_id']) && isset($_POST['status'])) {
    $bill_id = $_POST['bill_id'];
    $status = $_POST['status'];

    // Update the payment status in the database
    $updateStmt = $pdo->prepare("UPDATE clinic_bills SET payment_status = ? WHERE id = ?");
    $updateStmt->execute([$status, $bill_id]);

    // Send success response
    echo "success";
} else {
    // If no bill_id or status is provided, send error response
    echo "error";
}
?>

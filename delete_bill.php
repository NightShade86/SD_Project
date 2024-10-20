<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Database connection parameters
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

// Get the bill ID from the URL
$bill_id = $_GET['bill_id'] ?? null;

if ($bill_id) {
    // Delete the bill items first (to maintain referential integrity)
    $stmt = $pdo->prepare("DELETE FROM bill_items WHERE bill_id = ?");
    $stmt->execute([$bill_id]);

    // Then delete the bill itself
    $stmt = $pdo->prepare("DELETE FROM clinic_bills WHERE id = ?");
    $stmt->execute([$bill_id]);

    // Redirect back to the bills list
    header("Location: bill.php?success=Bill deleted successfully");
    exit();
} else {
    echo "No bill ID provided.";
    exit();
}
?>

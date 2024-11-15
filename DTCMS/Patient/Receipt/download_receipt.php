<?php
session_start();
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header('Location: index.php');
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$bill_id = $_GET['bill_id'] ?? null;

if (!$bill_id) {
    echo "No bill ID provided.";
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM clinic_bills WHERE id = ?");
$stmt->execute([$bill_id]);
$bill = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bill) {
    echo "Bill not found.";
    exit();
}

// Generate a unique receipt ID
$receipt_id = "REC" . strtoupper(uniqid());

// Update the clinic_bills table with the receipt ID
$update_receipt = $pdo->prepare("UPDATE clinic_bills SET receipt_id = ? WHERE id = ?");
$update_receipt->execute([$receipt_id, $bill_id]);

// Prepare receipt content
$receipt_content = "Receipt ID: " . $receipt_id . "\n";
$receipt_content .= "Transaction ID: " . $bill['transaction_id'] . "\n";
$receipt_content .= "Patient IC: " . $bill['patient_ic'] . "\n";
$receipt_content .= "Total Amount: RM " . number_format($bill['total_amount'], 2) . "\n";
$receipt_content .= "Amount Paid: RM " . number_format($bill['total_paid'], 2) . "\n";
$receipt_content .= "Outstanding Payment: RM " . number_format($bill['outstanding_payment'], 2) . "\n";
$receipt_content .= "Payment Status: " . $bill['payment_status'] . "\n";
$receipt_content .= "Payment Method: " . $bill['payment_method'] . "\n";
$receipt_content .= "Date: " . date("Y-m-d H:i:s") . "\n";

// Set headers for file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="receipt_' . $bill['id'] . '.txt"');

// Output the receipt content to the browser
echo $receipt_content;
exit();

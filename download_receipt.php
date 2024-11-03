<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login_guess.php");
    exit();
}

$userid = $_SESSION['USER_ID'];
$bill_id = $_GET['bill_id']; // Assuming bill_id is passed in the URL

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch the receipt details
$stmt = $connection->prepare("SELECT * FROM clinic_bills WHERE id = ? AND patient_ic = ?");
$stmt->bind_param("is", $bill_id, $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $receipt_data = "Receipt ID: " . $row['id'] . "\n";
    $receipt_data .= "Total Amount: " . $row['total_amount'] . "\n";
    $receipt_data .= "Total Paid: " . $row['total_paid'] . "\n";
    $receipt_data .= "Outstanding Payment: " . $row['outstanding_payment'] . "\n";
    $receipt_data .= "Payment Status: " . $row['payment_status'] . "\n";
    
    // Set headers for download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="receipt_' . $row['id'] . '.txt"');
    echo $receipt_data;
    exit();
} else {
    echo "No receipt found.";
}

$stmt->close();
$connection->close();
?>

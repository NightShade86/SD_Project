<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['billcode']) && isset($_POST['status_id'])) {
    $billCode = $_POST['billcode'];
    $status = $_POST['status_id'] == 1 ? 'Paid' : 'Pending';

    $stmt = $conn->prepare("UPDATE clinic_bills SET payment_status = ? WHERE transaction_id = ?");
    $stmt->bind_param("ss", $status, $billCode);
    $stmt->execute();

    echo "Payment status updated successfully.";
} else {
    echo "Invalid callback data.";
}

$conn->close();
?>

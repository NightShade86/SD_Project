<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$patientIC = "030807011163";
$stmt = $conn->prepare("SELECT * FROM clinic_bills WHERE patient_ic = ? AND payment_status = 'Pending'");
$stmt->bind_param("s", $patientIC);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $bill = $result->fetch_assoc();
    $totalAmount = $bill['total_amount'];
} else {
    echo "No pending bills found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Bills</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f4; }
        .payment-container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); max-width: 400px; width: 90%; text-align: center; }
        .pay-button { background-color: #28a745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .pay-button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="payment-container">
    <h2>Pay Your Bill</h2>
    <p>Amount Due: RM <?php echo number_format($totalAmount, 2); ?></p>
    <form action="initiate_payment.php" method="POST">
        <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
        <button type="submit" class="pay-button">Pay</button>
    </form>
</div>

</body>
</html>

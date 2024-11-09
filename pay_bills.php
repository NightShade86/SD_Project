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

// Get bill_id from URL
$bill_id = isset($_GET['bill_id']) ? $_GET['bill_id'] : null;
if (!$bill_id) {
    echo "No bill selected.";
    exit;
}

// Retrieve the bill details based on the provided bill_id
$stmt = $conn->prepare("SELECT * FROM clinic_bills WHERE id = ? AND payment_status IN ('Unpaid', 'Pending')");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $bill = $result->fetch_assoc();
    $totalAmount = $bill['total_amount'];
    $paymentStatus = $bill['payment_status'];

    // Define button text and style based on payment status
    $buttonText = $paymentStatus == 'Unpaid' ? 'Pay Now' : 'Paid';
    $buttonClass = $paymentStatus == 'Unpaid' ? 'pay-button' : 'paid-button';
} else {
    echo "No unpaid or pending bills found for the selected bill.";
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
        .paid-button { background-color: #6c757d; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: not-allowed; font-size: 16px; }
    </style>
</head>
<body>

<div class="payment-container">
    <h2>Pay Your Bill</h2>
    <p>Amount Due: RM <?php echo number_format($totalAmount, 2); ?></p>

    <?php if ($paymentStatus == 'Unpaid'): ?>
        <form action="initiate_payment.php" method="POST">
            <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
            <button type="submit" class="pay-button">Pay Now</button>
        </form>
    <?php else: ?>
        <button type="button" class="paid-button" disabled>Paid</button>
    <?php endif; ?>
</div>

</body>
</html>

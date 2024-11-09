<?php
// Retrieve GET parameters
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : null;
$billcode = isset($_GET['billcode']) ? $_GET['billcode'] : null;
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : null;

// Example of processing: you can add code to update the payment status in your database here
// For now, we'll just simulate a failed payment based on status_id

$payment_status = "Failed"; // Assuming payment failed based on status_id
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #d9534f;
        }
        .message {
            text-align: center;
            font-size: 1.2em;
            margin: 20px 0;
            color: #d9534f;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            font-size: 1.1em;
            color: #333;
        }
        .btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #d9534f;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
        }
        .btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Payment Failed</h1>
    </div>

    <div class="message">
        <p>Sorry! Your payment could not be processed.</p>
    </div>

    <div class="details">
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
        <p><strong>Bill Code:</strong> <?php echo htmlspecialchars($billcode); ?></p>
        <p><strong>Status:</strong> <?php echo $payment_status; ?></p>
        <p><strong>Error Message:</strong> <?php echo htmlspecialchars($msg); ?></p>
    </div>

    <!-- Back to View Bill Page -->
    <a href="view_bill_patient.php" class="btn">View Bill</a>
</div>

</body>
</html>

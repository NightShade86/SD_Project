<?php
// Retrieve GET parameters
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : null;
$billcode = isset($_GET['billcode']) ? $_GET['billcode'] : null;
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : null;

// Assuming payment failed based on status_id
$payment_status = "Failed"; // Payment status is failed for this page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - Dr. Thong Clinic</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .clinic-name {
            font-size: 2.5em;
            text-align: center;
            color: #5bc0de; /* Clinic name color */
            margin-bottom: 20px;
        }
        .clinic-name {
            font-size: 2.0em;
            color: #0066cc;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
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
            color: #d9534f; /* Red for error */
        }
        .message {
            text-align: center;
            font-size: 1.2em;
            margin: 20px 0;
            color: #d9534f; /* Red for error message */
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            font-size: 1.1em;
            color: #333;
        }
        .details-left {
            text-align: left;
        }
        .btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #d9534f; /* Red button for failure */
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
        }
        .btn:hover {
            background-color: #c9302c;
        }
        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 1em;
            color: #5bc0de;
        }
    </style>
</head>
<body>

<div class="clinic-name">
    Dr. Thong Clinic
</div>

<div class="container">
    <div class="header">
        <h1>Payment Failed</h1>
    </div>

    <div class="message">
        <p>Sorry! Your payment could not be processed.</p>
    </div>

    <div class="details details-left">
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
        <p><strong>Bill Code:</strong> <?php echo htmlspecialchars($billcode); ?></p>
        <p><strong>Status:</strong> <?php echo $payment_status; ?></p>
        <p><strong>Error Message:</strong> <?php echo htmlspecialchars($msg); ?></p>
    </div>

    <!-- Back to View Bill Page -->
    <a href="view_bills_patient.php" class="btn">View Bill</a>
</div>

<footer>
    <p>&copy; 2024 Dr. Thong Clinic. All Rights Reserved.</p>
</footer>

</body>
</html>

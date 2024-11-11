<?php
// Retrieve GET parameters with default values if not provided
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : null;
$billcode = isset($_GET['billcode']) ? $_GET['billcode'] : 'N/A';
$receipt_id = isset($_GET['order_id']) ? $_GET['order_id'] : 'N/A'; // Changed from order_id to receipt_id
$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : 'N/A';

// Check payment status and handle failure
if ($status_id == '3') {
    header("Location: payment_failure.php");
    exit();
}

// Set a default payment status if payment is successful
$payment_status = "Successful";

// Database connection (Replace with your actual connection)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";  // Use your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff;
    margin: 0;
    padding: 0;
    color: #333;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Ensures footer stays at the bottom of the page */
}

.container {
    max-width: 900px;
    margin: 50px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex-grow: 1; /* Ensures it takes up available space */
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h1 {
    color: #0066cc;
    font-size: 2.5em;
}

.header h1 span {
    font-size: 0.5em;
    color: #0066cc;
}

.clinic-name {
    font-size: 2.0em;
    color: #0066cc;
    text-align: center;
    margin-top: 10px;
    font-weight: bold;
}

.message {
    text-align: center;
    margin-bottom: 20px;
}

.details p {
    font-size: 1.1em;
    color: #333;
}

.button-group {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

.view-btn {
    padding: 12px 25px;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1.2em;
    border: none;
}

.view-btn:hover {
    background-color: #45a049;
}

.print-btn {
    padding: 12px 25px;
    background-color: #2196F3;
    color: white;
    text-align: center;
    border-radius: 5px;
    font-size: 1.2em;
    border: none;
    cursor: pointer;
}

.print-btn:hover {
    background-color: #1976D2;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 8px;
    text-align: center;
}

.modal-content p {
    font-size: 1.1em;
    color: #333;
}

.close-btn {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1em;
    border: none;
    cursor: pointer;
}

.close-btn:hover {
    background-color: #45a049;
}

/* Footer styles */
footer {
    text-align: center;
    font-size: 1em;
    color: #5bc0de;
    background-color: #f8f9fa;
    padding: 10px 0;
    margin-top: auto; /* Ensures footer stays at the bottom of the page */
}

/* Print styles */
@media print {
    body {
        background-color: white;
        color: black;
    }

    .container {
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .clinic-name {
        font-size: 2.0em;
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 1.8em;
    }

    .button-group {
        display: none;
    }

    footer {
        text-align: center;
        font-size: 1em;
        color: #5bc0de;
        background-color: #f8f9fa;
        padding: 10px 0;
        position: fixed; /* Keeps footer at the bottom of the page during printing */
        width: 100%;
    }
}

    </style>
</head>
<body onload="openModal()">

<!-- Clinic Name -->
<div class="clinic-name">
    DR. THONG CLINIC
</div>

<div class="container">
    <div class="header">
        <h1>Payment Success <span>- Thank You for Choosing Us!</span></h1>
    </div>
    <!-- Centered Success Message -->
    <div class="message">
        <p><strong>Congratulations! Your payment has been successfully processed.</strong></p>
    </div>
    <div class="details" id="receipt-content">
        <p><strong>Receipt ID:</strong> <?php echo htmlspecialchars($receipt_id); ?></p>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
        <p><strong>Bill Code:</strong> <?php echo htmlspecialchars($billcode); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($payment_status); ?></p>
    </div>

    <!-- Centered Buttons -->
    <div class="button-group">
        <a href="view_bills_patient.php" class="view-btn">View Bill</a>
        <button onclick="printReceipt()" class="print-btn">Print Receipt</button>
    </div>
</div>

<!-- Modal for Instructions -->
<div id="instructionModal" class="modal">
    <div class="modal-content">
        <p>Please read this instruction:</p>
        <p>1. Print this as a receipt.</p>
        <p>2. Your payment will be processed within a maximum of 5 working days. If your bill status has not changed to "Paid" in this time, please contact us at: (+60)06-454 1048 or email: thongclini@gmail.com</p>
        <!-- Added Print Receipt Button inside the Modal -->
        <button onclick="printReceipt()" class="print-btn">Print Receipt</button>
        <button onclick="closeModal()" class="close-btn">Close</button>
    </div>
</div>

<script>
    // Function to open the modal
    function openModal() {
        document.getElementById("instructionModal").style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("instructionModal").style.display = "none";
    }

    // Print function
    function printReceipt() {
        var printContent = document.getElementById("receipt-content").innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = "<html><head><title>Receipt</title></head><body>" + 
                                  "<div class='clinic-name' style='font-size: 1.5em; text-align: center;'>DR. THONG CLINIC</div>" + 
                                  printContent + "</body></html>";
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>
<footer>
    <p>&copy; 2024 Dr. Thong Clinic. All Rights Reserved.</p>
</footer>
</body>
</html>
<?php
// Start session and enable error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as admin or staff (add your own session login check here)
if (!isset($_SESSION['usertype']) || !in_array($_SESSION['usertype'], ['admin', 'staff'])) {
    echo "Access denied. Only admin and staff can view this page.";
    exit();
}

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch transactions from clinic_bills
$sql = "SELECT transaction_id, patient_ic, total_amount, total_paid, outstanding_payment, payment_status, payment_method, payment_date 
        FROM clinic_bills";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <style>
        /* Simple styling for the table */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-paid {
            color: green;
        }
        .status-pending {
            color: orange;
        }
        .status-cancelled {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Transaction History</h2>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Patient IC</th>
                <th>Total Amount (RM)</th>
                <th>Total Paid (RM)</th>
                <th>Outstanding Payment (RM)</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any transactions
            if ($result && $result->num_rows > 0) {
                // Loop through each transaction and display in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['transaction_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['patient_ic']) . "</td>";
                    echo "<td>" . number_format($row['total_amount'], 2) . "</td>";
                    echo "<td>" . number_format($row['total_paid'], 2) . "</td>";
                    echo "<td>" . number_format($row['outstanding_payment'], 2) . "</td>";
                    echo "<td class='status-" . strtolower($row['payment_status']) . "'>" . htmlspecialchars($row['payment_status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['payment_date']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No transactions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>

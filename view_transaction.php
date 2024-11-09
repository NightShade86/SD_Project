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
        /* Global Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
            font-size: 1.8em;
            border-bottom: 2px solid #5a67d8;
            padding-bottom: 10px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.95em;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
        }
        thead th {
            background-color: #5a67d8;
            color: #fff;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #e8f0fe;
        }
        th, td {
            border-bottom: 1px solid #ddd;
        }
        .status-paid {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-cancelled {
            color: red;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 0.85em;
            }
            .container {
                padding: 10px;
            }
            h2 {
                font-size: 1.6em;
            }
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
                    echo "<td>RM " . number_format($row['total_amount'], 2) . "</td>";
                    echo "<td>RM " . number_format($row['total_paid'], 2) . "</td>";
                    echo "<td>RM " . number_format($row['outstanding_payment'], 2) . "</td>";
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

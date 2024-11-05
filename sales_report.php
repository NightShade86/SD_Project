<?php
// Start session and enable error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as admin or staff
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

// Initialize variables for date range
$startDate = '';
$endDate = '';
$totalAmount = 0;
$totalPaid = 0;
$totalOutstanding = 0;
$transactionCount = 0;

// Check if form is submitted with a date range
if (isset($_POST['generate_report'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    
    // Prepare SQL query with date filtering
    $stmt = $conn->prepare("SELECT SUM(total_amount) AS totalAmount, SUM(total_paid) AS totalPaid, 
                            SUM(outstanding_payment) AS totalOutstanding, COUNT(*) AS transactionCount 
                            FROM clinic_bills 
                            WHERE payment_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $stmt->bind_result($totalAmount, $totalPaid, $totalOutstanding, $transactionCount);
    $stmt->fetch();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        /* Simple styling for the form and report */
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
        .form-group {
            margin: 15px 0;
        }
        label, input {
            display: inline-block;
            margin-right: 10px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .btn-print {
            background-color: #2196F3;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .report-table th, .report-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .report-table th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sales Report</h2>

    <!-- Date range selection form -->
    <form method="POST">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>" required>
            <button type="submit" name="generate_report" class="btn">Generate Report</button>
        </div>
    </form>

    <!-- Sales Report Summary -->
    <?php if ($transactionCount > 0): ?>
        <div class="summary">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Total Amount (RM)</th>
                        <th>Total Paid (RM)</th>
                        <th>Total Outstanding (RM)</th>
                        <th>Transaction Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo number_format($totalAmount, 2); ?></td>
                        <td><?php echo number_format($totalPaid, 2); ?></td>
                        <td><?php echo number_format($totalOutstanding, 2); ?></td>
                        <td><?php echo $transactionCount; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button onclick="window.print()" class="btn btn-print">Print Report</button>
    <?php elseif (isset($_POST['generate_report'])): ?>
        <p>No transactions found for the selected date range.</p>
    <?php endif; ?>

</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>

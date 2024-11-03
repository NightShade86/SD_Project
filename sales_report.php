<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login_guess.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all bills for sales report
$sql = "SELECT * FROM clinic_bills";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Sales Report</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Patient IC</th>
                <th>Payment Status</th>
                <th>Total Amount</th>
                <th>Total Paid</th>
                <th>Outstanding Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['patient_ic']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['total_paid']; ?></td>
                <td><?php echo $row['outstanding_payment']; ?></td>
                <td>
                    <a href="generate_report.php?bill_id=<?php echo $row['id']; ?>" class="btn btn-secondary">Generate Report</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$connection->close();
?>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login_guess.php");
    exit();
}

$userid = $_SESSION['USER_ID'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch bills for the patient
$stmt = $connection->prepare("SELECT * FROM clinic_bills WHERE patient_ic = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Bills</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Your Bills</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Total Amount</th>
                <th>Total Paid</th>
                <th>Outstanding Payment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['total_paid']; ?></td>
                <td><?php echo $row['outstanding_payment']; ?></td>
                <td>
                    <a href="initiate_payment.php?bill_id=<?php echo $row['id']; ?>" class="btn btn-primary">Pay</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$stmt->close();
$connection->close();
?>

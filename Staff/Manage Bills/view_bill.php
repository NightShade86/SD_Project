<?php
ob_start();

// Start session for user verification and login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Check user role
if ($_SESSION['loggedin']) {
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Pagination setup
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch bills with pagination
$sql = "SELECT * FROM clinic_bills LIMIT $offset, $records_per_page";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Count total number of bills
$totalBillsResult = $connection->query("SELECT COUNT(*) AS total FROM clinic_bills");
$totalBillsRow = $totalBillsResult->fetch_assoc();
$totalBills = $totalBillsRow['total'];
$totalPages = ceil($totalBills / $records_per_page);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
        }
        .table {
            background-color: #f8f9fa;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .page-link {
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h2>List of Bills</h2>

    <p>Total Bills: <?php echo $totalBills; ?></p>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Bill ID</th>
                <th>Patient IC</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Total Paid</th>
                <th>Outstanding Payment</th>
                <th>Payment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Initialize a counter variable for numbering
        $no = $offset + 1;

        // Fetch and display data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['patient_ic']}</td>";
            echo "<td>{$row['payment_status']}</td>";
            echo "<td>{$row['payment_method']}</td>";
            echo "<td>{$row['total_amount']}</td>";
            echo "<td>{$row['total_paid']}</td>";
            // Check if 'outstanding_payment' exists and is set, else display '0.00'
            echo "<td>" . (isset($row['outstanding_payment']) ? $row['outstanding_payment'] : '0.00') . "</td>";
            echo "<td>{$row['payment_date']}</td>";
            echo "<td>";
            echo "<a href='view_transaction.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='fas fa-eye'></i> View</a>";
            echo "</td>";
            echo "</tr>";

            // Increment the counter
            $no++;
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page == $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        </ul>
    </nav>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the connection
$connection->close();

// End the output buffer and send headers
ob_end_flush();
?>

<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Get user data
$userid = $_SESSION['USER_ID'];

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new MySQLi instance
$connection = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Prepare and execute query to retrieve user data
$user_info = $connection->prepare("SELECT * FROM user_info WHERE USER_ID = ?");
$user_info->bind_param("s", $userid);
$user_info->execute();
$user_result = $user_info->get_result();
$user = $user_result->fetch_assoc();

// Extract user IC for bill lookup
$ic = $user['IC'];

// SQL query to get all bills related to the patient's IC
$bills_query = $connection->prepare("SELECT * FROM clinic_bills WHERE patient_ic = ?");
$bills_query->bind_param("s", $ic);
$bills_query->execute();
$bills_result = $bills_query->get_result();

// Fetch all bills
$bills = $bills_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Bills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Styling for the payment status colors */
        .paid { background-color: #d4edda; }   /* Light green for Paid */
        .pending { background-color: #fff3cd; } /* Light yellow for Pending */
        .unpaid { background-color: #f8d7da; }  /* Light red for Unpaid */
    </style>
</head>
<body>

<div class="container mt-4">
    <h3>Your Bills</h3>
    <div class="list-group">
        <?php foreach ($bills as $bill): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center <?php echo ($bill['payment_status'] === 'Paid') ? 'paid' : ($bill['payment_status'] === 'Pending' ? 'pending' : 'unpaid'); ?>">
                <div>
                    <h5>Bill #<?php echo $bill['id']; ?></h5>
                    <p>Total Amount: RM <?php echo number_format($bill['total_amount'], 2); ?></p>
                    <p>Status: <?php echo ucfirst($bill['payment_status']); ?></p>
                </div>
                <div>
                    <button class="btn btn-primary view-bill-btn" data-bill-id="<?php echo $bill['id']; ?>">View Details</button>
                    <?php if ($bill['payment_status'] === 'Unpaid' || $bill['payment_status'] === 'Pending'): ?>
                        <a href="pay_bills.php?bill_id=<?php echo $bill['id']; ?>" class="btn btn-success">Pay</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal to display full bill details -->
<div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billModalLabel">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Bill details will be populated here -->
                <div id="bill-details"></div>
            </div>
        </div>
    </div>
</div>

<!-- Back Button to return to the bill view page -->
<div class="container mt-4">
    <button class="btn btn-primary" onclick="window.location.href='view_bills_patient.php';">Back to Bills</button>
</div>

<!-- Back to Home Button -->
<div class="container mt-4">
    <button class="btn btn-primary" onclick="window.location.href='index_patient.php';">Back to Home</button>
</div>

<script>
    // JavaScript to handle "View Details" button click and display the modal with bill details
    $(document).ready(function() {
        $('.view-bill-btn').on('click', function() {
            var billId = $(this).data('bill-id');

            // Fetch bill details via AJAX
            $.ajax({
                url: 'get_bill_details.php',  // A separate PHP script to fetch the bill details
                method: 'POST',
                data: { bill_id: billId },
                success: function(response) {
                    $('#bill-details').html(response);
                    $('#billModal').modal('show');
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

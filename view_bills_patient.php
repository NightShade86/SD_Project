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
if ($_SESSION['loggedin']) {
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
}

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new MySQLi instance
$connection = new mysqli($host, $username, $password, $dbname);

// Prepare and execute query to retrieve user data
$user_info = $connection->prepare("SELECT * FROM user_info WHERE USER_ID = ?");
$user_info->bind_param("s", $userid);
$user_info->execute();
$user_result = $user_info->get_result();
$user = $user_result->fetch_assoc();

// Extract user data
$fname = $user['FIRSTNAME'];
$lname = $user['LASTNAME'];
$pnum = $user['NO_TEL'];
$email = $user['EMAIL'];
$ic = $user['IC'];
$usertype = $user['USERTYPE'];
$image = $user['IMAGE'] ?? 'default-avatar.png';

// SQL query to get all bills related to the patient's IC
$bills_query = $connection->prepare("SELECT * FROM clinic_bills WHERE patient_ic = ?");
$bills_query->bind_param("s", $ic);
$bills_query->execute();
$bills_result = $bills_query->get_result();

// Fetch all bills
$bills = $bills_result->fetch_all(MYSQLI_ASSOC);

// Initialize array to store items related to each bill
$bill_items = [];

foreach ($bills as $bill) {
    $bill_id = $bill['id'];

    // SQL query to get all items for the current bill_id
    $items_query = $connection->prepare("SELECT * FROM bill_items WHERE bill_id = ?");
    $items_query->bind_param("i", $bill_id);
    $items_query->execute();
    $items_result = $items_query->get_result();

    // Fetch items for the current bill and store in the array
    $bill_items[$bill_id] = $items_result->fetch_all(MYSQLI_ASSOC);
}
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
        .card {
            margin-bottom: 15px;
        }

        .modal-body table {
            width: 100%;
        }

        .modal-body th, .modal-body td {
            padding: 10px;
            text-align: left;
        }

        .modal-body th {
            background-color: #f8f9fa;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer .btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h3>Patient Bills</h3>

    <!-- List of bills -->
    <div class="row">
        <?php foreach ($bills as $bill): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Bill #<?php echo $bill['id']; ?></h5>
                        <p class="card-text">Total Amount: $<?php echo number_format($bill['total_amount'], 2); ?></p>
                        <button class="btn btn-primary view-bill-btn" data-bill-id="<?php echo $bill['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View Bill Details">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </div>
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
                <div id="bill-details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Back to Home Button -->
<div class="container mt-4">
    <button class="btn btn-secondary" onclick="window.location.href='index_patient.php';">
        <i class="fas fa-home"></i> Back to Home
    </button>
</div>

<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Handle "View" button click
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

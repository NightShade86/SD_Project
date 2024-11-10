<?php
// Start session if not started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($host, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the user's IC for retrieving bills
$userid = $_SESSION['USER_ID'];
$user_info = $connection->prepare("SELECT * FROM user_info WHERE USER_ID = ?");
$user_info->bind_param("s", $userid);
$user_info->execute();
$user_result = $user_info->get_result();
$user = $user_result->fetch_assoc();
$ic = $user['IC'];

// Fetch bills for the logged-in patient
$bills_query = $connection->prepare("SELECT * FROM clinic_bills WHERE patient_ic = ?");
$bills_query->bind_param("s", $ic);
$bills_query->execute();
$bills_result = $bills_query->get_result();
$bills = $bills_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Bills</title>

    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/color-themes/default-theme.css" rel="stylesheet">
    
    <!-- Bootstrap and Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .paid { background-color: #d4edda; }   /* Light green for Paid */
        .pending { background-color: #fff3cd; } /* Light yellow for Pending */
        .unpaid { background-color: #f8d7da; }  /* Light red for Unpaid */
        .styled-summary { background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); }
        .modal-dialog { max-width: 90%; }
        .page-title h1 { font-size: 2.5em; color: #fff; }
        .sec-title h3 { font-size: 1.75em; color: #333; }
        .order-box li span { font-weight: bold; color: #333; }
        .list-group-item { border-radius: 8px; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="page-wrapper">
    <!-- Main Header-->
    <header class="main-header">
        <!-- Reuse header from checkout.php if needed -->
    </header>
    <!--End Main Header-->

    <section class="page-title" style="background-image: url(images/background/8.jpg);">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Your Bills</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index_patient.php">Home</a></li>
                    <li>View Bills</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CheckOut Page Style with Bills -->
    <section class="checkout-page">
        <div class="auto-container">
            <div class="row clearfix">
                <!-- Left Column - Bill List -->
                <div class="column col-lg-6 col-md-12 col-sm-12">
                    <div class="styled-form">
                        <div class="sec-title">
                            <h3>Your Bills</h3>
                        </div>
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
                </div>

                <!-- Right Column - Appointment Summary -->
                <div class="column col-lg-6 col-md-12 col-sm-12">
                    <div class="styled-summary">
                        <div class="sec-title">
                            <h3>Your Bill Summary</h3>
                        </div>
                        <ul class="order-box styled-order-box">
                            <li class="clearfix">Total Bills : <span><?php echo count($bills); ?></span></li>
                            <li class="clearfix">Unpaid Bills : <span><?php echo count(array_filter($bills, fn($bill) => $bill['payment_status'] === 'Unpaid')); ?></span></li>
                            <li class="clearfix">Paid Bills : <span><?php echo count(array_filter($bills, fn($bill) => $bill['payment_status'] === 'Paid')); ?></span></li>
                            <li class="clearfix">Pending Bills : <span><?php echo count(array_filter($bills, fn($bill) => $bill['payment_status'] === 'Pending')); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Bill Details -->
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.view-bill-btn').on('click', function() {
            var billId = $(this).data('bill-id');
            $('#bill-details').html('<p>Loading details...</p>');
            $.ajax({
                url: 'get_bill_details.php',
                method: 'POST',
                data: { bill_id: billId },
                success: function(response) {
                    $('#bill-details').html(response);
                    $('#billModal').modal('show');
                },
                error: function() {
                    $('#bill-details').html('<p>Error loading details. Please try again.</p>');
                }
            });
        });
    });
</script>

</body>
</html>

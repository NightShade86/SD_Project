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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Patient Bills</title>

    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link id="theme-color-file" href="css/color-themes/default-theme.css" rel="stylesheet">
    
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

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

    <!-- Preloader -->
    <div class="preloader"></div>
    
    <!-- Main Header-->
    <header class="main-header header-style-two">
        <div class="header-top-two">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="top-left">
                        <ul class="contact-list clearfix">
                            <li><i class="flaticon-hospital-1"></i>34, Jalan Besar, 72100 Bahau, Negeri Sembilan </li>
                            <li><i class="flaticon-back-in-time"></i>Monday - Thursday 9.00am - 9.00pm , Friday 9.00am - 5.00pm. Sunday and Saturday CLOSED</li>
                        </ul>
                    </div>
                    <div class="top-right">
                        <div class="btn-box">
                            <a href="appointment.php" id="appointment-btn" class="theme-btn btn-style-three"><span class="btn-title">Appointment</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-lower">
            <div class="auto-container">    
                <div class="main-box">
                    <div class="logo-box">
                        <div class="logo"><a href="index.html"><img src="images/file.png" alt="" title=""></a></div>
                    </div>

                    <!--Nav Box-->
                    <div class="nav-outer">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li><a href="index_patient.php">Home</a></li>
                                <li><a href="services_patient.php">Services</a></li>
                                <li><a href="doctor-detail_patient.php">Doctor Detail</a></li>
                                <li class="current"><a href="about-us_patient.php">About Us</a></li>
                                <li><a href="contact_patient.php">Contact</a></li>
                                <li><a href="checkout.php">Checkout</a></li>
                                <li class="dropdown">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 1a7 7 0 1 1 0 14A7 7 0 0 1 8 1z"/>
                                            <path d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8 10a5 5 0 0 0-4.546 3 1 1 0 0 0 .657 1.07c.068.016.134.03.2.04A5.992 5.992 0 0 0 8 12a5.992 5.992 0 0 0 4.689 2.11c.066-.01.132-.024.2-.04a1 1 0 0 0 .657-1.07A5 5 0 0 0 8 10z"/>
                                        </svg>
                                        <?php 
                                            echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? " Welcome, " . htmlspecialchars($userid) : " Profile";
                                        ?>
                                    </span>
                                    <ul>
                                        <li><a href="profile.php">Profile</a></li>
                                        <?php 
                                            echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true 
                                            ? "<li><a href='logout.php'>Log Out</a></li>" 
                                            : "<li><a href='login.php'>Log In</a></li>";
                                        ?>
                                        <li><a href="javascript:void(0)" id="load-appointment-history">Appointment History</a></li>
                                        <li><a href="view_bills_patient.php">View Bills</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
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

    <!-- Bill List -->
    <section class="bill-section">
        <div class="auto-container">
            <div class="sec-title">
                <h3>Bill History</h3>
            </div>
            <ul class="list-group">
                <?php foreach ($bills as $bill) : ?>
                    <li class="list-group-item <?php echo strtolower($bill['status']); ?>">
                        Bill ID: <?php echo $bill['bill_id']; ?> - 
                        Amount: <?php echo $bill['amount']; ?> - 
                        Status: <?php echo ucfirst($bill['status']); ?>
                        <button class="btn btn-primary btn-sm view-bill-btn" data-bill-id="<?php echo $bill['bill_id']; ?>">View Details</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- Bill Details Modal -->
    <div class="modal fade" id="billDetailsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bill Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="billDetailsContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $(".view-bill-btn").on("click", function() {
            var billId = $(this).data("bill-id");
            $.ajax({
                url: "fetch_bill_details.php",
                method: "POST",
                data: { bill_id: billId },
                success: function(response) {
                    $("#billDetailsContent").html(response);
                    $("#billDetailsModal").modal("show");
                },
                error: function() {
                    $("#billDetailsContent").html("<p>Failed to load details. Please try again later.</p>");
                }
            });
        });
    });
</script>
<!-- Main Footer -->
<footer class="main-footer">
    <!--Widgets Section-->
    <div class="widgets-section" style="background-image: url(images/background/7.jpg);">
        <div class="auto-container">
            <div class="row">
                <!-- Big Column -->
                <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <!-- Footer Column -->
                        <div class="footer-column col-xl-7 col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-widget about-widget">
                                <div class="text">
                                    <p>Thong's Clinic was established by Dr. Tony Thong, a dedicated physician with a vision to enhance healthcare services in Bahau. Since its inception, the clinic has grown and evolved, always maintaining its commitment to exceptional care. </p>
                                    <p>We are among the most qualified doctors in MY with over 10 years of quality training and experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Big Column -->
                <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
                    <div class="row">
                        <!-- Footer Column -->
                        <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-widget contact-widget">
                                <h2 class="widget-title">Contact Us</h2>
                                <div class="widget-content">
                                    <ul class="contact-list">
                                        <li>
                                            <span class="icon flaticon-placeholder"></span>
                                            <div class="text">34, Jalan Besar, 72100 Bahau, Negeri Sembilan</div>
                                        </li>
                                        <li>
                                            <span class="icon flaticon-call-1"></span>
                                            <div class="text">Mon to Thur : 09:00 - 21:00</div>
                                            <div class="text">Friday : 09:00 - 17:00</div>
                                            <a href="tel:+06-4541048"><strong>(+60) 06-454 1048</strong></a>
                                        </li>
                                        <li>
                                            <span class="icon flaticon-email"></span>
                                            <div class="text">Do you have a Question?<br>
                                                <a href="mailto:thongclinic@gmail.com"><strong>thongclinic@gmail.com</strong></a>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon flaticon-back-in-time"></span>
                                            <div class="text">Mon - Thurs: 9:00 - 21:00<br>
                                                Fri: 9:00 - 17:00</div>
                                            <strong>Sunday and Saturday CLOSED</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .big-column { width: 100%; }
        .d-flex { display: flex; }
        .justify-content-end { justify-content: flex-end; }
        .footer-column { max-width: 350px; }
        .widget-content { text-align: left; }
        .contact-list { list-style: none; padding: 0; margin: 0; }
        .contact-list li { margin-bottom: 15px; }
        .contact-list .icon { margin-right: 10px; color: #3498db; }
        .contact-list .text { display: inline-block; vertical-align: middle; font-size: 14px; color: #5a5a5a; }
    </style>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
        <div class="auto-container">
            <div class="inner-container clearfix">
                <div class="footer-nav">
                    <ul class="clearfix">
                        <li><a href="about-us_patient.html">Contact</a></li>
                        <li><a href="services_patient.html">Services</a></li>
                    </ul>
                </div>
                <div class="copyright-text">
                    <p>Copyright © 2020 <a href="#">Bold Touch</a> All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Main Footer -->

</div><!-- End Page Wrapper -->

<!-- JavaScript -->
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/jquery.modal.min.js"></script>
<script src="js/mmenu.polyfills.js"></script>
<script src="js/mmenu.js"></script>
<script src="js/appear.js"></script>
<script src="js/mixitup.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/script.js"></script>
</body>
</html>

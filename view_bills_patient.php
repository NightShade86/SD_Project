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

	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">

	<!--Color Themes-->
	<link id="theme-color-file" href="css/color-themes/default-theme.css" rel="stylesheet">

	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">

	<!-- Responsive -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
	<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
		
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
	<header class="main-header header-style-two">
        <!-- Header top -->
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
        <!-- End Header Top -->
        
        <!-- Header Lower -->
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
                                <li><a href="about-us_patient.php">About Us</a></li>
                                <li><a href="contact_patient.php">Contact</a></li>
                                <li class="current"><a href="checkout.php">Checkout</a></li>
                                <li class="dropdown">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 1a7 7 0 1 1 0 14A7 7 0 0 1 8 1z"/>
                                            <path d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8 10a5 5 0 0 0-4.546 3 1 1 0 0 0 .657 1.07c.068.016.134.03.2.04A5.992 5.992 0 0 0 8 12a5.992 5.992 0 0 0 4.689 2.11c.066-.01.132-.024.2-.04a1 1 0 0 0 .657-1.07A5 5 0 0 0 8 10z"/>
                                        </svg>
                                        <?php 
                                            $userid = $_SESSION['USER_ID'];
                                            
                                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                echo " Welcome, " . htmlspecialchars($userid);
                                            } else {
                                                echo " Profile"; 
                                            }
                                        ?>
                                    </span>
                                    <ul>
                                        <li><a href="profile.php">Profile</a></li>
                                        <?php 
                                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                echo "<li><a href='logout.php'>Log Out</a></li>";
                                            } else {
                                                echo "<li><a href='login.php'>Log In</a></li>";
                                            }
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
    <!--End Main Header-->

	<section class="page-title" style="background-image: url(images/background/1-1.png);">
		<div class="auto-container">
			<div class="title-outer">
				<h1 style="color: #386cb4;">Your Bills</h1>
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
                                        <h5>Bill #<?php echo $bill['bill_id']; ?></h5>
                                        <p>Total Amount: RM <?php echo number_format($bill['total_amount'], 2); ?></p>
                                        <p>Status: <?php echo ucfirst($bill['payment_status']); ?></p>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary view-bill-btn" data-bill-id="<?php echo $bill['bill_id']; ?>">View Details</button>
                                        <?php if ($bill['payment_status'] === 'Unpaid' || $bill['payment_status'] === 'Pending'): ?>
                                            <a href="pay_bills.php?bill_id=<?php echo $bill['bill_id']; ?>" class="btn btn-success">Pay</a>
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

	<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="appointmentModalLabel">Your Appointments</h5>
					</div>
					<div class="modal-body" id="modal-body-content">
						<!-- Appointment content will be loaded here via AJAX -->
					</div>
				</div>
			</div>
	</div>

	<style>
		/* Override Bootstrap default styles at min-width 576px breakpoint */
		@media (min-width: 576px) {
			.modal-dialog {
				max-width: 90% !important; /* Set max width to a larger percentage */
				margin: auto !important; /* Center the modal */
			}

			.modal-dialog-scrollable {
				max-height: calc(100% - 2rem) !important; /* Adjust max height */
			}

			.modal-dialog-scrollable .modal-content {
				max-height: calc(100vh - 2rem) !important; /* Adjust height for better content fit */
			}

			.modal-dialog-centered {
				min-height: calc(100% - 2rem) !important; /* Adjust min height */
			}

			.modal-dialog-centered::before {
				height: calc(100vh - 2rem) !important; /* Set centering height */
			}

			.modal-sm {
				max-width: 500px !important; /* Adjust small modal width */
			}
		}

		/* General modal styling */
		.modal-dialog {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh; /* Centers the modal vertically */
		}

		.modal-content {
			width: 100%;
			max-width: 1200px; /* Set a larger max width */
		}

		.modal-body {
			padding: 20px; /* Set padding for content */
		}

		.modal {
			opacity: 1 !important; /* Ensure the modal is fully visible */
		}
	</style>

	<!-- Include jQuery and Bootstrap's JS -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		// Remove any existing event listeners to prevent duplicates
		$(document).off('click', '#load-appointment-history').on('click', '#load-appointment-history', function() {
			console.log('Appointment History clicked');  // Log when the link is clicked

			// Show loading text before content loads
			$('#modal-body-content').html('<p>Loading appointments...</p>');

			// Load content via AJAX
			$('#modal-body-content').load('view_existing_appointment_patient.php', function(response, status, xhr) {
				if (status === "error") {
					console.error('Error loading appointments:', xhr.status, xhr.statusText);
					$('#modal-body-content').html('<p>Error loading appointment history. Please try again later.</p>');
				} else {
					console.log('Content loaded successfully');
				}
				// Show the modal after content loads
				$('#appointmentModal').modal('show');
			});
		});

		// Clear content on modal close to prevent issues on reopening
		$('#appointmentModal').on('hidden.bs.modal', function () {
			$('#modal-body-content').empty();
			console.log('Modal content cleared');
		});
	</script>
	
	<footer class="main-footer">
		<div class="widgets-section">
			<div class="auto-container">
				<div class="row">
					<!-- Big Column -->
					<div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
						<div class="row">
							<!-- Footer Column -->
							<div class="footer-column col-xl-7 col-lg-6 col-md-6 col-sm-12">
								<div class="footer-widget about-widget">
									<div class="text">
										<p>Thong's Clinic was established by Dr. Tony Thong...</p>
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
												<a href="tel:+06-454 1048"><strong>(+60)06-454 1048</strong></a>
											</li>
											<li>
												<span class="icon flaticon-email"></span>
												<div class="text">Do you have a Question?<br>
													<a href="mailto:thongclinic@gmail.com"><strong>thongclinic@gmail.com</strong></a>
												</div>
											</li>
											<li>
												<span class="icon flaticon-back-in-time"></span>
												<div class="text">Mon - Thurs : 9:00 - 21:00<br>
													<div class="text">Fri : 9:00 - 17:00 </div>
													<strong>Sunday and Saturday CLOSED</strong>
												</div>
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
		
		footer.main-footer {
		background: #f7f7f7;
		padding: 40px 0;
	}

	.widgets-section {
		background: #fdfdfd;
		padding: 40px 0;
	}

	.footer-column {
		margin-bottom: 30px;
	}

	.footer-column .footer-widget h2.widget-title {
		font-size: 1.6em;
		color: #386cb4;
		margin-bottom: 20px;
	}

	.contact-list li {
		margin-bottom: 10px;
	}

	.contact-list li .icon {
		color: #386cb4;
	}

	.scroll-to-top {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background: #386cb4;
		color: #fff;
		border-radius: 50%;
		padding: 10px;
		display: none;
	}

	.scroll-to-top.show {
		display: block;
	}

	.copyright-text p {
		text-align: center;
		font-size: 14px;
		color: #5a5a5a;
	}

	.footer-nav ul {
		list-style: none;
		padding: 0;
		margin: 0;
		text-align: center;
	}

	.footer-nav ul li {
		display: inline-block;
		margin: 0 15px;
	}

	.footer-nav ul li a {
		color: #386cb4;
		font-size: 16px;
		text-decoration: none;
	}

	.footer-nav ul li a:hover {
		text-decoration: underline;
	}

		<!-- Footer Bottom -->
		<div class="footer-bottom">
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


</div>
<!--End pagewrapper-->

<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/jquery.countdown.js"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<script src="js/appear.js"></script>
<script src="js/jquery.paroller.min.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/knob.js"></script>
<script src="js/validate.js"></script>
<script src="js/script.js"></script>

</body>
</html>

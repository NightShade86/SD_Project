<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Medicoz | Health and Medical HTML Template | Checkout</title>

<!-- Stylesheets -->
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
</head>

<body>

<div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>
    
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
                                <li class="current"><a href="checkout.html">Checkout</a></li>
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
                                        <li><a href="">View Bills</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--End Main Header -->

    <!--Page Title-->
    <section class="page-title" style="background-image: url(images/background/8.jpg);">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Checkout</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Shop</li>
                </ul> 
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!--CheckOut Page-->
    <section class="checkout-page">
        <div class="auto-container">
            <!--Default Links-->
            <ul class="default-links">
                <li><span class="far fa-window-maximize"></span>Returning patient? <a href="login_guess.php">Click here to login</a></li>
            </ul>

            <!--Checkout Details-->
            <div class="checkout-form">
                <form method="post" action="checkout.html">
                    <div class="row clearfix">
                        <!--Column-->
                        <div class="column col-lg-6 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <div class="sec-title">
                                    <h3>Appointment Details</h3>
                                </div>

                                <div class="row clearfix">
                                    <!--Form Group-->
                                    <div class="form-group col-md-6 col-sm-12">
                                        <div class="field-label">First Name <sup>*</sup></div>
                                        <input type="text" name="first-name" value="" placeholder="Enter your first name">
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12">
                                        <div class="field-label">Last Name</div>
                                        <input type="text" name="last-name" value="" placeholder="Enter your last name">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <div class="field-label">Email Address</div>
                                        <input type="email" name="email" value="" placeholder="Enter your email address">
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12">
                                        <div class="field-label">Phone</div>
                                        <input type="text" name="phone" value="" placeholder="Enter your phone number">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <div class="field-label">Appointment Date</div>
                                        <input type="date" name="appointment-date" value="">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <div class="field-label">Additional Notes</div>
                                        <textarea name="notes" placeholder="Any additional notes for the appointment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

						<!-- Order Summary and Payment -->
						<div class="column col-lg-6 col-md-12 col-sm-12">
							<div class="inner-column styled-summary">
								<div class="sec-title">
									<h3>Your Appointment Summary</h3>
								</div>
								<ul class="order-box styled-order-box">
									<li class="clearfix">Service Selected <span>Consultation</span></li>
									<li class="clearfix">Total Cost <span>$50.00</span></li>
									<li class="clearfix">Appointment Date <span>--/--/----</span></li>
								</ul>

								<!-- ToyyibPay Payment Option with Toggle Switch -->
								<div class="payment-option-single">
									<label class="toggle-label">
										<input type="checkbox" name="payment-toggle" id="toggle-toyyibpay">
										<span class="toggle-switch"></span>
										ToyyibPay
										<br><span class="small-text">Make a secure payment through ToyyibPay.</span>
									</label>
								</div>

								<!-- Proceed with Payment Button -->
								<div class="text-right">
									<a href="pay_bills.php" class="theme-btn btn-style-one styled-button">
										<span class="btn-title">Proceed with Payment</span>
									</a>
								</div>
							</div>
						</div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--End Checkout Page-->
	
	 <!-- Main Footer -->
	<footer class="main-footer">
			<!--Widgets Section-->
			<div class="widgets-section" style="background-image: url(images/background/7.jpg);">
				<div class="auto-container">
					<div class="row">
						<!--Big Column-->
						<div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								<!--Footer Column-->
								<div class="footer-column col-xl-7 col-lg-6 col-md-6 col-sm-12">
									<div class="footer-widget about-widget">
										<div class="text">
											<p>Thong's Clinic was established by Dr. Tony Thong, a dedicated physician with a vision to enhance healthcare services in Bahau. Since its inception, the clinic has grown and evolved, always maintaining its commitment to exceptional care. </p>
											<p>We are among the most qualified Doctos in the MY with over 10 years of quality training and experience.</p>
										</div>
									</div>
								</div>
								<!--Footer Column-->
							</div>
						</div>

						<!--Big Column-->
					   <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
							<div class="row">
								<!--Footer Column-->
								<div class="footer-column col-lg-6 col-md-6 col-sm-12">
									<!--Footer Column-->
									<div class="footer-widget contact-widget">
										<h2 class="widget-title">Contact Us</h2>
										<!--Footer Column-->
										<div class="widget-content">
											<ul class="contact-list">
												<li>
													<span class="icon flaticon-placeholder"></span>
													<div class="text">34, Jalan Besar, 72100 Bahau, Negeri Sembilan </div>
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
			<style>
			/* Styling for the Order Summary Section */
				.styled-summary {
					background: #f9f9f9;
					padding: 20px;
					border-radius: 8px;
					box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
					font-family: Arial, sans-serif;
				}

				.sec-title h3 {
					font-size: 1.6em;
					color: #333;
					border-bottom: 2px solid #5a67d8;
					padding-bottom: 10px;
					margin-bottom: 20px;
				}

				.styled-order-box li {
					font-size: 1.1em;
					padding: 12px 0;
					border-bottom: 1px solid #ddd;
				}

				.styled-order-box li span {
					float: right;
					color: #555;
					font-weight: bold;
				}

				/* Toggle Switch for ToyyibPay */
				.payment-option-single {
					margin-top: 20px;
				}

				.toggle-label {
					cursor: pointer;
					font-size: 1.1em;
					color: #333;
					position: relative;
					padding-left: 50px;
				}

				.toggle-switch {
					position: absolute;
					left: 0;
					top: 10px;
					width: 40px;
					height: 20px;
					background: #ddd;
					border-radius: 15px;
					transition: 0.3s;
				}

				.toggle-switch::before {
					content: "";
					position: absolute;
					width: 18px;
					height: 18px;
					background: white;
					border-radius: 50%;
					top: 1px;
					left: 2px;
					transition: 0.3s;
				}

				input[type="checkbox"]:checked + .toggle-switch {
					background: #5a67d8;
				}

				input[type="checkbox"]:checked + .toggle-switch::before {
					transform: translateX(20px);
				}

				/* Proceed Button Styling */
				.styled-button {
					background-color: #5a67d8;
					color: #fff;
					padding: 12px 20px;
					border-radius: 6px;
					border: none;
					cursor: pointer;
					font-weight: bold;
					transition: background 0.3s ease;
					margin-top: 20px;
				}

				.styled-button:hover {
					background-color: #4c51bf;
				}


			.big-column {
				/* Ensure the column takes up the full width */
				width: 100%;
			}

			.d-flex {
				display: flex;
			}

			.justify-content-end {
				justify-content: flex-end;
			}

			.footer-column {
				max-width: 350px; /* Adjust width to ensure it's not too wide */
			}

			.widget-content {
				text-align: left;
				/* Optionally, you can add padding/margin adjustments if needed */
			}

			.contact-list {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.contact-list li {
				margin-bottom: 15px;
			}

			.contact-list .icon {
				margin-right: 10px;
				color: #3498db; /* Example color for icons */
			}

			.contact-list .text {
				display: inline-block;
				vertical-align: middle;
				font-size: 14px;
				color: #5a5a5a;
			}
			</style>

			<!--Footer Bottom-->
			<div class="footer-bottom">
				<!-- Scroll To Top -->
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
							<p>Copyright © 2020 <a href="#">Bold Touch</a>All Rights Reserved.</p>
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

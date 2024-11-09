<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Medicoz | Health and Medical HTML Template | Register</title>

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
                <!-- Main box -->
                <div class="main-box">

                    <div class="logo-box">
                        <div class="logo"><a href="index.html"><img src="images/file.png" alt="" title=""></a></div>
                    </div>

                    <!--Nav Box-->
                    <div class="nav-outer">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current"><a href="index_patient.php">Home</a></li>
								<li><a href="services_patient.php">Services</a></li>
								<li><a href="doctor-detail_patient.php">Doctor Detail</a></li>
								<li><a href="about-us_patient.php">About Us</a></li>
								<li><a href="contact_patient.php">Contact</a></li>
								<li class=""><a href="checkout.php">Checkout</a></li>
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
												echo " Profile"; // Default text when user is not logged in
											}
										?>
										<style>
										.dropdown span {
											display: flex;
											align-items: center; /* Vertically center the icon and text */
											font-size: 14px; /* Adjust font size as needed */
										}

										.dropdown span svg {
											margin-right: 5px; /* Space between icon and text */
											fill: #ffffff; /* Change the icon color if needed */
										}

										</style>
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
                                  <!-- <span>Blog</span>
                                    <ul>
                                        <li><a href="blog-checkboard.html">Checkerboard</a></li>
                                        <li><a href="blog-masonry.html">Masonry</a></li>
                                        <li><a href="blog-two-col.html">Two Columns</a></li>
                                        <li><a href="blog-three-col.html">Three Colums</a></li>
                                        <li><a href="blog-four-col-wide.html">Four Colums</a></li>
                                        <li class="dropdown">
                                            <span>Post Types</span>
                                            <ul>
                                                <li><a href="blog-post-image.html">Image Post</a></li>
                                                <li><a href="blog-post-gallery.html">Gallery Post</a></li>
                                                <li><a href="blog-post-link.html">Link Post</a></li>
                                                <li><a href="blog-post-audio.html">Audio Post</a></li>
                                                <li><a href="blog-post-quote.html">Quote Post</a></li>
                                                <li><a href="blog-post-video.html">Video Post</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown current">
                                    <span>Shop</span>
                                    <ul>
                                        <li><a href="shop.html">Shop</a></li>
                                        <li><a href="shop-single.html">Shop Single</a></li>
                                        <li><a href="shopping-cart.html">Shopping Cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul> 
                                </li> --> 
							</ul>
						</nav>
						<!-- Main Menu End-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Header -->
        <div class="mobile-header">
            <div class="logo"><a href="index.html"><img src="images/file.png" alt="" title=""></a></div>

            <!--Nav Box-->
            <div class="nav-outer clearfix">

                <div class="outer-box">
                    <a href="#nav-mobile" class="mobile-nav-toggler navbar-trigger"><span class="fa fa-bars"></span></a>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div id="nav-mobile"></div>
    </header>
    <!--End Main Header -->

    <!--Page Title-->
    <section class="page-title" style="background-image: url(images/background/1-1.png);">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Register</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Register</li>
                </ul> 
            </div>
        </div>
    </section>
    <!--End Page Title-->
	<div class="spacer" style="height: 50px;"></div>
		<section class="register-section" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-image: linear-gradient(to bottom, #f7f7f7, #fff);">
		  <div class="auto-container" style="width: 100%; max-width: 600px; background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
			<div class="row clearfix" style="display: flex; justify-content: center;">
			  <div class="column col-lg-12 col-md-12 col-sm-12">
				<!-- Register Form -->
				<div class="login-form register-form" style="padding: 30px; border-radius: 10px;">
				  <h2 style="text-align: center; color: #007bff;">Create Your Account</h2>
				  <form method="POST" action="signup.php">
					<div class="form-group">
					  <label for="firstname" style="font-weight: bold;">First Name:</label>
					  <input type="text" id="firstname" name="firstname" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
					</div>
					
					<div class="form-group">
					  <label for="lastname" style="font-weight: bold;">Last Name:</label>
					  <input type="text" id="lastname" name="lastname" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
					</div>
					
					<div class="form-group">
					  <label for="no_tel" style="font-weight: bold;">Phone Number:</label>
					  <input type="text" id="no_tel" name="no_tel" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
					</div>

					<div class="form-group">
					  <label for="email" style="font-weight: bold;">Email:</label>
					  <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
					</div>
					
					<div class="form-group">
					  <label for="ic" style="font-weight: bold;">IC:</label>
					  <input type="text" id="ic" name="ic" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
					</div>
					
					<div class="form-group">
					  <label for="user_id" style="font-weight: bold;">Username:</label>
					  <input type="text" id="user_id" name="user_id" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
					</div>
					
					<div class="form-group">
					  <label for="password" style="font-weight: bold;">Password:</label>
					  <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
					</div>
					
					<div class="form-group text-right">
					  <button class="theme-btn btn-style-one" type="submit" name="submit-form" style="width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px;">
						<span class="btn-title">Register Now</span>
					  </button>
					</div>
				  </form>      
				</div>
				<!--End Register Form -->
			  </div>
			</div>
		  </div>
		</section>

    <!--End Login Section-->

   	<div class="spacer" style="height: 50px;"></div>

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
		.modal-dialog {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh; /* Centers the modal vertically */
		}

		.modal-content {
			width: 100%;
			max-width: 800px; /* Adjust max width as needed */
		}

		.modal-body {
			padding: 20px;
		}

		.modal {
			opacity: 1 !important;
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


        <!--Footer Bottom-->
        <div class="footer-bottom">
            <!-- Scroll To Top -->
            <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
            
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <div class="footer-nav">
                        <ul class="clearfix">
                           <li><a href="index.html">Privacy Policy</a></li> 
                           <li><a href="about-us.html">Contact</a></li> 
                           <li><a href="services.html">Supplier</a></li>  
                        </ul>
                    </div>
                    
                    <div class="copyright-text">
                        <p>Copyright © 2020 <a href="#">Bold Touch</a>All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--End Main Footer -->

</div><!-- End Page Wrapper -->


<script src="js/jquery.js"></script>  
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/jquery.modal.min.js"></script>
<script src="js/mmenu.polyfills.js"></script>
<script src="js/mmenu.js"></script>
<script src="js/appear.js"></script>
<script src="js/jquery.bootstrap-touchspin.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/script.js"></script>
</body>
</html>



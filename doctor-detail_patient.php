<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Medicoz | Health and Medical HTML Template | Doctor Detail</title>

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
                            <li><i class="flaticon-hospital-1"></i>34, Jalan Besar, 72100 Bahau, Negeri Sembilan <br>Negeri Sembilan, Malaysia </li>
                            <li><i class="flaticon-back-in-time"></i>Mon - Thursday 9.00 - 21.00. <br>Sunday and Saturday CLOSED</li>
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
                                <li><a href="index_patient.php">Home</a></li>
								<li><a href="services_patient.php">Services</a></li>
								<li class="current"><a href="doctor-detail_patient.php">Doctor Detail</a></li>
								<li><a href="about-us_patient.php">About Us</a></li>
								<li><a href="contact_patient.php">Contact</a></li>
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
										<li><a href="">View Bills</a></li>
									</ul>

								</li>
                              <!--     <span>Blog</span>
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
                                <li class="dropdown">
                                    <span>Shop</span>
                                    <ul>
                                        <li><a href="shop.html">Shop</a></li>
                                        <li><a href="shop-single.html">Shop Single</a></li>
                                        <li><a href="shopping-cart.html">Shopping Cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul>
                                </li>
								<li class="dropdown"> --> 
							</ul>
						</nav>
						<!-- Main Menu End-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Header  -->
        <!-- Mobile Header -->
        <!-- Mobile Nav -->
        <div id="nav-mobile"></div>
        <!-- End Header Search -->

        <!-- End Sidebar Cart  -->
    </header>
    <!--End Main Header -->

    <!--Page Title-->
    <section class="page-title" style="background-image: url(images/background/1-1.png);">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Doctor Detail</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Doctors</li>
                </ul> 
            </div>
        </div>
    </section>
    <!--End Page Title-->

	<!-- Doctor Detail Section -->
	<section class="doctor-detail-section">
		<div class="auto-container">
			<!-- Doctor 1: Dr. Tony Thong -->
			<div class="row align-items-center">
				<!-- Sidebar Side -->
				<div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
					<div class="doctor-image">
						<img src="Doctor_Thong.jpg" alt="Dr. Tony Thong">
					</div>
				</div>
				<!-- End Sidebar Side -->

				<!-- Content Side -->
				<div class="content-side col-lg-8 col-md-12 col-sm-12">
					<div class="doctor-card">
						<h3 class="name">Dr. Tony Thong</h3>
						<span class="designation">(MBBS) University of Malaya</span>
						<div class="text">
							Dr. Tony Thong has dedicated his career to providing high-quality medical care and building a trusted healthcare facility in Bahau. His commitment to patient well-being has been central to the clinic's success.
						</div>
						<ul class="doctor-info-list">
							<li>
								<strong>Speciality:</strong>
								<p>General Medicine <br>Patient Care</p>
							</li>
							<li>
								<strong>Education:</strong>
								<p>Bachelor of Medicine, Bachelor of Surgery (MBBS) from the University of Malaya</p>
							</li>
							<li>
								<strong>Experience:</strong>
								<p>Over 10 years of medical practice <br>President of Rotary Club Bahau</p>
							</li>
							<li>
								<strong>Address:</strong>
								<p>34, Jalan Besar, 72100 Bahau, Negeri Sembilan</p>
							</li>
							<li>
								<strong>Phone:</strong>
								<p><a href="tel:+60-06-4541048">+60-06-454 1048</a></p>
							</li>
							<li>
								<strong>Email:</strong>
								<p><a href="mailto:thongclinic@gmail.com">thongclinic@gmail.com</a></p>
							</li>
						</ul>
					</div>
				</div>
				<!-- End Content Side -->
			</div>
			<!-- End Doctor 1 -->

			<!-- Doctor 2: Dr. Chia -->
			<div class="row align-items-center">
				<!-- Sidebar Side -->
				<div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
					<div class="doctor-image">
						<img src="Doctor_Chia.jpg" alt="Dr. Chia">
					</div>
				</div>
				<!-- End Sidebar Side -->

				<!-- Content Side -->
				<div class="content-side col-lg-8 col-md-12 col-sm-12">
					<div class="doctor-card">
						<h3 class="name">Dr. Chia</h3>
						<span class="designation">(MBBS) University of Malaya</span>
						<div class="text">
							Dr. Chia, following in his father’s footsteps, brings additional expertise and dedication to the clinic, ensuring continued excellence in patient care.
						</div>
						<ul class="doctor-info-list">
							<li>
								<strong>Speciality:</strong>
								<p>General Medicine <br>Patient Care</p>
							</li>
							<li>
								<strong>Education:</strong>
								<p>Bachelor of Medicine, Bachelor of Surgery (MBBS) from the University of Malaya</p>
							</li>
							<li>
								<strong>Experience:</strong>
								<p>Over 10 years of medical practice</p>
							</li>
							<li>
								<strong>Address:</strong>
								<p>34, Jalan Besar, 72100 Bahau, Negeri Sembilan</p>
							</li>
							<li>
								<strong>Phone:</strong>
								<p><a href="tel:+60-06-4541048">+60-06-454 1048</a></p>
							</li>
							<li>
								<strong>Email:</strong>
								<p><a href="mailto:thongclinic@gmail.com">thongclinic@gmail.com</a></p>
							</li>
						</ul>
					</div>
				</div>
				<!-- End Content Side -->
			</div>
			<!-- End Doctor 2 -->
		</div>
	</section>
	<!-- End Doctor Detail Section -->

	<!-- Doctor Detail CSS -->
	<style>
		.doctor-detail-section .row {
		margin-bottom: 40px; /* Space between each doctor section */
	}

	.doctor-image img {
		width: 100%;
		max-width: 300px; /* Adjust max width for better alignment */
		height: auto;
		border-radius: 8px;
		object-fit: cover;
		border: 2px solid #ddd;
		margin: 0 auto; /* Center the image within its column */
	}

	.doctor-card {
		background-color: #f9f9f9;
		padding: 20px;
		border-radius: 8px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
	}

	.doctor-card h3.name {
		color: #2c3e50;
		font-size: 24px;
		margin-bottom: 10px;
	}

	.doctor-card .designation {
		color: #8e8e8e;
		font-size: 16px;
		margin-bottom: 20px;
		display: block;
	}

	.doctor-card .text {
		margin-bottom: 20px;
		color: #5a5a5a;
		font-size: 16px;
	}

	.doctor-info-list {
		list-style: none;
		padding: 0;
	}

	.doctor-info-list li {
		margin-bottom: 10px;
	}

	.doctor-info-list strong {
		color: #2c3e50;
		font-size: 16px;
	}

	.doctor-info-list p {
		margin: 0;
		color: #5a5a5a;
	}

	.doctor-info-list a {
		color: #3498db;
		text-decoration: none;
	}

	.doctor-info-list a:hover {
		text-decoration: underline;
	}

	</style>
	<!-- End Doctor Detail CSS -->


    <!-- Team Section -->
	<section class="team-section">
		<div class="auto-container">
			<!-- Section Title -->
			<div class="section-title text-center">
				<h2>Our Team of Doctors</h2>
				<p>Meet the dedicated professionals providing exceptional care at our clinic.</p>
			</div>

			<div class="row justify-content-center">
				<!-- Team Block -->
				<div class="team-block col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
					<div class="inner-box">
						<figure class="image"><img src="Doctor_Thong.jpg" alt="Dr. Tony Thong"></figure>
						<div class="info-box">
							<h4 class="name"><a href="doctor-detail.html">Dr. Tony Thong</a></h4>
							<span class="designation">Doctor at Dr.Thong Clinic</span>
						</div>
					</div>
				</div>

				<!-- Team Block -->
				<div class="team-block col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
					<div class="inner-box">
						<figure class="image"><img src="Doctor_Chia.jpg" alt="Dr. Chia"></figure>
						<div class="info-box">
							<h4 class="name"><a href="doctor-detail.html">Dr. Chia</a></h4>
							<span class="designation">Doctor at Dr.Thong Clinic</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Team Section -->

	<!-- Team Section CSS -->
	<style>
		.section-title {
			margin-bottom: 40px; /* Space between title and team blocks */
		}

		.section-title h2 {
			font-size: 32px;
			color: #2c3e50;
			font-weight: 700;
		}

		.section-title p {
			font-size: 16px;
			color: #5a5a5a;
			margin-top: 10px;
		}
	</style>
	<!-- End Team Section CSS -->
	
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

        <!--Footer Bottom-->
        <div class="footer-bottom">
            <!-- Scroll To Top -->
            <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
            
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <div class="footer-nav">
                        <ul class="clearfix">
                           <li><a href="about-us_patient.html">Contact</a></li> 
                           <li><a href="services_patient.html">Supplier</a></li>  
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
<script src="js/mixitup.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/script.js"></script>
</body>
</html>



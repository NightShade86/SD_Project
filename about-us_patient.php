<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Medicoz | Health and Medical HTML Template | About Us</title>

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
                        <a href="appointment.html" id="appointment-btn" class="theme-btn btn-style-three"><span class="btn-title">Appointment</span></a>
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
								<li><a href="doctor-detail_patient.php">Doctor Detail</a></li>
								<li class="current"><a href="about-us_patient.php">About Us</a></li>
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
									</ul>
								</li>
                            <!-- <li class="dropdown">
                                <span>Blog</span>
                                <ul>
                                    <li><a href="blog-checkboard.html">Checkerboard</a></li>
                                    <li><a href="blog-masonry.html">Masonry</a></li>
                                    <li><a href="blog-two-col.html">Two Columns</a></li>
                                    <li><a href="blog-three-col.html">Three Columns</a></li>
                                    <li><a href="blog-four-col-wide.html">Four Columns</a></li>
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
                            </li>
                            <li class="dropdown">
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

                    <div class="outer-box">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container">            
                <div class="main-box">
                    <div class="logo-box">
                        <div class="logo"><a href="index.html"><img src="images/logo.png" alt="" title=""></a></div>
                    </div>

                    <!--Keep This Empty / Menu will come through Javascript-->
                </div>
            </div>
        </div><!-- End Sticky Menu -->

        <!-- Mobile Header -->
        <div class="mobile-header">
            <div class="logo"><a href="index.html"><img src="images/logo.png" alt="" title=""></a></div>

            <!--Nav Box-->
            <div class="nav-outer clearfix">

                <div class="outer-box">
                    <!-- Search Btn -->
                    <div class="search-box">
                        <button class="search-btn mobile-search-btn"><i class="flaticon-magnifying-glass"></i></button>
                    </div>

                    <!-- Cart Btn -->
                    <button class="cart-btn"><i class="icon flaticon-shopping-cart"></i><span class="count">3</span></button>

                    <a href="#nav-mobile" class="mobile-nav-toggler navbar-trigger"><span class="fa fa-bars"></span></a>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div id="nav-mobile"></div>

        <!-- Header Search -->
        <div class="search-popup">
            <span class="search-back-drop"></span>
            <button class="close-search"><span class="fa fa-times"></span></button>
            
            <div class="search-inner">
                <form method="post" action="blog-showcase.html">
                    <div class="form-group">
                        <input type="search" name="search-field" value="" placeholder="Search..." required="">
                        <button type="submit"><i class="flaticon-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Header Search -->

        <!-- Sidebar Cart  -->
        <div class="sidebar-cart">
            <span class="cart-back-drop"></span>
            <div class="shopping-cart">
                <div class="cart-header">
                    <div class="title">Shopping Cart <span>(3)</span></div>
                    <button class="close-cart"><span class="flaticon-add"></span></button>
                </div>
                <ul class="shopping-cart-items">
                    <li class="cart-item">
                        <img src="images/resource/products/product-thumb-1.jpg" alt="#" class="thumb" />
                        <span class="item-name">First Aid Kit</span>
                        <span class="item-quantity">1 x <span class="item-amount">$50.00</span></span>
                        <a href="shop-single.html" class="product-detail"></a>
                        <button class="remove">Remove</button>
                    </li>

                    <li class="cart-item">
                        <img src="images/resource/products/product-thumb-2.jpg" alt="#" class="thumb"  />
                        <span class="item-name">Vitamin Tablet</span>
                        <span class="item-quantity">1 x <span class="item-amount">$25.00</span></span>
                        <a href="shop-single.html" class="product-detail"></a>
                        <button class="remove">Remove</button>
                    </li>

                    <li class="cart-item">
                        <img src="images/resource/products/product-thumb-3.jpg" alt="#" class="thumb"  />
                        <span class="item-name">Zinc Tablet</span>
                        <span class="item-quantity">1 x <span class="item-amount">$15.00</span></span>
                        <a href="shop-single.html" class="product-detail"></a>
                        <button class="remove">Remove</button>
                    </li>
                </ul>

                <div class="cart-footer">
                    <div class="shopping-cart-total"><strong>Subtotal:</strong> $90.00</div>
                    <a href="shopping-cart.html" class="theme-btn btn-style-three"><span class="btn-title">View Cart</span></a>
                    <a href="checkout.html" class="theme-btn btn-style-one"><span class="btn-title">Checkout</span></a>
                </div>
            </div> <!-- End shopping-cart -->
        </div>
        <!-- End Sidebar Cart  -->
    </header>
    <!--End Main Header -->

    <!--Page Title-->
    <section class="page-title" style="background-image: url(images/background/1-1.png);">
        <div class="auto-container">
            <div class="title-outer">            
                <h1>About Us</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>About</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

	<!-- About Section -->
	<section class="about-section">
		<div class="auto-container">
			<div class="row">
				<!-- Content Column -->
				<div class="content-column col-lg-12 col-md-12 col-sm-12">
					<div class="inner-column">
						<div class="sec-title">
							<span class="sub-title">OUR MEDICAL</span>
							<h2>Setting Standards in Research and Clinical Care</h2>
							<span class="divider"></span>
						</div>
						<br>
						<!-- Clinic Overview -->
						<div class="about-content">
							<h3 class="content-title">Clinic Overview</h3>
							<p>Founded in 1985 by Dr. Tony Thong, Thong's Clinic has been a cornerstone of healthcare in Bahau, Negeri Sembilan. The clinic is renowned for its compassionate and effective medical care, providing a trusted resource for the community.</p>
						</div>

						<!-- Mission Statement -->
						<div class="about-content">
							<h3 class="content-title">Mission Statement</h3>
							<p>"Our mission is to deliver comprehensive medical services with a focus on patient-centered care. We aim to enhance the health and well-being of our community through accessible, reliable, and personalized healthcare."</p>
						</div>

						<!-- Clinic Values -->
						<div class="about-content">
							<h3 class="content-title">Clinic Values</h3>
							<ul class="values-list">
								<li><strong>Compassion:</strong> We treat each patient with kindness and empathy.</li>
								<li><strong>Integrity:</strong> We uphold the highest standards of ethical practice.</li>
								<li><strong>Excellence:</strong> We are committed to delivering superior medical care.</li>
								<li><strong>Community:</strong> We value our role in supporting the health and wellness of Bahau.</li>
							</ul>
						</div>

						<!-- History -->
						<div class="about-content">
							<h3 class="content-title">History</h3>
							<p>Thong's Clinic was founded by Dr. Tony Thong with a vision to improve healthcare services in Bahau. Over the years, the clinic has grown and evolved while maintaining its commitment to exceptional care and community service.</p>
						</div>

						<!-- Our Team -->
						<div class="about-content">
							<h3 class="content-title">Our Team</h3>
							<p>Dr. Tony Thong, the founder, is a highly respected medical professional with extensive experience in general medicine. His son, Dr. Thong Joo Hock, continues the family legacy, contributing his expertise to uphold the clinic's high standards of care.</p>
						</div>
					</div>
				</div>
				<!-- End Content Column -->
			</div>
		</div>
	</section>
	<!-- End About Section -->

	<!-- About Section CSS -->
	<style>
		.about-section {
			padding: 60px 20px;
			background-color: #f9f9f9;
		}

		.sec-title {
			margin-bottom: 40px;
		}

		.sec-title .sub-title {
			font-size: 18px;
			color: #3498db;
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
			text-transform: uppercase;
		}

		.sec-title h2 {
			font-size: 36px;
			margin-bottom: 20px;
			color: #2c3e50;
			line-height: 1.4;
		}

		.sec-title .divider {
			width: 80px;
			height: 4px;
			background: #3498db;
			margin-bottom: 20px;
			border-radius: 2px;
		}

		.about-content {
			margin-bottom: 50px;
		}

		.about-content h3.content-title {
			font-size: 28px;
			color: #2c3e50;
			margin-bottom: 15px;
			position: relative;
			padding-bottom: 10px;
			border-bottom: 2px solid #3498db;
			display: inline-block;
		}

		.about-content p {
			font-size: 16px;
			color: #5a5a5a;
			line-height: 1.8;
			margin-bottom: 20px;
		}

		.values-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.values-list li {
			font-size: 16px;
			color: #5a5a5a;
			margin-bottom: 10px;
			line-height: 1.6;
		}

		.values-list li strong {
			color: #2c3e50;
		}
	</style>
	<!-- End About Section CSS -->

    
    <!-- Fun Fact Section Two-->
		<section class="fun-fact-section-two">
		<div class="auto-container">
			<div class="row justify-content-center">
				<!--Column-->
				<div class="counter-column col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
					<div class="count-box">
						<div class="icon-box"><span class="icon flaticon-user-experience"></span></div>
						<h4 class="counter-title">Years of Experience</h4>
						<span class="count-text" data-speed="3000" data-stop="39">0</span>
					</div>
				</div>
				
				<!--Column-->
				<div class="counter-column col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
					<div class="count-box">
						<div class="icon-box"><span class="icon flaticon-hospital"></span></div>
						<h4 class="counter-title">Medical Spesialities</h4>
						<span class="count-text" data-speed="3000" data-stop="689">0</span>
					</div>
				</div>

				<!--Column-->
				<div class="counter-column col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="1200ms">
					<div class="count-box">
						<div class="icon-box"><span class="icon flaticon-add-friend"></span></div>
						<h4 class="counter-title">Happy Patients</h4>
						<span class="count-text" data-speed="3000" data-stop="9036">0</span>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- Fun Fact Section Two -->

    <!-- Team Section Two -->
    <section class="team-section-two alternate">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">MEET OUR EXPERIENCED TEAM</span>
                <h2>Our Dedicated Doctors Team.</h2>
                <span class="divider"></span>
            </div>

            <div class="row">
                <!-- Team Block -->
                <div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="inner-box">
                        <div class="image-box">
                           <figure class="image"><a href="doctor-detail.html"><img src="Dr_Thong2.jpg" alt="Dr.Thong"></a></figure>
                        </div>
                        <div class="info-box">
                            <h5 class="name"><a href="doctor-detail.html">Doctor Tony Thong</a></h5>
                            <span class="designation">General Medicine</span>
                        </div>
                    </div>
                </div>

                <!-- Team Block -->
                <div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
                    <div class="inner-box">
                        <div class="image-box">
                           <figure class="image"><a href="doctor-detail.html"><img src="Dr_Chia2.jpg" alt="Dr.Chia"></a></figure>
                        </div>
                        <div class="info-box">
                            <h5 class="name"><a href="doctor-detail.html">Doctor Chia</a></h5>
                            <span class="designation">General Medicine</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sec-bottom-text">Don’t hesitate, contact us for better help and services. <a href="doctor-detail.html">Explore all Dr. Team</a></div>
        </div>
    </section>
    <!--End Team Section -->
	 <!--Team Section CSS -->
	<style>
		.team-section-two .row {
		justify-content: center;
	}

	.team-section-two .sec-bottom-text {
		text-align: center;
		margin-top: 30px;
	}

	.team-section-two .sec-title.text-center {
		text-align: center;
		margin-bottom: 50px;
	}

	.team-section-two .inner-box {
		margin-left: auto;
		margin-right: auto;
	}

	.team-section-two .team-block-two {
		margin-bottom: 30px;
		display: flex;
		justify-content: center;
	}
	</style>
	 <!--End Team Section CSS -->
	 
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



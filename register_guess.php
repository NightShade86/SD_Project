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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <div class="logo"><a href="index_guess.html"><img src="images/logo-9.png" alt="" title=""></a></div>
                    </div>

                    <!--Nav Box-->
                    <div class="nav-outer">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="dropdown">
                                    <span>Home</span>
                                    <ul>
                                        <li><a href="index_guess.html">Home Medical</a></li>
                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <span>Pages</span>
                                    <ul>
                                        <li><a href="about-us_guess.html">About Us</a></li>
                                        <li><a href="services_guess.html">Services</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <span>Doctors</span>
                                    <ul>
                                        <li><a href="doctor-detail_guess.html">Doctor Detail</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <span>Blog</span>
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
								<li class="dropdown current">
                                    <span>Login</span>
                                    <ul>
										<li><a href="login_guess.php">Login</a></li>
										<li><a href="register_guess.php">Register</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact_guess.html">Contact</a></li>
							</ul>
						</nav>
						<!-- Main Menu End-->

						<div class="outer-box">
							
						</div>
                    </div>
                </div>
            </div>
        </div>

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
    <section class="page-title" style="background-image: url(images/background/8.jpg);">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Register</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Shop</li>
                </ul> 
            </div>
        </div>
    </section>
    <!--End Page Title-->
    <?php
    $firstname = isset($_SESSION['form_data']['firstname']) ? htmlspecialchars($_SESSION['form_data']['firstname']) : '';
    $lastname = isset($_SESSION['form_data']['lastname']) ? htmlspecialchars($_SESSION['form_data']['lastname']) : '';
    $no_tel = isset($_SESSION['form_data']['no_tel']) ? htmlspecialchars($_SESSION['form_data']['no_tel']) : '';
    $email = isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '';
    $ic = isset($_SESSION['form_data']['ic']) ? htmlspecialchars($_SESSION['form_data']['ic']) : '';
    $user_id = isset($_SESSION['form_data']['user_id']) ? htmlspecialchars($_SESSION['form_data']['user_id']) : '';
    
if (isset($_SESSION['error_message'])) {
    echo "<script>
    Swal.fire({
        title: 'Error!',
        text: '" . $_SESSION['error_message'] . "',
        icon: 'error'
    });
    </script>";
    unset($_SESSION['error_message']); // Clear the error message after displaying it
}

if (isset($_SESSION['success_message'])) {
    echo "<script>
    Swal.fire({
        title: 'Success!',
        text: '" . $_SESSION['success_message'] . "',
        icon: 'success'
    }).then(function() {
        window.location = 'login_patient.php';
    });
    </script>";
    unset($_SESSION['success_message']); // Clear the success message after displaying it
    unset($_SESSION['form_data']);
}
?>
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
                      <input type="text" id="firstname" name="firstname" required 
    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;"
    value="<?php echo $firstname; ?>">
					</div>
					
					<div class="form-group">
					  <label for="lastname" style="font-weight: bold;">Last Name:</label>
					  <input type="text" id="lastname" name="lastname" required
    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;"
    value="<?php echo $lastname; ?>">
					</div>
					
					<div class="form-group">
					  <label for="no_tel" style="font-weight: bold;">Phone Number:</label>
					  <input type="text" id="no_tel" name="no_tel"
    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;"
    value="<?php echo $no_tel; ?>">
					</div>

					<div class="form-group">
					  <label for="email" style="font-weight: bold;">Email:</label>
					  <input type="email" id="email" name="email" required
    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;"
    value="<?php echo $email; ?>">
					</div>
					
					<div class="form-group">
					  <label for="ic" style="font-weight: bold;">IC:</label>
					  <input type="text" id="ic" name="ic" required
    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;"
    value="<?php echo $ic; ?>">
					</div>
					
					<div class="form-group">
					  <label for="user_id" style="font-weight: bold;">Username:</label>
					  <input type="text" id="user_id" name="user_id" required
    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;"
    value="<?php echo $user_id; ?>">
					</div>
					
					<div class="form-group">
					  <label for="password" style="font-weight: bold;">Password:</label>
					  <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
					</div>

                    <div class="form-group">
                        <label for="password_confirmation" style="font-weight: bold;">Confirm Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
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
                                    <div class="logo">
                                        <a href="index.html"><img src="images/logo-2.png" alt="" /></a>
                                    </div>
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



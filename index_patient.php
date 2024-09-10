
<a?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Medicoz | Health and Medical HTML Template | Home Page 01</title>

<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="plugins/revolution/css/settings.css" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
<link href="plugins/revolution/css/layers.css" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
<link href="plugins/revolution/css/navigation.css" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->
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
    <header class="main-header header-style-one">

        <!-- Header top -->
        <div class="header-top">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="top-left">
                        <ul class="contact-list clearfix">
                            <li><i class="flaticon-hospital-1"></i>34, Jalan Besar, 72100 Bahau, Negeri Sembilan </li>
                            <li><i class="flaticon-back-in-time"></i>Monday - Thursday 9.00am - 9.00pm , Friday 9.00am - 5.00pm. Sunday and Saturday CLOSED</li>
                        </ul>
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
                        <div class="logo"><a href="index.html"><img src="images/logo-8-1.png" alt="" title=""></a></div>
                    </div>

                    <!--Nav Box-->
                    <div class="nav-outer">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current dropdown">
                                    <span>Home</span>
                                    <ul>
                                        <li class="current"><a href="index_patient.html">Home Medical</a></li>
                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <span>Pages</span>
                                    <ul>
                                        <li><a href="about-us_patient.html">About Us</a></li>
                                        <li><a href="services_patient.html">Services</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <span>Doctors</span>
                                    <ul>
                                        <li><a href="doctor-detail_patient.html">Doctor Detail</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
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
                                <li class="dropdown">
                                    <span>Shop</span>
                                    <ul>
                                        <li><a href="shop.html">Shop</a></li>
                                        <li><a href="shop-single.html">Shop Single</a></li>
                                        <li><a href="shopping-cart.html">Shopping Cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul>
                                </li> -->
								<li class="dropdown">
                                    <span>Profile</span>
                                    <ul>
										<li><a href="profile.php">Profile</a></li>
										<li><a href="logout.php">Logout</a></li>
                                    </ul>
                                    <li><a href="contact_patient.html">Contact</a></li>
                                </li>
                            </ul>
                        </nav>
                        <!-- Main Menu End-->
                    </div>
                </div>
            </div>
        </div>
		
		<style>
			.nav-outer {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		padding: 10px 20px;
	}

	.nav.main-menu .navigation {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
		padding: 0;
		margin: 0;
		list-style: none;
	}

	.nav.main-menu .navigation > li {
		position: relative;
	}

	.dropdown ul {
		position: absolute;
		left: 0;
		top: 100%;
		display: none;
		flex-direction: column;
		background-color: #fff;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		min-width: 200px;
	}

	.dropdown:hover ul,
	.dropdown:focus-within ul {
		display: block;
	}

	@media (max-width: 768px) {
		.nav-outer {
			flex-direction: column;
			align-items: flex-start;
		}

		.nav.main-menu .navigation {
			flex-direction: column;
			width: 100%;
		}

		.nav.main-menu .navigation > li {
			width: 100%;
		}

		.dropdown ul {
			position: static;
			box-shadow: none;
		}
	}

		</style>

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
    </header>
    <!--End Main Header -->

    <!--Main Slider-->
    <section class="main-slider">
        <div class="rev_slider_wrapper fullwidthbanner-container"  id="rev_slider_one_wrapper" data-source="gallery">
            <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
                <ul>
                    <li data-index="rs-1" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-thumb=""  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        
                        <!-- MAIN IMAGE -->
                        <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="20" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="images/main-slider/1-1.png">

                        <div class="tp-caption" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[0,0,0,0]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-width="['750','750','750','650']"
                        data-whitespace="normal"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['-180','-170','-180','-180']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <span class="title">Welcome to our Medical Care Center </span>
                        </div>

                        <div class="tp-caption" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[15,15,15,15]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-width="['750','750','750','650']"
                        data-whitespace="normal"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['-100','-95','-100','-115']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <h2>We take care our <br>patients health</h2>
                        </div>

                        <div class="tp-caption" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[15,15,15,15]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-width="['700','750','700','450']"
                        data-whitespace="normal"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['0','0','0','0']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="text">I realized that becoming a doctor, I can only help a small community. <br>But by becoming a doctor, I can help my whole country. </div>
                        </div>
                        
                        <div class="tp-caption tp-resizeme" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[15,15,15,15]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-whitespace="normal"
                        data-width="['650','650','700','300']"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['80','90','90','140']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="btn-box">
                                <a href="about-us_patient.html" class="theme-btn btn-style-one"><span class="btn-title">About Us</span></a>
                                <a href="services_patient.html" class="theme-btn btn-style-two"><span class="btn-title">Our Services</span></a>
                            </div>
                        </div>
                    </li>

                    <li data-index="rs-2" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-thumb=""  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        
                        <!-- MAIN IMAGE -->
                        <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="20" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="images/main-slider/1-1.png">

                        <div class="tp-caption" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[0,0,0,0]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-width="['750','750','750','650']"
                        data-whitespace="normal"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['-180','-170','-180','-180']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <span class="title">Welcome to our Medical Care Center </span>
                        </div>

                        <div class="tp-caption" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[15,15,15,15]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-width="['750','750','750','650']"
                        data-whitespace="normal"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['-100','-95','-100','-115']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <h2>We take care our <br>patients health</h2>
                        </div>

                        <div class="tp-caption" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[15,15,15,15]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-width="['700','750','700','450']"
                        data-whitespace="normal"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['0','0','0','0']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="text">I realized that becoming a doctor, I can only help a small community. <br>But by becoming a doctor, I can help my whole country. </div>
                        </div>
                        
                        <div class="tp-caption tp-resizeme" 
                        data-paddingbottom="[0,0,0,0]"
                        data-paddingleft="[15,15,15,15]"
                        data-paddingright="[15,15,15,15]"
                        data-paddingtop="[0,0,0,0]"
                        data-responsive_offset="on"
                        data-type="text"
                        data-height="none"
                        data-whitespace="normal"
                        data-width="['650','650','700','300']"
                        data-hoffset="['0','0','0','0']"
                        data-voffset="['80','90','90','140']"
                        data-x="['left','left','left','left']"
                        data-y="['middle','middle','middle','middle']"
                        data-textalign="['top','top','top','top']"
                        data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
                            <div class="btn-box">
                                <a href="about-us.html" class="theme-btn btn-style-one"><span class="btn-title">About Us</span></a>
                                <a href="departments.html" class="theme-btn btn-style-two"><span class="btn-title">Our Services</span></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Main Slider-->

    <!-- Top Features -->
    <section class="top-features">
        <div class="auto-container">
            <div class="row">
                <!-- Feature Block -->
                <div class="feature-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <span class="icon flaticon-charity"></span>
                        <h4><a href="#">Quality & Safety</a></h4>
                        <p>Our Clinic utilizes state of the art technology and employs a team of true experts.</p>
                    </div>
                </div>

                <!-- Feature Block -->
                <div class="feature-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <span class="icon flaticon-lifeline"></span>
                        <h4><a href="#">Leading Technology</a></h4>
                        <p>Our Clinic utilizes state of the art technology and employs a team of true experts.</p>
                    </div>
                </div>

                <!-- Feature Block -->
                <div class="feature-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <span class="icon flaticon-doctor"></span>
                        <h4><a href="#">Experts by Experience</a></h4>
                        <p>Our Clinic utilizes state of the art technology and employs a team of true experts.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Features Section -->


    <!-- About Section -->
    <section class="about-section">
        <div class="auto-container">
            <div class="row">
                <!-- Content Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">OUR MEDICAL</span>
                            <h2>We're setting Standards in Research what's more, Clinical Care.</h2>
                            <span class="divider"></span>
                            <p>We provide the most full medical services, so every person could have the pportunity o receive qualitative medical help.</p>
                            <p> Our Clinic has grown to provide a world class facility for the treatment of tooth loss, dental cosmetics and bore advanced restorative dentistry. We are among the most qualified implant providers in the AUS with over 30 years of uality training and experience.</p>
                        </div>
                        <div class="link-box">
                            <figure class="signature"><img src="images/resource/signature.png" alt=""></figure>
                            <a href="#" class="theme-btn btn-style-one"><span class="btn-title">More About</span></a>
                        </div>
                    </div>
                </div>

                <!-- Images Column -->
                <div class="images-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="video-link">
                            <a href="https://www.youtube.com/watch?v=4UvS3k8D4rs" class="play-btn lightbox-image" data-fancybox="images"><span class="flaticon-play-button-1"></span></a>
                        </div>
                        <figure class="image-1"><img src="image_1.jpg" alt=""></figure>
                        <figure class="image-2"><img src="image_2.jpg" alt=""></figure>
                        <figure class="image-3">
                            <span class="hex"></span>
                            <img src="image_3.jpg" alt="">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- Services Section -->
	<section class="services-section" style="background-image: url('background-image.jpg'); background-size: cover; background-position: center;">
	  <div class="auto-container">
		<div class="sec-title text-center">
		  <span class="sub-title">OUR SERVICES</span>
		  <h2>Comprehensive Medical Services for Your Well-Being</h2>
		  <span class="divider"></span>
		</div>
		<div class="row justify-content-center">
		  <!-- Service Block -->
		  <div class="service-block col-lg-4 col-md-6 col-sm-12">
			<div class="inner-box">
			  <span class="icon flaticon-heartbeat"></span>
			  <h5><a href="#">General Services</a></h5>
			  <div class="text">
				<ul>
				  <li><strong>Medical Consultations:</strong> Comprehensive assessments and personalized care plans for various health conditions.</li>
				  <li><strong>Preventive Care:</strong> Health screenings, vaccinations, and preventive advice to maintain your health.</li>
				  <li><strong>Chronic Disease Management:</strong> Ongoing care for conditions like diabetes, hypertension, and kidney stones.</li>
				</ul>
			  </div>
			</div>
		  </div>

		  <!-- Service Block -->
		  <div class="service-block col-lg-4 col-md-6 col-sm-12">
			<div class="inner-box">
			  <span class="icon flaticon-heartbeat"></span>
			  <h5><a href="#">Patient Care</a></h5>
			  <div class="text">
				<p>At Thong's Clinic, we prioritize personalized and attentive care for every patient. Our services cater to diverse needs, ensuring optimal health outcomes. Whether you need general consultations or specialized care, we're here to support your health and well-being.</p>
			  </div>
			</div>
		  </div>

		  <!-- Service Block -->
		  <div class="service-block col-lg-4 col-md-6 col-sm-12">
			<div class="inner-box">
			  <span class="icon flaticon-lab"></span>
			  <h5><a href="#">Diagnostic Services</a></h5>
			  <div class="text">
				<ul>
				  <li><strong>Laboratory Tests:</strong> Basic tests, including blood work and urine analysis.</li>
				  <li><strong>Imaging Services:</strong> X-rays and referrals for advanced imaging.</li>
				  <li><strong>Influenza and COVID-19 Testing:</strong> Rapid and accurate testing for these infections.</li>
				</ul>
			  </div>
			</div>
		  </div>

		  <!-- Service Block -->
		  <div class="service-block col-lg-4 col-md-6 col-sm-12">
			<div class="inner-box">
			  <span class="icon flaticon-first-aid"></span>
			  <h5><a href="#">Specialized Services</a></h5>
			  <div class="text">
				<ul>
				  <li><strong>Pregnancy Check-Ups and Scans:</strong> Comprehensive prenatal care to ensure mother and baby's health.</li>
				  <li><strong>Kidney Stones Treatment:</strong> Management and lifestyle advice for kidney stones (sakit batu karang).</li>
				  <li><strong>Diabetes Care:</strong> Specialized plans including regular monitoring and dietary advice.</li>
				</ul>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>
	<!-- End Services Section -->
	

	<!-- Services Section CSS -->
	<style>
	.services-section {
	  padding: 60px 0;
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  flex-direction: column;
	  background-size: cover;
	  background-position: center;
	}

	.sec-title {
	  margin-bottom: 50px;
	}


	.sec-title .sub-title {
		font-size: 18px;
		color: #3498db;
		display: block;
		margin-bottom: 10px;
	}

	.sec-title h2 {
		font-size: 32px;
		margin-bottom: 20px;
	}

	.sec-title .divider {
		width: 50px;
		height: 4px;
		background: #3498db;
		margin: 0 auto;
		margin-bottom: 40px;
	}

	.service-block {
		margin-bottom: 30px;
	}

	.inner-box {
    background-color: #fff;
    padding: 30px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 400px;
    overflow-y: auto; 
    -ms-overflow-style: none; 
    scrollbar-width: none;
	}

	.inner-box::-webkit-scrollbar {
		display: none; 
	}

	.icon {
		font-size: 40px;
		color: #3498db;
		margin-bottom: 15px;
	}

	h5 {
		font-size: 22px;
		color: #2c3e50;
		margin-bottom: 15px;
	}

	h5 a {
		text-decoration: none;
		color: #2c3e50;
	}

	.text {
		font-size: 16px;
		color: #5a5a5a;
		line-height: 1.8;
	}

	.text ul {
		padding-left: 20px;
		list-style: disc;
	}

	.text ul li {
		margin-bottom: 10px;
	}

	.text p {
		margin-bottom: 15px;
	}
	</style>
	<!-- End Services Section CSS -->

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

    <!-- Appointment Section 
    <section class="appointment-section">
        <div class="image-layer" style="background-image: url(images/background/2.jpg);"></div>
        <div class="auto-container">
            <div class="row">
                 
                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <span class="title">Need a Doctor for Check-up?</span>
                        <h2>Just Make an Appointment <br>and You’re Done!</h2>
                        <div class="number">Get Your Quote or Call: <strong>(0080) 123-453-789</strong></div>
                        <a href="#" class="theme-btn btn-style-three"><span class="btn-title">Get an Appointment</span></a>
                    </div>
                </div>
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <figure class="image"><img src="images/resource/image-4.png" alt=""></figure>
                </div>
            </div>

            <div class="fun-fact-section">
                <div class="auto-container">
			<div class="row justify-content-center">
			
				<div class="counter-column col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
					<div class="count-box">
						<div class="icon-box"><span class="icon flaticon-user-experience"></span></div>
						<h4 class="counter-title">Years of Experience</h4>
						<span class="count-text" data-speed="3000" data-stop="39">0</span>
					</div>
				</div>
				
				
				<div class="counter-column col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
					<div class="count-box">
						<div class="icon-box"><span class="icon flaticon-hospital"></span></div>
						<h4 class="counter-title">Medical Spesialities</h4>
						<span class="count-text" data-speed="3000" data-stop="689">0</span>
					</div>
				</div>

				
				<div class="counter-column col-lg-3 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="1200ms">
					<div class="count-box">
						<div class="icon-box"><span class="icon flaticon-add-friend"></span></div>
						<h4 class="counter-title">Happy Patients</h4>
						<span class="count-text" data-speed="3000" data-stop="9036">0</span>
					</div>
				</div>
			</div>
		</div>
            </div>
        </div>
    </section> -->
     
    <!-- End Appointment Section -->
	
     <!-- News Section 
    <section class="news-section">
        <div class="auto-container">
            
            <div class="sec-title text-center">
                <span class="title">OUR BLOG</span>
                <h2>Recent Articles and News</h2>
                <span class="divider"></span>
            </div>

            <div class="row">
               
                <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image"><a href="blog-post-image.html"><img src="images/resource/news-1.jpg" alt=""></a></figure>
                            <a href="#" class="date">Sep 19, 2020</a>
                        </div>
                        <div class="lower-content">
                            <h4><a href="blog-post-image.html">What is The Success rate<br> of a root canel?</a></h4>
                            <div class="text">Nullam mauris vitae tortor sodales efficitur. Quisque orci ante. Proin amet turpis</div>
                            <div class="post-info">
                                <div class="post-author">By Admin Rose</div>
                                <ul class="post-option">
                                    <li><a href="#">0 <i class="far fa-heart"></i></a></li>
                                    <li><a href="#">0 <i class="far fa-comments"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image"><a href="blog-post-image.html"><img src="images/resource/news-2.jpg" alt=""></a></figure>
                            <a href="#" class="date">Sep 19, 2020</a>
                        </div>
                        <div class="lower-content">
                            <h4><a href="blog-post-image.html">How to handle your kids’ <Br>mystery ailments?</a></h4>
                            <div class="text">Nullam mauris vitae tortor sodales efficitur. Quisque orci ante. Proin amet turpis</div>
                            <div class="post-info">
                                <div class="post-author">By Admin Rose</div>
                                <ul class="post-option">
                                    <li><a href="#">0 <i class="far fa-heart"></i></a></li>
                                    <li><a href="#">0 <i class="far fa-comments"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image"><a href="blog-post-image.html"><img src="images/resource/news-3.jpg" alt=""></a></figure>
                            <a href="#" class="date">Sep 19, 2020</a>
                        </div>
                        <div class="lower-content">
                            <h4><a href="blog-post-image.html">How to help the cardiology <br>department</a></h4>
                            <div class="text">Nullam mauris vitae tortor sodales efficitur. Quisque orci ante. Proin amet turpis</div>
                            <div class="post-info">
                                <div class="post-author">By Admin Rose</div>
                                <ul class="post-option">
                                    <li><a href="#">0 <i class="far fa-heart"></i></a></li>
                                    <li><a href="#">0 <i class="far fa-comments"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> -->

    <!--End News Section -->

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
                           <li><a href="about-us_guess.html">Contact</a></li> 
                           <li><a href="services_guess.html">Services</a></li>  
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
<!--Revolution Slider-->
<script src="plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.video.min.js"></script>
<script src="js/main-slider-script.js"></script>
<!--Revolution Slider-->
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/mmenu.polyfills.js"></script>
<script src="js/jquery.modal.min.js"></script>
<script src="js/mmenu.js"></script>
<script src="js/appear.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/script.js"></script>
</body>
</html>



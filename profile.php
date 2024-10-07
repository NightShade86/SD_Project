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

    // Determine user table and ID column based on role
    switch ($role) {
        case 'admin':
            $table = 'admin_info';
            $id_column = 'USER_ID';
            $userR = "Admin";
            break;
        case 'staff':
            $table = 'staff_info';
            $id_column = 'STAFF_ID';
            $userR = "Staff";
            break;
        default:
            $table = 'user_info';
            $id_column = 'USER_ID';
            $userR = "Patient";
            break;
    }

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtcmsdb";

    $connection = new mysqli($servername, $username, $password, $dbname);

    // Prepare and execute query to retrieve user data
    $user_info = $connection->prepare("SELECT * FROM $table WHERE $id_column=?");
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css">
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
	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Display error message -->
    <?php if (isset($_SESSION['error_message'])) : ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $_SESSION['error_message']; ?>',
                icon: 'error'
            });
        </script>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Display success message -->
    <?php if (isset($_SESSION['success_message'])) : ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['success_message']; ?>',
                icon: 'success'
            });
        </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

<div class="page-wrapper">
	
    <!-- Header Section -->
    <header class="main-header header-style-two">

    <!-- Header top -->
    <div class="header-top-two">
        <div class="auto-container">
            <div class="inner-container">
                <div class="top-left">
                    <ul class="contact-list clearfix">
                        <li><i class="flaticon-hospital-1"></i>34, J alan Besar, 72100 Bahau, Negeri Sembilan </li>
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
								<li><a href="about-us_patient.php">About Us</a></li>
								<li><a href="contact_patient.php">Contact</a></li>
								<li class="current"> <a href="logout.php">Logout</a></li>
                            <!-- <li class="dropdown">
                                <span>Blog</span>
                                <ul>
                                    <li><a href="blog-checkboard.html">Checkerboard</a></li>
                                    <li><a href="blog-masonry.html">Masonry</a></li>
                                    <li><a href="blog-two-col.html">Two Columns</a></li>
                                    <li><a href="blog-three-col .html">Three Columns</a></li>
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
</div>

    <!-- Main Content Section -->
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">Account settings</h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#view-profile">View Profile</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-general">Edit Profile</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">

                        <!-- View Profile Tab -->
                        <div class="tab-pane fade show active" id="view-profile">
                            <div style="padding: 30px">
                                <form>
                                    <h2>Profile</h2>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">First Name</label>
                                        <input type="text" name="fname" value="<?php echo $fname; ?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">Last Name</label>
                                        <input type="text" name="lname" value="<?php echo $lname; ?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">Identification Card Number</label>
                                        <input type="text" name="ic" value="<?php echo $ic; ?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">User  Type</label>
                                        <input type="text" name="lname" value="<?php echo $userR; ?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10 px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0, 0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">Phone Number</label>
                                        <input type="text" name="pnum" value="<?php echo $pnum; ?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">Email</label>
                                        <input type="text" name="email" value="<?php echo $email; ?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <form action="upload.php" method="post" enctype="multipart/form-data">
                                        <label for="profilePicture">Select Profile Picture (Max 5MB):</label>
                                        <input type="file" name="profilePicture" id="profilePicture" required>
                                        <input type="submit" value="Upload">
                                    </form>
                                    <div class="text-dark small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>

                            <hr class="border-light m-0">

                            <div class="card-body">
                                <form action="updateprofileprocess.php" method="post">
                                    <div class="form-group">
                                        <label for="firstname" style="font-weight: bold; color: #333;">First Name</label>
                                        <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" style="font-weight: bold; color: #333;">Last Name</label>
                                        <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" style="font-weight: bold; color: #333;">Email</label>
                                        <input type="email" id="email" name="email" placeholder="Enter your email address" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label for="pnum" style="font-weight: bold; color: #333;">Phone Number</label>
                                        <input type="text" id="pnum" name="pnum" placeholder="Enter your phone number" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
                                    <div class="form-group">
                                        <label for="ic" style="font-weight: bold; color: #333;">Identification Card Number</label>
                                        <input type="text" id="ic" name="ic" placeholder="Enter your IC" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>
										<button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <form action="updatepasswordprocess.php" method="post">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" name="current-password" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="new-password" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" name="confirm-password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
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
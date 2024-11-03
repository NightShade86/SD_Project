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
    $image = $user['IMAGE'] ?? 'default-avatar.png';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
// Check if 'verified' exists in the URL
if (isset($_GET['verified'])) {
    $authenticatedisplay = "none";
    $updatedisplay = "block";
} else {

    $authenticatedisplay = "block";
    $updatedisplay = "none";
}
?>


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
<?php
if (isset($_SESSION['error_message'])) : ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: '<?php echo $_SESSION['error_message']; ?>',
            icon: 'error'
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

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

<!-- Main Content Section -->
<div class="container light-style flex-grow-1 container-p-y">
    <?php
    $back_url = '';
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            $back_url = 'admin_dashboard.php';
        } elseif ($_SESSION['role'] == 'staff') {
            $back_url = 'staff_dashboard.php';
        }
    }
    ?>
    <a href="<?= $back_url ?>" class="btn btn-secondary">Back</a>
    <h4 class="font-weight-bold py-3 mb-4">
        Account settings
    </h4>
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
                                <?php if (!empty($image)) : ?>
                                    <img src="uploaded_img/<?php echo $image; ?>" alt="Profile Image" style="width: 150px; margin-top: 10px;">
                                <?php endif; ?>
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
                        <div class="card-body">
                            <!-- Authentication Form -->
                            <div id="authenform" class="login-form register-form" style="display: <?php echo $authenticatedisplay; ?>; padding: 30px; border-radius: 10px;">
                                <form action="user_authentication_sa.php" method="post">
                                    <h2>Please enter your username and password to verify your identity.</h2>
                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">Username</label>
                                        <input type="text" name="uname" placeholder="Enter your username here" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>

                                    <div class="form-group">
                                        <label style="font-weight: bold; color: #333;">Enter Your Password</label>
                                        <input type="password" name="pwd" placeholder="Enter your password here" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </div>

                                    <div class="form-group">
                                        <button class="theme-btn btn-style-one" type="submit" name="login" style="width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                                            <span class="btn-title">Authenticate</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <br><br>

                            <hr class="border-light m-0">

                            <!-- Update Form -->
                            <div id="updateform" class="card-body" style="display: <?php echo $updatedisplay; ?>; padding: 30px; border-radius: 10px;">
                            <h2>Edit Profile</h2>

                                <?php if (!empty($image)) : ?>
                                    <img src="uploaded_img/<?php echo $image; ?>" alt="Profile Image" style="width: 150px; margin-top: 10px;">
                                <?php endif; ?>
							<form action="updateprofileprocess.php" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="firstname">First Name</label>
									<input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $fname; ?>" required>
								</div>

								<div class="form-group">
									<label for="lastname">Last Name</label>
									<input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $lname; ?>" required>
								</div>

								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" id="username" name="username" class="form-control" value="<?php echo $userid; ?>" required>
								</div>

								<div class="form-group">
									<label for="ic">IC (Identity Card)</label>
									<input type="text" id="ic" name="ic" class="form-control" value="<?php echo $ic; ?>" required>
								</div>

								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" readonly required>
								</div>

								<div class="form-group">
									<label for="pnumber">Phone Number</label>
									<input type="text" id="pnumber" name="pnumber" class="form-control" value="<?php echo $pnum; ?>" required>
								</div>

								<div class="form-group">
									<label for="update_image">Update Profile Picture</label>
									<input type="file" id="update_image" name="update_image" class="form-control" accept="image/*" onchange="previewImage(event)">
                                    <img id="image_preview" src="" alt="Image Preview" style="display: none; max-width: 200px; margin-top: 10px;">

                                </div>

								<input type="hidden" name="ogusername" value="<?php echo $userid; ?>">

								<button type="submit" class="btn btn-primary">Save Changes</button>
							</form>
						</div>

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

<script>
    function previewImage(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('image_preview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image element
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    }
</script>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"></script>

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
<style>
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 10px 0;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    body {
        background: #f5f5f5;
        margin-top: 20px;
    }

    .ui-w-80 {
        width: 80px !important;
        height: auto;
    }

    .btn-default {
        border-color: rgba(24, 28, 33, 0.1);
        background: rgba(0, 0, 0, 0);
        color: #4E5155;
    }

    label.btn {
        margin-bottom: 0;
    }

    .btn-outline-primary {
        border-color: #26B4FF;
        background: transparent;
        color: #26B4FF;
    }

    .btn {
        cursor: pointer;
    }

    .text-light {
        color: #babbbc !important;
    }

    .btn-facebook {
        border-color: rgba(0, 0, 0, 0);
        background: #3B5998;
        color: #fff;
    }

    .btn-instagram {
        border-color: rgba(0, 0, 0, 0);
        background: #000;
        color: #fff;
    }

    .card {
        background-clip: padding-box;
        box-shadow: 0 1px 4px rgba(24, 28, 33, 0.012);
    }

    .row-bordered {
        overflow: hidden;
    }

    .account-settings-fileinput {
        position: absolute;
        visibility: hidden;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .account-settings-links .list-group-item.active {
        font-weight: bold !important;
    }

    html:not(.dark-style) .account-settings-links .list-group-item.active {
        background: transparent !important;
    }

    .account-settings-multiselect~.select2-container {
        width: 100% !important;
    }

    .light-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(24, 28, 33, 0.03) !important;
    }

    .light-style .account-settings-links .list-group-item.active {
        color: #4e5155 !important;
    }

    .material-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(24, 28, 33, 0.03) !important;
    }

    .material-style .account-settings-links .list-group-item.active {
        color: #4e5155 !important;
    }

    .dark-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(255, 255, 255, 0.03) !important;
    }

    .dark-style .account-settings-links .list-group-item.active {
        color: #fff !important;
    }

    .light-style .account-settings-links .list-group-item.active {
        color: #4E5155 !important;
    }

    .light-style .account-settings-links .list-group-item {
        padding: 0.85rem 1.5rem;
        border-color: rgba(24, 28, 33, 0.03) !important;
    }

</style>

</html>
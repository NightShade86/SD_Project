<?php
/* 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}
if ($_SESSION['loggedin']){
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        $table = 'admin_info';
        $id_column = 'USER_ID';
        $userR = "Admin";
    } else if ($role === 'staff') {
        $table = 'staff_info';
        $id_column = 'STAFF_ID';
        $userR = "Staff";
    } else {
        $table = 'user_info';
        $id_column = 'USER_ID';
        $userR = "Patient";
    }
}

//Database Details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Establish connection
$connection = new mysqli($servername, $username, $password, $dbname);
$user_info = $connection->prepare("SELECT * FROM $table WHERE $id_column=?");

$user_info->bind_param("s", $userid);
$user_info->execute();
$user_result = $user_info->get_result();
$user = $user_result->fetch_assoc();

$fname = $user['FIRSTNAME'];
$lname = $user['LASTNAME'];
$pnum = $user['NO_TEL'];
$email = $user['EMAIL'];
$ic = $user['IC'];
$usertype = $user['USERTYPE'];

*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body>

<?php
// Display error message
if (isset($_SESSION['error_message'])) {
    echo "<script>
    Swal.fire({
        title: 'Error!',
        text: '" . $_SESSION['error_message'] . "',
        icon: 'error'
    });
    </script>";
    unset($_SESSION['error_message']);
}

// Display success message
if (isset($_SESSION['success_message'])) {
    echo "<script>
    Swal.fire({
        title: 'Success!',
        text: '" . $_SESSION['success_message'] . "',
        icon: 'success'
    });
    </script>";
    unset($_SESSION['success_message']);
}
?>

<div class="container light-style flex-grow-1 container-p-y">
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
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
                                    <input type="text" name="fname" value="<?php echo $fname?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">

                                </div>
                                <div class="form-group">
                                    <label style="font-weight: bold; color: #333;">Last Name</label>
                                    <input type="text" name="lname" value="<?php echo $lname?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                </div>
                                <div class="form-group">
                                    <label style="font-weight: bold; color: #333;">Identification Card Number</label>
                                    <input type="text" name="ic" value="<?php echo $ic?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                </div>
                                <div class="form-group">
                                    <label style="font-weight: bold; color: #333;">User Type</label>
                                    <input type="text" name="lname" value="<?php echo $userR?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                </div>
                                <div class="form-group">
                                    <label style="font-weight: bold; color: #333;">Phone Number</label>
                                    <input type="text" name="pnum" value="<?php echo $pnum?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                </div>
                                <div class="form-group">
                                    <label style="font-weight: bold; color: #333;">Email</label>
                                    <input type="text" name="email" value="<?php echo $email?>" readonly required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Profile Tab -->
                    <div class="tab-pane fade" id="account-general">
                        <div class="card-body media align-items-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt class="d-block ui-w-80">
                            <div class="media-body ml-4">
                                <label class="btn btn-outline-primary">
                                    Upload new photo
                                    <input type="file" class="account-settings-fileinput">
                                </label>
                                &nbsp;
                                <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="text-right mt-3">
        <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
        <button type="button" class="btn btn-default">Cancel</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

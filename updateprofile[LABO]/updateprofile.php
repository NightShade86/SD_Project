<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>

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

    <h2>Update User Information</h2>

<!-- Authentication Form -->
<div id="authenform" class="login-form register-form" style="display: <?php echo $authenticatedisplay; ?>; padding: 30px; border-radius: 10px;">
        <form action="user_authentication_patient.php" method="post">
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

<!-- Update Form -->
<div id="updateform" class="login-form register-form" style="display: <?php echo $updatedisplay; ?>; padding: 30px; border-radius: 10px;">
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
                <label for="username" style="font-weight: bold; color: #333;">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
            </div>

            <div class="form-group">
                <label for="ic" style="font-weight: bold; color: #333;">IC (Identity Card)</label>
                <input type="text" id="ic" name="ic" placeholder="Enter your IC" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
            </div>

            <div class="form-group">
                <label for="email" style="font-weight: bold; color: #333;">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
            </div>

            <div class="form-group">
                <button class="theme-btn btn-style-one" type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                    <span class="btn-title">Save Changes</span>
                </button>
            </div>

        </form>
    </div>
</body>
</html>

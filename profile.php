<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt
                                    class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        <input type="file" class="account-settings-fileinput">
                                    </label> &nbsp;
                                    <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                    <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
							
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
								
                            <hr class="border-light m-0">

							
						<!-- Update Form -->
					<div id="updateform" class="card-body" style="display: <?php echo $updatedisplay; ?>; padding: 30px; border-radius: 10px;">
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
					
                </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repeat new password</label>
                                    <input type="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mt-3">
            <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="button" class="btn btn-default">Cancel</button>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>
<style>
	body {
		background: #f5f5f5;
		margin-top: 20px;
	}

	.ui-w-80 {
		width : 80px !important;
		height: auto;
	}

	.btn-default {
		border-color: rgba(24, 28, 33, 0.1);
		background  : rgba(0, 0, 0, 0);
		color       : #4E5155;
	}

	label.btn {
		margin-bottom: 0;
	}

	.btn-outline-primary {
		border-color: #26B4FF;
		background  : transparent;
		color       : #26B4FF;
	}

	.btn {
		cursor: pointer;
	}

	.text-light {
		color: #babbbc !important;
	}

	.btn-facebook {
		border-color: rgba(0, 0, 0, 0);
		background  : #3B5998;
		color       : #fff;
	}

	.btn-instagram {
		border-color: rgba(0, 0, 0, 0);
		background  : #000;
		color       : #fff;
	}

	.card {
		background-clip: padding-box;
		box-shadow     : 0 1px 4px rgba(24, 28, 33, 0.012);
	}

	.row-bordered {
		overflow: hidden;
	}

	.account-settings-fileinput {
		position  : absolute;
		visibility: hidden;
		width     : 1px;
		height    : 1px;
		opacity   : 0;
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
		padding     : 0.85rem 1.5rem;
		border-color: rgba(24, 28, 33, 0.03) !important;
	}

	.light-style .account-settings-links .list-group-item.active {
		color: #4e5155 !important;
	}

	.material-style .account-settings-links .list-group-item {
		padding     : 0.85rem 1.5rem;
		border-color: rgba(24, 28, 33, 0.03) !important;
	}

	.material-style .account-settings-links .list-group-item.active {
		color: #4e5155 !important;
	}

	.dark-style .account-settings-links .list-group-item {
		padding     : 0.85rem 1.5rem;
		border-color: rgba(255, 255, 255, 0.03) !important;
	}

	.dark-style .account-settings-links .list-group-item.active {
		color: #fff !important;
	}

	.light-style .account-settings-links .list-group-item.active {
		color: #4E5155 !important;
	}

	.light-style .account-settings-links .list-group-item {
		padding     : 0.85rem 1.5rem;
		border-color: rgba(24, 28, 33, 0.03) !important;
	}
</style>

</html>
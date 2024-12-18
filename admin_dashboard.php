<?php
ob_start();
?>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize the section variable
$allowed_sections = [
    "patients", "staff", "add-staff", "edit-staff", "delete-staff", 
    "add-patient", "edit-patient", "delete-patient" , "profile" , "appointment" , "feedback" , "add-bills" ,
	"edit-bills" , "delete-bills" , "view-bills" , "show-bills" , "view-transaction" , "sales-report"
];

$section = isset($_GET["section"]) && in_array($_GET["section"], $allowed_sections) ? $_GET["section"] : "staff";

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

    if (!empty($user['IMAGE'])) {
        $ASimage = $user['IMAGE'];
    } else {
        $ASimage = 'default-avatar.png';
    }
}

?>
<!Doctype html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- jQuery and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').on('click', function() {
                $(this).next('.dropdown-menu').toggle();
            });

            $('.dropdown-menu a').on('click', function() {
                $(this).parent('.dropdown-menu').hide();
            });
        });
    </script>
   <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        #sidebar {
			position: fixed;
			top: 100px; /* Adjust based on your header height */
			left: 0;
			height: calc(100vh - 60px); /* Full height minus the header */
			width: 250px;
			background-color: #003D63;
			padding-top: 20px; /* Extra padding for spacing */
			overflow-y: auto;
			z-index: 1040; /* Lower than header */
		}


        #sidebar .nav-item {
            border-bottom: 1px solid #495057;
        }

        #sidebar .nav-link {
            color: #ffffff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        #sidebar .nav-link i {
            margin-right: 15px;
            font-size: 18px;
        }

        #sidebar .nav-link.active {
            background-color: #495057;
            color: #ffffff;
            font-weight: bold;
        }

        #sidebar .nav-link:hover {
            background-color: #495057;
            color: #ffffff;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .col-md-10.offset-md-2 {
            padding-left: 20px;
        }

         main {
			margin-top: 60px; /* Adjust based on header height */
			padding: 60px;    /* Optional: Add padding for spacing */
		}

		.content {
			background-color: #ffffff;
			padding: 20px;
			border-radius: 10px;
			border: 1px solid #ddd;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
			margin-bottom: 40px;
			margin-top: 40px;
			overflow-x: auto;
		}
		
		.content table {
		width: 100%; /* Set the table width to 100% of its parent container */
		overflow-x: auto; /* Add horizontal scrolling to the table */
		display: block; /* Set the table display to block to enable horizontal scrolling */
		}
		
				/* Profile Dropdown Styles */
		.navbar-nav .dropdown {
			position: relative;
		}

		.navbar-nav .dropdown span {
			display: flex;
			align-items: center;
			font-size: 16px; /* Adjust the font size */
			color: #343a40;
			cursor: pointer;
		}

		.navbar-nav .dropdown span svg {
			margin-right: 8px; /* Add some space between the icon and the text */
			fill: #343a40; /* Color of the SVG icon */
		}

		.navbar-nav .dropdown ul {
			position: absolute;
			top: 100%; /* Position dropdown below the trigger */
			right: 0;
			background-color: #ffffff;
			list-style: none;
			padding: 10px 0;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			display: none; /* Hidden by default */
			min-width: 180px;
			border-radius: 5px;
			z-index: 1000;
		}

		.navbar-nav .dropdown:hover ul {
			display: block; /* Show dropdown on hover */
		}

		.navbar-nav .dropdown ul li {
			padding: 10px 20px;
		}

		.navbar-nav .dropdown ul li a {
			text-decoration: none;
			color: #343a40;
			font-size: 14px;
			display: block;
			width: 100%;
		}

		.navbar-nav .dropdown ul li a:hover {
			background-color: #f4f6f9;
			color: #007bff;
		}

		.navbar-nav .dropdown ul li:last-child a {
			color: #dc3545; /* Highlight the logout link */
		}

		.navbar-nav .dropdown ul li:last-child a:hover {
			background-color: #f8d7da;
			color: #dc3545;
		}

		/* Optional: For small screens, ensure dropdown is responsive */
		@media (max-width: 768px) {
			.navbar-nav .dropdown ul {
				left: auto;
				right: 0;
			}
		}
		
		.navbar-brand img {
			border-radius: 5px; /* Optional: Make the logo slightly rounded */
		}
        .user-avatar-admin {
            width: 27px; /* Smaller size */
            height: 27px;
            border-radius: 50%;
            overflow: hidden;
        }

        .user-avatar-admin img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }



   </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0" id="sidebar">
                <nav class="nav flex-column">
                    <!-- Staff Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white py-3" href="#" id="staffDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Manage Staff
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="staffDropdown">
                            <a class="dropdown-item" href="?section=staff">View Staff</a>
                            <a class="dropdown-item" href="?section=add-staff">Add Staff</a>
                        </div>
                    </div>
                    <!-- Patients Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white py-3" href="#" id="patientDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-procedures" href="?section=patients"></i> Manage Patients
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="patientDropdown">
                            <a class="dropdown-item" href="?section=patients">View Patients</a>
                        </div>
                    </div>
					
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white py-3" href="#" id="appointmentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-calendar-alt"></i> Manage Appointments
						</a>
						<div class="dropdown-menu dropdown-menu-dark" aria-labelledby="appointmentDropdown">
							<a class="dropdown-item" href="?section=appointment">View Appointments</a>
						</div>
					</div>
					
					<div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white py-3" href="#" id="staffDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-file-invoice-dollar"></i> Manage Bills
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="staffDropdown">
                            <a class="dropdown-item" href="?section=view-bills">View Bills</a>
                            <a class="dropdown-item" href="?section=add-bills">Add Bills</a>
                        </div>
                    </div>
					
                    <!-- Static Links -->
                    <a class="nav-link text-white" href="?section=view-transaction"><i class="fas fa-exchange-alt"></i> View Transactions</a>
                    <a class="nav-link text-white" href="?section=sales-report"><i class="fas fa-chart-line"></i> Generate Sales Report</a>
                    <a class="nav-link text-white" href="?section=feedback"><i class="fas fa-comments"></i> View Feedback</a>
                </nav>
            </div>
            
            <div class="col-md-10 offset-md-2">
			<header>
				<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm fixed-top w-100">
					<a class="navbar-brand d-flex align-items-center" href="#">
						<img src="images/file.png" alt="Logo" class="mr-2 logo">
						Admin Dashboard
					</a>
					<style>
						.logo {
							width: 120px;
							height: 75px;
						}
					</style>
					<button class="navbar-toggler" type="button" data-toggle="collapse" 
							data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
							aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							<li class="dropdown">
								<span>
									<div class="user-avatar-admin" >
                                        <img src="uploaded_img/<?php echo $ASimage; ?>" alt="User Avatar" class="user-avatar">
                                    </div>

									<?php 
										$userid = $_SESSION['USER_ID'];
										if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
											echo "&nbsp Welcome, " . htmlspecialchars($userid);
										} else {
											echo " Profile ";
										}
									?>
								</span>
								<ul>
									<li><a href="?section=profile">Profile</a></li>
									<li><a href="logout.php">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>

			<style>
				/* Ensure the header fills the top of the page */
				header {
					width: 100%;
					position: fixed;
					top: 0;
					left: 0;
					height: 100px; /* Adjust as needed */
					z-index: 1050; /* Ensure it stays on top */
					background-color: #ffffff;
					box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				}

				/* Add margin to the main content to avoid overlap */
				main {
					margin-top: 80px; /* Adjust based on header height */
				}

				/* Navbar styles */
				.navbar {
					background-color: #ffffff;
					box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
				}

				.navbar-nav .dropdown ul {
					position: absolute;
					right: 0;
					background-color: #ffffff;
					list-style: none;
					padding: 10px 0;
					box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
					display: none;
					min-width: 180px;
					border-radius: 5px;
					z-index: 1000;
				}

				.navbar-nav .dropdown:hover ul {
					display: block;
				}
				
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
                <main class="mt-4">
                    <div class='content bg-white p-4 shadow-sm rounded'>
                        <?php
                        // Include the corresponding section file based on the selected section
                        $section_map = [
                            "staff" => "view_staff.php",
                            "add-staff" => "add_staff.php",
                            "edit-staff" => "edit_staff.php",
                            "delete-staff" => "delete_staff.php",
                            "patients" => "view_patient.php",
                            "add-patient" => "add_patient.php",
                            "edit-patient" => "edit_patient.php",
                            "delete-patient" => "delete_patient.php",
							"profile" => "profile_SA.php" ,
							"appointment" => "view_appointments.php" ,
							"feedback" => "view_feedback.php" ,
							"view-bills" => "bill.php" ,
                            "show-bills" => "view_bill.php",
							"add-bills" => "create_bill.php" ,
							"edit-bills" => "edit_bill.php" ,
							"delete-bills" => "delete_bill.php" , 
							"view-transaction" => "view_transaction.php",
							"sales-report" => "sales_report.php",
                        ];

                        if (array_key_exists($section, $section_map)) {
                            include $section_map[$section];
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>
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
    "add-patient", "edit-patient", "delete-patient" , "profile" , "appointment" , "feedback"
];

$section = isset($_GET["section"]) && in_array($_GET["section"], $allowed_sections) ? $_GET["section"] : "staff";

?>
<!Doctype html> <!-- Line 15 -->
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
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            padding-top: 60px;
            overflow-y: auto;
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
            padding: 20px;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
                            <a class="dropdown-item" href="?section=edit-staff">Edit Staff</a>
                            <a class="dropdown-item" href="?section=delete-staff">Delete Staff</a>
                        </div>
                    </div>
                    <!-- Patients Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white py-3" href="#" id="patientDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-procedures"></i> Manage Patients
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="patientDropdown">
                            <a class="dropdown-item" href="?section=patients">View Patients</a>
                            <a class="dropdown-item" href="?section=edit-patient">Edit Patient</a>
                            <a class="dropdown-item" href="?section=delete-patient">Delete Patient</a>
                        </div>
                    </div>
					
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white py-3" href="#" id="appointmentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-calendar-alt"></i> Manage Appointments
						</a>
						<div class="dropdown-menu dropdown-menu-dark" aria-labelledby="appointmentDropdown">
							<a class="dropdown-item" href="?section=appointment">View Appointments</a>
							<a class="dropdown-item" href="#add-appointment">Add Appointment</a>
						</div>
					</div>
					
                    <!-- Static Links -->
                    <a class="nav-link text-white" href="#view-bills"><i class="fas fa-file-invoice-dollar"></i> View Bills</a>
                    <a class="nav-link text-white" href="#view-transaction"><i class="fas fa-exchange-alt"></i> View Transactions</a>
                    <a class="nav-link text-white" href="#generate-sales-report"><i class="fas fa-chart-line"></i> Generate Sales Report</a>
                    <a class="nav-link text-white" href="?section=feedback"><i class="fas fa-comments"></i> View Feedback</a>
                </nav>
            </div>
            
            <div class="col-md-10 offset-md-2">
                <header>
                    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
                        <a class="navbar-brand" href="#">Admin Dashboard</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="?section=profile"><i class="fas fa-user"></i> View Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
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
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new database connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to add staff
function addStaff($connection, $data) {
    try {
        $stmt = $connection->prepare("INSERT INTO staff_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, STAFF_ID, PASSWORD, USERTYPE) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $data["firstname"], $data["lastname"], $data["no_tel"], $data["email"], $data["ic"], $data["staff_id"], $data["password"], $data["usertype"]);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to edit staff
function editStaff($connection, $data) {
    try {
        $stmt = $connection->prepare("UPDATE staff_info SET FIRSTNAME = ?, LASTNAME = ?, NO_TEL = ?, EMAIL = ?, IC = ? WHERE STAFF_ID = ?");
        $stmt->bind_param("ssssss", $data["firstname"], $data["lastname"], $data["no_tel"], $data["email"], $data["ic"], $data["staff_id"]);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to delete staff
function deleteStaff($connection, $staff_id) {
    try {
        $stmt = $connection->prepare("DELETE FROM staff_info WHERE STAFF_ID = ?");
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_staff"])) {
        $data = array(
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST["lastname"],
            "no_tel" => $_POST["no_tel"],
            "email" => $_POST["email"],
            "ic" => $_POST["ic"],
            "staff_id" => $_POST["staff_id"],
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "usertype" => $_POST["usertype"]
        );
        if (addStaff($connection, $data)) {
            echo "Staff added successfully!";
        } else {
            echo "Error adding staff!";
        }
    } elseif (isset($_POST["edit_staff"])) {
        $data = array(
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST ["lastname"],
            "no_tel" => $_POST["no_tel"],
            "email" => $_POST["email"],
            "ic" => $_POST["ic"],
            "staff_id" => $_POST["staff_id"]
        );
        if (editStaff($connection, $data)) {
            echo "Staff updated successfully!";
        } else {
            echo "Error updating staff!";
        }
    } elseif (isset($_POST["delete_staff"])) {
        $staff_id = $_POST["staff_id"];
        if (deleteStaff($connection, $staff_id)) {
            echo "Staff deleted successfully!";
        } else {
            echo "Error deleting staff!";
        }
    }
}

// HTML content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	
	<!-- Bootstrap JavaScript -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4. 0.0/js/bootstrap.min.js"></script>
	<script>
				// JavaScript code to make the dropdown menus work
		$(document).ready(function() {
			// Add event listener to the dropdown toggle buttons
			$('.dropdown-toggle').on('click', function() {
				// Toggle the dropdown menu
				$(this).next('.dropdown-menu').toggle();
			});

			// Add event listener to the dropdown menu items
			$('.dropdown-menu a').on('click', function() {
				// Hide the dropdown menu
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
                    
					<!-- Staff Dropdown (inside sidebar) -->
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white py-3" href="#" id="staffDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-users"></i> Manage Staff
						</a>
						<div class="dropdown-menu dropdown-menu-dark" aria-labelledby="staffDropdown">
							<a class="dropdown-item" href="#" id="view-staff-link" onclick="showStaffSection()">View Staff</a>
							<a class="dropdown-item" href="#" id="add-staff-link" onclick="showAddStaff()">Add Staff</a>
							<a class="dropdown-item" href="#" id="edit-staff-link" onclick="showEditStaff()">Edit Staff</a>
							<a class="dropdown-item" href="#" id="delete-staff-link" onclick="showDeleteStaff()">Delete Staff</a>
						</div>
					</div>
					
					<script>
					// JavaScript code to toggle the sections
					function showStaffSection() {
						document.getElementById("staff-section").style.display = "block";
						document.getElementById("add-staff").style.display = "none";
						document.getElementById("edit-staff").style.display = "none";
						document.getElementById("delete-staff").style.display = "none";
					}

					function showAddStaff() {
						document.getElementById("staff-section").style.display = "none";
						document.getElementById("add-staff").style.display = "block";
						document.getElementById("edit-staff").style.display = "none";
						document.getElementById("delete-staff").style.display = "none";
					}

					function showEditStaff() {
						document.getElementById("staff-section").style.display = "none";
						document.getElementById("add-staff").style.display = "none";
						document.getElementById("edit-staff").style.display = "block";
						document.getElementById("delete-staff").style.display = "none";
					}

					function showDeleteStaff() {
						document.getElementById("staff-section").style.display = "none";
						document.getElementById("add-staff").style.display = "none";
						document.getElementById("edit-staff").style.display = "none";
						document.getElementById("delete-staff").style.display = "block";
					}
				</script>
					
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white py-3" href="#" id="patientDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-procedures"></i> Manage Patients
						</a>
						<div class="dropdown-menu dropdown-menu-dark" aria-labelledby="patientDropdown">
							<a class="dropdown-item" href="view_patient.php" id="view-patient-link">View Patients</a>
							<a class="dropdown-item" href="#add-patient">Add Patient</a>
							<a class="dropdown-item" href="edit_patient.php" id="edit-patient-link">Edit Patient</a>
							<a class="dropdown-item" href="delete_patient.php" id="delete-patient-link">Delete Patient</a>
						</div>
					</div>

					
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white py-3" href="#" id="appointmentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-calendar-alt"></i> Manage Appointments
						</a>
						<div class="dropdown-menu dropdown-menu-dark" aria-labelledby="appointmentDropdown">
							<a class="dropdown-item" href="#view-appointment">View Appointments</a>
							<a class="dropdown-item" href="#add-appointment">Add Appointment</a>
						</div>
					</div>

                    <!-- Static Links -->
                    <a class="nav-link text-white" href="#view-bills"><i class="fas fa-file-invoice-dollar"></i> View Bills</a>
                    <a class="nav-link text-white" href="#view-transaction"><i class="fas fa-exchange-alt"></i> View Transactions</a>
                    <a class="nav-link text-white" href="#generate-sales-report"><i class="fas fa-chart-line"></i> Generate Sales Report</a>
                    <a class="nav-link text-white" href="#view-feedback"><i class="fas fa-comments"></i> View Feedback</a>
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
                                    <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> View Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <main class="mt-4">
                    <div class="content bg-white p-4 shadow-sm rounded" id="profile-section">
                        <!-- Default content before loading profile -->
                        <h3>Welcome to the Admin Dashboard</h3>
                        <p>Use the sidebar to navigate through the different sections of the admin panel.</p>
                    </div>
                    <div class="content bg-white p-4 shadow-sm rounded" id="staff-section" style="display: none;">
                        <h2>Staff Management</h2>
                        <a class="btn btn-primary" href="#add-staff" role="button">
                            <i class="fas fa-user-plus"></i> New Staff
                        </a>
                        <br>
                        <form class="mt-3 mb-3" method="GET">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="search" placeholder="Search by Staff ID">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                                <div class="col-auto">
                                    <a class="btn btn-success" href="#">Show All</a>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>IC</th>
                                    <th>Staff ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Initialize database connection
                                $sql = "SELECT * FROM staff_info";

                                // Check if search query is provided
                                if (isset($_GET['search'])) {
                                    $search = $_GET['search'];
                                    // Add WHERE clause to filter by staff_id
                                    $sql .= " WHERE STAFF_ID = '$search'";
                                }

                                // Execute the SQL query
                                $result = $connection->query($sql); 

                                if (!$result) {
                                    die ("Invalid query: " . $connection->error);
                                }

                                // Count total number of staff
                                $totalStaff = $result->num_rows;
                                echo "<p>Total Staff: $totalStaff</p>";

                                // Initialize a counter variable for numbering
                                $no = 1;

                                // Read data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>"; // Display number
                                    echo "<td>{$row['FIRSTNAME']}</td>";
                                    echo "<td>{$row['LASTNAME']}</td>";
                                    echo "<td>{$row['NO_TEL']}</td>";
                                    echo "<td>{$row['EMAIL']}</td>";
                                    echo "<td>{$row['IC']}</td>";
                                    echo "<td>{$row['STAFF_ID']}</td>";
                                    echo "<td>";
                                    // Edit button with icon
                                    echo "<a class='btn btn-primary btn-sm me-3' href='#edit-staff?staff_id={$row['STAFF_ID']}'>";
                                    echo "<i class='fas fa-edit'></i> Edit</a>";
                                    // Delete button with icon
                                    echo "<a class='btn btn-danger btn-sm' href='#delete-staff?staff_id={$row['STAFF_ID']}' onclick='return confirm(\"Are you sure you want to delete this record?\")'>";
                                    echo "<i class='fas fa-trash'></i> Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";

                                    // Increment the counter
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    

                    <div class="content bg-white p-4 shadow-sm rounded" id="add-staff" style="display: none;">
                        <h2>New Staff</h2>
                        <?php if (!empty($errorMessage)) : ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong><?php echo $errorMessage; ?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="no_tel" value="<?php echo $no_tel; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">IC</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ic" id="ic" oninput="autofillPassword()" value="<?php echo $ic; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
								<label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="staff_id" value="<?php echo $staff_id; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $password; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3 col-sm-3 d-grid">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-sm-3 d-grid">
                                    <a class="btn btn-outline-primary" href="#" role="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    // Initialize variables
                    $firstname = "";
                    $lastname = "";
                    $no_tel = "";
                    $email = "";
                    $ic = "";
                    $staff_id = "";
                    $pass = ""; // This will be set to the IC number
                    $usertype = "1"; // Assume '1' for staff

                    $errorMessage = "";
                    $successMessage = "";

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Capture form input
                        $firstname = $_POST["firstname"];
                        $lastname = $_POST["lastname"];
                        $no_tel = $_POST["no_tel"];
                        $email = $_POST["email"];
                        $ic = $_POST["ic"];
                        $staff_id = $_POST["staff_id"];

                        // Set the password to the IC number entered
                        $pass = $ic;

                        // === VALIDATIONS ===

                        // PHONE NUMBER VALIDATION
                        if (!preg_match('/^[0-9]+$/', $no_tel)) {
                            $errorMessage = "Please enter a valid phone number containing only digits.";
                        }

                        // EMAIL VALIDATION
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errorMessage = "Please enter a valid email, e.g., example@email.com";
                        }

                        // Check for existing email or username in the database
                        if (empty($errorMessage)) {
                            $check_sql = "SELECT * FROM staff_info WHERE EMAIL = ? OR STAFF_ID = ?";
                            $stmt = $connection->prepare($check_sql);
                            if ($stmt === false) {
                                die("MySQL prepare failed: " . $connection->error);
                            }

                            $stmt->bind_param("ss", $email, $staff_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $errorMessage = "Email or Username already exists.";
                                $stmt->close();
                            }
                        }

                        // Proceed only if there is no error
                        if (empty($errorMessage)) {
                            // Hash the password (which is the IC number)
                            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

                            // Insert data into staff_info table
                            $sql = "INSERT INTO staff_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, STAFF_ID, PASSWORD, USERTYPE) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                            $stmt = $connection->prepare($sql);
                            if ($stmt === false) {
                                die("MySQL prepare failed: " . $connection->error);
                            }

                            // Bind parameters
                            $stmt->bind_param("sssssssi", $firstname, $lastname, $no_tel, $email, $ic, $staff_id, $hashed_password, $usertype);

                            // Execute statement
                            if ($stmt->execute()) {
                                $_SESSION['success_message'] = "Staff added successfully!";
                                header("Location: admin_dashboard.php");
                                exit();
                            } else {
                                $errorMessage = "There was an issue creating the staff. Error: " . $stmt->error;
                            }

                            $stmt->close();
                        }

                        // Display the error message if any
                        if (!empty($errorMessage)) {
                            echo "<div class='alert alert-danger'>$errorMessage</div>";
                        }

                        $connection->close();
                    }
                    ?>
                    <!-- ... (rest of the code remains the same) -->

                    <div class="content bg-white p-4 shadow-sm rounded" id="edit-staff" style="display: none;">
                        <h2>Edit Staff Information</h2>

                        <?php if (!empty($errorMessage)) : ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong><?php echo $errorMessage; ?></strong>
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Staff ID</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="staff_id" value="<?php echo $staff_id; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="no_tel" value="<?php echo $no_tel; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">IC Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="ic" id="ic_number" value="<?php echo $ic; ?>" oninput="autofillPassword()">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $password; ?>">
                                </div>
                            </div>
                            <?php if (!empty($successMessage)) : ?>
                                <div class="row mb-3">
                                    <div class="offset-sm-3 col-sm-6">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong><?php echo $successMessage; ?></strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row mb-3">
                                <div class="col-sm-3 d-grid">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-sm-3 d-grid">
                                    <a class="btn btn-outline-primary" href="#" role="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    // Initialize variables
                    $staff_id = "";
                    $firstname = "";
                    $lastname = "";
                    $no_tel = "";
                    $email = "";
                    $ic = "";
                    $password = ""; // Added password field

                    $errorMessage = "";
                    $successMessage = "";

                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        // GET method: Show the data of the staff

                        if (!isset($_GET["staff_id"])) {
                            header("location: view_staff.php");
                            exit;
                        }

                        $staff_id = $_GET["staff_id"];

                        // Read the row of the selected staff from the database table
                        $sql = "SELECT * FROM staff_info WHERE STAFF_ID='$staff_id'";
                        $result = $connection->query($sql);
                        $row = $result->fetch_assoc();

                        if (!$row) {
                            header("location: view_staff.php");
                            exit;
                        }

                        $firstname = $row["FIRSTNAME"];
                        $lastname = $row["LASTNAME"];
                        $no_tel = $row["NO_TEL"];
                        $email = $row["EMAIL"];
                        $ic = $row["IC"];
                        $password = $row["PASSWORD"]; // Populate password field

                    } else {
                        $staff_id = $_POST ["staff_id"];
                        $firstname = $_POST["firstname"];
                        $lastname = $_POST["lastname"];
                        $no_tel = $_POST["no_tel"];
                        $email = $_POST["email"];
                        $ic = $_POST["ic"];
                        $password = $_POST["password"]; // Get the password field value from the form

                        // Validate form inputs
                        if (empty($staff_id) || empty($firstname) || empty($lastname) || empty($no_tel) || empty($email) || empty($ic)) {
                            $errorMessage = "All fields are required";
                        } else {
                            // Construct the SQL query to update the data in the database
                            if (!empty($password)) {
                                // If a new password is provided, hash the password and update all fields
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                $sql = "UPDATE staff_info SET FIRSTNAME='$firstname', LASTNAME='$lastname', NO_TEL='$no_tel', EMAIL='$email', IC='$ic', PASSWORD='$hashed_password' WHERE STAFF_ID='$staff_id'";
                            } else {
                                // If no new password is provided, update only other fields
                                $sql = "UPDATE staff_info SET FIRSTNAME='$firstname', LASTNAME='$lastname', NO_TEL='$no_tel', EMAIL='$email', IC='$ic' WHERE STAFF_ID='$staff_id'";
                            }

                            // Execute the SQL query
                            $result = $connection->query($sql);

                            if (!$result) {
                                $errorMessage = "Error: " . $sql . "<br>" . $connection->error;
                            } else {
                                $successMessage = "Staff information updated successfully!";
                                // Redirect to staff listing page
                                header("Location: admin_dashboard.php");
                                exit;
                            }
                        }
                    }
                    ?>

                    <script>
                        // Function to autofill password with IC number
                        function autofillPassword() {
                            var icNumber = document.getElementById("ic_number").value;
                            document.getElementById("password").value = icNumber;
                        }
                    </script>

                    <div class="content bg-white p-4 shadow-sm rounded" id="delete-staff" style="display: none;">
                        <h2>Delete Staff</h2>

                        <?php if (isset($_GET["staff_id"])) : ?>
                            <?php
                            $deleteStaffID = $_GET["staff_id"]; // Use a different variable name

                            // Open connection
                            $connection = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Prepare and execute the delete query
                            $sqlDelete = "DELETE FROM staff_info WHERE STAFF_ID = ?";
                            $stmtDelete = $connection->prepare($sqlDelete);
                            $stmtDelete->bind_param("s", $deleteStaffID); // Bind the staff_id
                            $stmtDelete->execute();

                            // Check if any rows were affected (i.e., if deletion was successful)
                            if ($stmtDelete->affected_rows > 0) {
                                echo "Record with Staff ID $deleteStaffID deleted successfully.";
                            } else {
                                echo "No records deleted. Perhaps the record with Staff ID $deleteStaffID does not exist.";
                            }

                            // Close statement and connection
                            $stmtDelete->close();
                            $connection->close();
                            ?>
                        <?php else : ?>
                            <p>No staff ID specified for deletion.</p>
                        <?php endif; ?>
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
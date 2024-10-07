<?php
// Start output buffering to prevent the headers already sent issue
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        $stmt = $conn->prepare($check_sql);
        if ($stmt === false) {
            die("MySQL prepare failed: " . $conn->error);
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
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("MySQL prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("sssssssi", $firstname, $lastname, $no_tel, $email, $ic, $staff_id, $hashed_password, $usertype);

        // Execute statement
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Staff added successfully!";
            // Redirect before any output
            header("Location: admin_dashboard.php?section=staff");
            exit();
        } else {
            $errorMessage = "There was an issue creating the staff. Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        // JavaScript to auto-fill password field with IC number
        function autofillPassword() {
            var icInput = document.getElementById("ic");
            var passwordInput = document.getElementById("password");
            passwordInput.value = icInput.value;  // Set password to the value of IC
        }
    </script>
</head>
<body>
    <div class="container my-5">
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
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $pass; ?>" readonly>
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
                <div class="col-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="admin_dashboard.php?section=staff" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// End the output buffer and send headers
ob_end_flush();
?>

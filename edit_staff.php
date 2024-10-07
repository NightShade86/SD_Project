<?php
ob_start();

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";  // Use the correct database name

// Open connection
$connection = new mysqli($servername, $username, $password, $dbname);

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
        header("location: admin_dashboard.php?section=staff");
        exit;
    }

    $staff_id = $_GET["staff_id"];

    // Read the row of the selected staff from the database table
    $sql = "SELECT * FROM staff_info WHERE STAFF_ID='$staff_id'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: admin_dashboard.php?section=staff");
        exit;
    }

    $firstname = $row["FIRSTNAME"];
    $lastname = $row["LASTNAME"];
    $no_tel = $row["NO_TEL"];
    $email = $row["EMAIL"];
    $ic = $row["IC"];
    $password = $row["PASSWORD"]; // Populate password field

} else {
    $staff_id = $_POST["staff_id"];
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
            header("Location: admin_dashboard.php?section=staff");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
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
                    <a class="btn btn-outline-primary" href="/clinic_management_system/view_staff.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Function to autofill password with IC number
        function autofillPassword() {
            var icNumber = document.getElementById("ic_number").value;
            document.getElementById("password").value = icNumber;
        }
    </script>
</body>
</html>
<?php
// End the output buffer and send headers
ob_end_flush();
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb"; // Change to your actual database name

// Open connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Initialize variables
$firstname = "";
$lastname = "";
$no_tel = "";
$email = "";
$ic = "";
$staff_id = "";
$password = "";
$usertype = "staff"; // Set default usertype as staff

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
    $password = $_POST["password"];
    $usertype = $_POST["usertype"]; // Default to "staff"

    // Validate form inputs
    if (empty($firstname) || empty($lastname) || empty($no_tel) || empty($email) || empty($ic) || empty($staff_id) || empty($password)) {
        $errorMessage = "All fields are required";
    } else {
        // Insert data into staff_info table
        $sql = "INSERT INTO staff_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, STAFF_ID, PASSWORD, USERTYPE) " .
        "VALUES ('$firstname', '$lastname', '$no_tel', '$email', '$ic', '$staff_id', '$password', '$usertype')";
        
        $result = $connection->query($sql);

        if ($result) {
            $successMessage = "Staff added successfully!";
            // Redirect to another page or refresh form
            header("Location: /clinic_management_system/index_staff.php");
            exit;
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
                <label class="col-sm-3 col-form-label">Contact Number</label>
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
                    <input type="text" class="form-control" name="ic" value="<?php echo $ic; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Staff ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="staff_id" value="<?php echo $staff_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
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
                    <a class="btn btn-outline-primary" href="/clinic_management_system/index_staff.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

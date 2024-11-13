<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username_db = "root";
$password = "";
$dbname = "dtcmsdb";

// Establish connection
$connection = new mysqli($servername, $username_db, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve form data and check if variables are set
$firstname = $_POST['firstname'] ?? null;
$lastname = $_POST['lastname'] ?? null;
$username = $_POST['username'] ?? null;
$ic = $_POST['ic'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['pnumber'] ?? null;
$oguserid = $_POST['ogusername'];

// Handle image upload
$profile_image = $_FILES['update_image']['name'] ?? null;
$image_tmp_name = $_FILES['update_image']['tmp_name'] ?? null;
$image_size = $_FILES['update_image']['size'] ?? null;
$image_folder = 'uploaded_img/' . $profile_image;

// Identify user role (admin, staff, patient) based on session
$role = $_SESSION['role'] ?? 'patient'; // default to 'patient'
$table = '';
$id_column = '';
$redirect_url = '';

// Determine table, ID column, and redirect URL based on the role
switch ($role) {
    case 'admin':
        $table = 'admin_info';
        $id_column = 'USER_ID';
        $redirect_url = "admin_dashboard.php?section=profile&verified=true#account-general";
        break;
    case 'staff':
        $table = 'staff_info';
        $id_column = 'STAFF_ID';
        $redirect_url = "staff_dashboard.php?section=profile&verified=true#account-general";
        break;
    default:
        $table = 'user_info'; // patient
        $id_column = 'USER_ID';
        $redirect_url = "profile.php";
        break;
}

// Ensure the username is provided before proceeding
if ($oguserid) {
    // Check if the user exists
    $sql_check = "SELECT * FROM $table WHERE $id_column = ?";
    $stmt_check = $connection->prepare($sql_check);
    $stmt_check->bind_param("s", $oguserid);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // User exists, update the record
        $sql_update = "UPDATE $table 
                       SET FIRSTNAME = ?, LASTNAME = ?, NO_TEL = ?, EMAIL = ?, IC = ?, $id_column = ?
                       WHERE $id_column = ?";

        $stmt_update = $connection->prepare($sql_update);
        $stmt_update->bind_param("sssssss", $firstname, $lastname, $phone, $email, $ic, $username, $oguserid);

        // Handle image upload if present
        if (!empty($profile_image)) {
            // Check image size
            if ($image_size > 2000000) {
                $_SESSION['error_message'] = 'Image is too large!';
                header("Location: profile.php");
                exit();
            } else {
                // Move the uploaded image and update the database
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    $sql_image_update = "UPDATE $table SET IMAGE = ? WHERE $id_column = ?";
                    $stmt_image_update = $connection->prepare($sql_image_update);
                    $stmt_image_update->bind_param("ss", $profile_image, $oguserid);
                    $stmt_image_update->execute();
                    $stmt_image_update->close();
                } else {
                    $_SESSION['error_message'] = "Failed to upload image.";
                    header("Location: profile.php");
                    exit();
                }
            }
        }

        // Execute the profile update query
        if ($stmt_update->execute()) {
            $_SESSION['success_message'] = "Profile updated successfully!";
        } else {
            $_SESSION['error_message'] = "Error updating record: " . $connection->error;
        }

        // Close the update statement
        $stmt_update->close();

        // Redirect based on role
        header("Location: $redirect_url");
        exit();
    } else {
        $_SESSION['error_message'] = "User not found.";
    }

    // Close the check statement
    $stmt_check->close();
} else {
    $_SESSION['error_message'] = "Username is missing.";
}

// Close the database connection
$connection->close();
header("Location: $redirect_url");
exit();
?>

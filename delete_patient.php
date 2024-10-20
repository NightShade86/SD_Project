<?php
session_start();

if (isset($_GET["patient_id"])) {
    $deletePatientID = $_GET["patient_id"]; 

    // Database credentials
    $servername = "localhost";
    $username = "root"; 
    $password = "";
    $dbname = "dtcmsdb"; 

    // Open connection
    $connection = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare and execute the delete query
    $sqlDelete = "DELETE FROM user_info WHERE USER_ID = ? AND USERTYPE = 2"; 
    $stmtDelete = $connection->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $deletePatientID); 
    $stmtDelete->execute();

    // Check if any rows were affected
    if ($stmtDelete->affected_rows > 0) {
        $alertMessage = "Record with Patient ID $deletePatientID deleted successfully.";
    } else {
        $alertMessage = "No records deleted. Perhaps the record with Patient ID $deletePatientID does not exist.";
    }

    // Determine redirection URL based on user role
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'admin') {
            $redirectUrl = 'admin_dashboard.php?section=patients';
        } elseif ($_SESSION['role'] === 'staff') {
            $redirectUrl = 'staff_dashboard.php?section=patients';
        } else {
            $redirectUrl = 'login_guess.php'; // Fallback for unknown role
        }
    } else {
        $redirectUrl = 'login_guess.php'; // Fallback if no role is set
    }

    // Show alert and redirect
    echo "<script>
        alert('$alertMessage');
        window.location.href = '$redirectUrl';
    </script>";

    // Close statement and connection
    $stmtDelete->close();
    $connection->close();
} else {
    // No patient ID provided
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'admin') {
            $redirectUrl = 'admin_dashboard.php?section=patients';
        } elseif ($_SESSION['role'] === 'staff') {
            $redirectUrl = 'staff_dashboard.php?section=patients';
        } else {
            $redirectUrl = 'login_guess.php';
        }
    } else {
        $redirectUrl = 'login_guess.php';
    }

    echo "<script>
        alert('No patient ID specified for deletion.');
        window.location.href = '$redirectUrl';
    </script>";
}
?>

<?php
// Start session and enable error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only proceed if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Database connection setup
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtcmsdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ensure required POST keys are set
    if (!isset($_POST['billExternalReferenceNo']) || !isset($_POST['billStatus'])) {
        echo "Required data is missing.";
        exit();
    }

    // Retrieve data from POST request
    $billReferenceNo = $conn->real_escape_string($_POST['billExternalReferenceNo']);
    $billStatus = $conn->real_escape_string($_POST['billStatus']);

    // Check if billReferenceNo exists in clinic_bills
    $query = "SELECT * FROM clinic_bills WHERE transaction_id = '$billReferenceNo'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Bill found, update the payment status based on billStatus
        $newStatus = ($billStatus === '1') ? 'Paid' : (($billStatus === '2') ? 'Pending' : 'Cancelled');

        $updateQuery = "UPDATE clinic_bills SET payment_status = '$newStatus' WHERE transaction_id = '$billReferenceNo'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "Payment status updated successfully.";
        } else {
            echo "Error updating payment status: " . $conn->error;
        }
    } else {
        // Bill not found
        echo "Transaction not found.";
    }

    // Close database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

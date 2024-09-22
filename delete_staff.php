<?php
if (isset($_GET["staff_id"])) {
    $deleteStaffID = $_GET["staff_id"]; // Use a different variable name

    $servername = "localhost";
    $dbUsername = "root"; // Use a different variable name
    $password = "";
    $dbname = "dtcmsdb"; // Make sure the correct database is used

    // Open connection
    $connection = new mysqli($servername, $dbUsername, $password, $dbname);

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
} else {
    echo "No staff ID specified for deletion.";
}
?>

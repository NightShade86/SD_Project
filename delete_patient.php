<?php
if (isset($_GET["patient_id"])) {
    $deletePatientID = $_GET["patient_id"]; // Use a different variable name for patient ID

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
    $sqlDelete = "DELETE FROM user_info WHERE USER_ID = ? AND USERTYPE = 2"; // Only delete if USERTYPE is '2' (for patients)
    $stmtDelete = $connection->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $deletePatientID); // Bind the patient_id
    $stmtDelete->execute();

    // Check if any rows were affected (i.e., if deletion was successful)
    if ($stmtDelete->affected_rows > 0) {
        echo "Record with Patient ID $deletePatientID deleted successfully.";
    } else {
        echo "No records deleted. Perhaps the record with Patient ID $deletePatientID does not exist.";
    }

    // Close statement and connection
    $stmtDelete->close();
    $connection->close();
} else {
    echo "No patient ID specified for deletion.";
}
?>

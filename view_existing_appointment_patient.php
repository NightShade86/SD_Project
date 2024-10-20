<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Retrieve user information from the session
$userid = $_SESSION['USER_ID'];
$role = $_SESSION['role'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new database connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Prepare a statement to fetch appointments for the current user
$stmt = $connection->prepare("SELECT * FROM appointment_info WHERE userid = ?");
if (!$stmt->bind_param("s", $userid)) {
    die("Binding parameters failed: " . $stmt->error);
}

// Execute the statement
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
} 

// Get the result set from the executed statement
$result = $stmt->get_result();

// Check if any appointments exist for the user
if ($result->num_rows > 0) {
    // Start outputting the appointment table
    echo "
        <!-- Title and Description Section -->
        <div class='contact-form-two'>
            <div class='title-box'>
                <h4>Your Appointments</h4>
                <div class='text'>Here is the history of all your scheduled appointments.</div>
            </div>

            <!-- Appointment Table -->
            <div class='table-responsive'>
                <table class='table table-striped table-bordered'>
                    <tr>
                        <th>Appointment ID</th>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>IC</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Reason for Visit</th>
                        <th>Queue Number</th>
                    </tr>";
                    
    // Loop through the result set and output each row in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['appointment_id']}</td>
                <td>{$row['userid']}</td>
                <td>{$row['fname']}</td>
                <td>{$row['lname']}</td>
                <td>{$row['number']}</td>
                <td>{$row['email']}</td>
                <td>{$row['ic']}</td>
                <td>{$row['appointment_date']}</td>
                <td>{$row['appointment_time']}</td>
                <td>{$row['reason_for_visit']}</td>
                <td>{$row['queue_number']}</td>
              </tr>";
    }

    // Close the table
    echo "
                </table>
            </div>
        </div>
    ";
} else {
    // If no appointments are found, show a message
    echo "<h2>No appointments found.</h2>";
}

// Close the statement and the connection
$stmt->close();
$connection->close();
?>

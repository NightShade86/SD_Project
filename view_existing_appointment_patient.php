<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Retrieve user information from session
$userid = $_SESSION['USER_ID'];
$role = $_SESSION['role'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all appointments made by the user
$stmt = $connection->prepare("SELECT * FROM appointment_info WHERE userid = ?");
if (!$stmt->bind_param("s", $userid)) {
    die("Binding parameters failed: " . $stmt->error);
}
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
} 
$result = $stmt->get_result();

// Check if any appointments exist
if ($result->num_rows > 0) {
    echo "
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

    // Fetch and display each appointment
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

    echo "</table>";
} else {
    echo "<tr><td colspan='11'>No appointments found.</td></tr>";
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>
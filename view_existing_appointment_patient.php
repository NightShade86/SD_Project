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
    <div class='model' id='appointmentModal'>
        <div class='contact-form-two'>
            <div class='title-box'>
                <h4>Your Appointments</h4>
                <div class='text'>Here is the history of all your scheduled appointments.</div>
            </div>
            <div class='table-responsive'>
                <div class='appointment-list'>";

    // Fetch and display each appointment using divs
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='appointment-item'>
            <div><strong>Appointment ID:</strong> {$row['appointment_id']}</div>
            <div><strong>User ID:</strong> {$row['userid']}</div>
            <div><strong>First Name:</strong> {$row['fname']}</div>
            <div><strong>Last Name:</strong> {$row['lname']}</div>
            <div><strong>Phone Number:</strong> {$row['number']}</div>
            <div><strong>Email:</strong> {$row['email']}</div>
            <div><strong>IC:</strong> {$row['ic']}</div>
            <div><strong>Appointment Date:</strong> {$row['appointment_date']}</div>
            <div><strong>Appointment Time:</strong> {$row['appointment_time']}</div>
            <div><strong>Reason for Visit:</strong> {$row['reason_for_visit']}</div>
            <div><strong>Queue Number:</strong> {$row['queue_number']}</div>
            <hr>
        </div>";
    }

    echo "
                </div>
            </div>
            <div class='model-footer'>
                <div class='btn btn-secondary' onclick='document.getElementById(\"appointmentModal\").style.display=\"none\"'>Close</div>
            </div>
        </div>
    </div>

    <script>
        // Automatically show the modal when the page loads
        document.getElementById('appointmentModal').style.display='block';
    </script>
    ";
} else {
    echo "<div class='model'>No appointments found.</div>";
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>

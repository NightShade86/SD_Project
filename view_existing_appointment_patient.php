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
    <html>
    <head>
        <title>Appointments</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    </head>
    <body>
        <!-- Modal (automatically displayed on page load) -->
        <div class='modal fade' id='appointmentModal' tabindex='-1' role='dialog' aria-labelledby='appointmentModalLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='appointmentModalLabel'>Your Appointments</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
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

    echo "
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Automatically show the modal when the page loads -->
        <script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
        <script>
            $(document).ready(function() {
                $('#appointmentModal').modal('show');
            });
        </script>
    </body>
    </html>
    ";
} else {
    echo "<h2>No appointments found.</h2>";
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>

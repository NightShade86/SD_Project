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

// Check user role
if ($_SESSION['loggedin']) {
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
}

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

// Fetch all appointments
$sql = "SELECT * FROM appointment_info";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Count total number of appointments
$totalAppointments = $result->num_rows;
echo "<p>Total Appointments: $totalAppointments</p>";
Echo "$role";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>List of Appointments</h2>

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>IC</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Reason for Visit</th>
            <th>Queue Number</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Initialize a counter variable for numbering
        $no = 1;

        // Read data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$row['userid']}</td>";
            echo "<td>{$row['fname']}</td>";
            echo "<td>{$row['lname']}</td>";
            echo "<td>{$row['number']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['ic']}</td>";
            echo "<td>{$row['appointment_date']}</td>";
            echo "<td>{$row['appointment_time']}</td>";
            echo "<td>{$row['reason_for_visit']}</td>";
            echo "<td>{$row['queue_number']}</td>";
            echo "<td>";
            // Cancel button with icon
            echo "<a class='btn btn-danger btn-sm' href='/clinicdb/SD_Project/cancel_appointment.php?appointment_id={$row['appointment_id']}' onclick='return confirm(\"Are you sure you want to cancel this appointment?\")'>";
            echo "<i class='fas fa-times'></i> Cancel</a>";
            echo "</td>";
            echo "</tr>";

            // Increment the counter
            $no++;
        }
        ?>
        </tbody>
    </table>

</div>
</body>
</html>

<?php
// Close the connection
$connection->close();
?>

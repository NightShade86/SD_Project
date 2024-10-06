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

// Function to get available times based on the selected date
function getAvailableTimes($date, $connection) {
    $availableTimes = [];
    $dayOfWeek = date('N', strtotime($date));

    // Define working hours based on the day of the week
    if ($dayOfWeek >= 1 && $dayOfWeek <= 4) { // Monday to Thursday
        $startTime = "09:00";
        $endTime = "21:00";
    } elseif ($dayOfWeek == 5) { // Friday
        $startTime = "09:00";
        $endTime = "17:00";
    } else {
        return $availableTimes; // Closed on weekends
    }

    // Generate time slots every 30 minutes
    $currentTime = new DateTime($startTime);
    $endTime = new DateTime($endTime);

    while ($currentTime <= $endTime) {
        $timeSlot = $currentTime->format('H:i');

        // Check if this time slot is already booked
        $stmt = $connection->prepare("SELECT * FROM appointment_info WHERE appointment_date = ? AND appointment_time = ?");
        $stmt->bind_param("ss", $date, $timeSlot);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $availableTimes[] = $timeSlot; // Add to available times if not booked
        }

        $currentTime->modify('+30 minutes');
    }

    return $availableTimes;
}

// Check available times if the form has been submitted
$availableTimes = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_date'])) {
    $selectedDate = $_POST['appointment_date'];
    $availableTimes = getAvailableTimes($selectedDate, $connection);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <script>
        function updateTimes() {
            const date = document.getElementById('appointment_date').value;
            const timeSelect = document.getElementById('appointment_time');

            // Clear existing options
            timeSelect.innerHTML = '';
            timeSelect.disabled = true; // Disable the time select initially

            if (date) {
                fetch('get_available_times.php?date=' + date)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time;
                            option.textContent = time;
                            timeSelect.appendChild(option);
                        });
                        timeSelect.disabled = false; // Enable time select if times are available
                    })
                    .catch(error => console.error('Error fetching available times:', error));
            }
        }
    </script>
</head>
<body>
<h2>Appointment Booking Form</h2>
<form action="submit_appointment.php" method="POST">
    <label for="appointment_date">Appointment Date:</label>
    <input type="date" id="appointment_date" name="appointment_date" required onchange="updateTimes()"><br><br>

    <label for="appointment_time">Appointment Time:</label>
    <select id="appointment_time" name="appointment_time" required disabled>
        <option value="">Select a time</option>
    </select><br><br>

    <label for="reason_for_visit">Reason for Visit:</label><br>
    <textarea id="reason_for_visit" name="reason_for_visit" rows="4" cols="50" required></textarea><br><br>

    <input type="submit" value="Book Appointment">
</form>
</body>
</html>

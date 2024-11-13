<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $dayOfWeek = date('N', strtotime($date));

    // Define working hours based on the day of the week
    if ($dayOfWeek >= 1 && $dayOfWeek <= 4) { // Monday to Thursday
        $startTime = "09:00";
        $endTime = "21:00";
    } elseif ($dayOfWeek == 5) { // Friday
        $startTime = "09:00";
        $endTime = "17:00";
    } else {
        echo json_encode([]); // Closed on weekends
        exit();
    }

    // Get available times
    $availableTimes = [];
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

    echo json_encode($availableTimes); // Return available times as JSON
}
?>

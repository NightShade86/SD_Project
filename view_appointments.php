<?php
ob_start();

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

// Pagination setup
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch appointments with pagination
$sql = "SELECT * FROM appointment_info LIMIT $offset, $records_per_page";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Count total number of appointments
$totalAppointmentsResult = $connection->query("SELECT COUNT(*) AS total FROM appointment_info");
$totalAppointmentsRow = $totalAppointmentsResult->fetch_assoc();
$totalAppointments = $totalAppointmentsRow['total'];
$totalPages = ceil($totalAppointments / $records_per_page);

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
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by Name or IC" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <p>Total Appointments: <?php echo $totalAppointments; ?></p>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
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
        $no = $offset + 1;

        // Fetch and display data
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
            echo "<button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-appointment-id='{$row['appointment_id']}'>";
            echo "<i class='fas fa-times'></i> Cancel</button>";
            echo "</td>";
            echo "</tr>";

            // Increment the counter
            $no++;
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page == $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        </ul>
    </nav>

</div>

<!-- Modal for Cancellation Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this appointment?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="" id="deleteLink" class="btn btn-danger">Cancel Appointment</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Set the cancel appointment URL dynamically
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var appointmentId = button.data('appointment-id'); 
        var modal = $(this);
        modal.find('#deleteLink').attr('href', '/clinicdb/SD_Project/cancel_appointment.php?appointment_id=' + appointmentId);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the connection
$connection->close();

// End the output buffer and send headers
ob_end_flush();
?>

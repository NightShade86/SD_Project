<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Medical Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#appointments">
                                Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#patient-info">
                                Patients
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    <h1 class="h2">Dashboard</h1>

                    <!-- Appointments Section -->
                    <div id="appointments" class="mb-5">
                        <h3>Today's Appointments</h3>
                        <ul class="list-group">
                            <?php
                            // MySQL connection details
                            $servername = "localhost";
                            $username = "root";
                            $password = "root";
                            $database = "medical_dashboard";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($conn->connect_error) {
                                die("<p>Connection failed: " . $conn->connect_error . "</p>");
                            }

                            // Fetch today's appointments
                            $sql = "SELECT patients.name AS patientName, appointments.time, appointments.type 
                                    FROM appointments 
                                    JOIN patients ON appointments.patientNumber = patients.patientNumber
                                    WHERE appointments.date = CURDATE()";

                            $result = $conn->query($sql);

                            // Check for SQL errors
                            if (!$result) {
                                die("<p>Query failed: " . $conn->error . "</p>");
                            }

                            // Output appointment data
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li class='list-group-item'>" . $row["patientName"] . " - " . $row["time"] . " - " . $row["type"] . "</li>";
                                }
                            } else {
                                echo "<li class='list-group-item'>No appointments for today</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Patient Information Section -->
                    <div id="patient-info" class="mb-5">
                        <h3>Patient Information</h3>
                        <div class="card">
                            <div class="card-body">
                                <?php
                                // Fetch specific patient data (dynamic value as needed)
                                $patientNumber = 1; // Example patient number, should be dynamic in real application
                                
                                // Query to get patient information
                                $sql = "SELECT name, patientNumber, age, address, phone, email 
                                        FROM patients 
                                        WHERE patientNumber = $patientNumber";

                                $result = $conn->query($sql);

                                // Check for SQL errors
                                if (!$result) {
                                    die("<p>Query failed: " . $conn->error . "</p>");
                                }

                                // Output patient data
                                if ($result->num_rows > 0) {
                                    $patient = $result->fetch_assoc();
                                    echo "<h5 class='card-title'>" . $patient['name'] . "</h5>";
                                    echo "<p><strong>Patient Number:</strong> " . $patient['patientNumber'] . "</p>";
                                    echo "<p><strong>Age:</strong> " . $patient['age'] . "</p>";
                                    echo "<p><strong>Address:</strong> " . $patient['address'] . "</p>";
                                    echo "<p><strong>Phone Number:</strong> " . $patient['phone'] . "</p>";
                                    echo "<p><strong>Email Address:</strong> " . $patient['email'] . "</p>";
                                } else {
                                    echo "<p>No patient data available</p>";
                                }

                                // Close the connection after both queries
                                $conn->close();
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
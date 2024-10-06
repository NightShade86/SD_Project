<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome CSS -->
</head>
<body>
    <div class="container my-5">
        <!-- Logout button with icon -->
        <div class="d-flex justify-content-end">
            <a class="btn btn-danger" href="/clinic_management_system/logout.php" role="button">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        
        <h2>List of Staff</h2>
        
        <!-- New Staff button with icon -->
        <a class="btn btn-primary" href="/clinicdb/SD_Project/add_staff.php" role="button">
            <i class="fas fa-user-plus"></i> New Staff
        </a>
        <br>
        
        <!-- Search form -->
        <form class="mt-3 mb-3" method="GET">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="search" placeholder="Search by Staff ID">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="col-auto">
                    <a class="btn btn-success" href="/clinicdb/SD_Project/view_staff.php">Show All</a>
                </div>
            </div>
        </form>

        <!-- PHP code to retrieve and display staff data -->
        <?php
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

        // Initialize the SQL query
        $sql = "SELECT * FROM staff_info";

        // Prepare the SQL query
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql .= " WHERE STAFF_ID = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $search); // 's' stands for string
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $connection->query($sql);
        }

        // Count total number of staff
        $totalStaff = $result->num_rows;
        echo "<p>Total Staff: $totalStaff</p>";
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>IC</th>
                    <th>Staff ID</th>
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
                    echo "<td>{$no}</td>"; // Display number
                    echo "<td>{$row['FIRSTNAME']}</td>";
                    echo "<td>{$row['LASTNAME']}</td>";
                    echo "<td>{$row['NO_TEL']}</td>";
                    echo "<td>{$row['EMAIL']}</td>";
                    echo "<td>{$row['IC']}</td>";
                    echo "<td>{$row['STAFF_ID']}</td>";
                    echo "<td>";
                    // Edit button with icon
                    echo "<a class='btn btn-primary btn-sm me-3' href='/clinicdb/SD_Project/edit_staff.php?staff_id={$row['STAFF_ID']}'>";
                    echo "<i class='fas fa-edit'></i> Edit</a>";
                    // Delete button with icon
                    echo "<a class='btn btn-danger btn-sm' href='/clinicdb/SD_Project/delete_staff.php?staff_id={$row['STAFF_ID']}' onclick='return confirm(\"Are you sure you want to delete this record?\")'>";
                    echo "<i class='fas fa-trash'></i> Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                    
                    // Increment the counter
                    $no++;
                }

                // Close connection
                $connection->close();
                ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>

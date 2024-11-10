<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome CSS -->
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-sm {
            font-size: 0.875rem;
        }
        .btn-group .btn {
            margin-right: 5px;
        }
        .container {
            max-width: 1200px;
        }
        .btn {
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2 class="mb-4">List of Staff</h2>
        
        <!-- New Staff button with icon -->
        <div class="d-flex justify-content-between mb-3">
            <a class="btn btn-primary" href="/clinicdb/SD_Project/admin_dashboard.php?section=add-staff" role="button">
                <i class="fas fa-user-plus"></i> New Staff
            </a>
            <form class="d-flex" method="GET">
                <input type="text" class="form-control me-2" name="search" placeholder="Search by Staff ID or Name">
                <button type="submit" class="btn btn-primary">Search</button>
                <a class="btn btn-success ms-2" href="/clinicdb/SD_Project/admin_dashboard.php?section=staff">Show All</a>
            </form>
        </div>
        
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dtcmsdb";
        $records_per_page = 10;
        
        // Open connection
        $connection = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // Pagination setup
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $records_per_page;

        // Initialize the SQL query
        $sql = "SELECT * FROM staff_info";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql .= " WHERE STAFF_ID LIKE ? OR FIRSTNAME LIKE ? OR LASTNAME LIKE ?";
            $stmt = $connection->prepare($sql);
            $search_param = "%" . $search . "%";
            $stmt->bind_param("sss", $search_param, $search_param, $search_param);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sql .= " LIMIT $offset, $records_per_page";
            $result = $connection->query($sql);
        }

        // Count total number of staff for pagination
        $totalStaffResult = $connection->query("SELECT COUNT(*) AS total FROM staff_info");
        $totalStaffRow = $totalStaffResult->fetch_assoc();
        $totalStaff = $totalStaffRow['total'];
        $totalPages = ceil($totalStaff / $records_per_page);

        echo "<p>Total Staff: $totalStaff</p>";
        ?>

        <table class="table table-striped table-bordered">
            <thead class="table-light">
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
                $no = $offset + 1;

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
                    echo "<a class='btn btn-primary btn-sm me-2' href='/clinicdb/SD_Project/edit_staff.php?staff_id={$row['STAFF_ID']}'>";
                    echo "<i class='fas fa-edit'></i> Edit</a>";
                    // Delete button triggers modal
                    echo "<button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-staff-id='{$row['STAFF_ID']}'>";
                    echo "<i class='fas fa-trash'></i> Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                    
                    $no++;
                }

                // Close connection
                $connection->close();
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

    <!-- Modal for Deletion Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this staff member?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="" id="deleteLink" class="btn btn-danger">Delete Staff</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set delete link dynamically in modal
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var staffId = button.getAttribute('data-staff-id');
            var deleteLink = document.getElementById('deleteLink');
            deleteLink.setAttribute('href', '/clinicdb/SD_Project/delete_staff.php?staff_id=' + staffId);
        });
    </script>
</body>
</html>

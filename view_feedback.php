<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome CSS -->
</head>
<body>
<div class="container my-5">

    <h2>List of User Feedback</h2>

    <!-- Search form -->
    <form class="mt-3 mb-3" method="GET">
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Search by User ID">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
            <div class="col-auto">
                <a class="btn btn-success" href="/clinicdb/SD_Project/view_feedback.php">Show All</a>
            </div>
        </div>
    </form>

    <!-- PHP code to retrieve and display feedback data -->
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
    $sql = "SELECT * FROM user_feedback";

    // Check if search query is provided
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        // Add WHERE clause to filter by USERID
        $sql .= " WHERE USERID = '$search'";
    }

    // Execute the SQL query
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

    // Count total number of feedback entries
    $totalFeedback = $result->num_rows;
    echo "<p>Total Feedback Entries: $totalFeedback</p>";
    ?>

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>User ID</th>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Overall Rating</th>
            <th>Design Rating</th>
            <th>Usability Rating</th>
            <th>Performance Rating</th>
            <th>Content Rating</th>
            <th>Recommendation Rate</th>
            <th>Positive Feedback</th>
            <th>Improvements</th>
            <th>Missing Info</th>
            <th>Navigation Difficulty</th>
            <th>Visit Reason</th>
            <th>Web Discovery</th>
            <th>Functionality Issue</th>
            <th>Loading Speed</th>
            <th>Additional Comments</th>
            <th>Follow Up</th>
            <th>Submission Date</th>
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
            echo "<td>{$row['ID']}</td>";
            echo "<td>{$row['USERID']}</td>";
            echo "<td>{$row['ROLE']}</td>";
            echo "<td>{$row['FNAME']}</td>";
            echo "<td>{$row['LNAME']}</td>";
            echo "<td>{$row['EMAIL']}</td>";
            echo "<td>{$row['OVERALL_RATING']}</td>";
            echo "<td>{$row['DESIGN_RATING']}</td>";
            echo "<td>{$row['USABILITY_RATING']}</td>";
            echo "<td>{$row['PERFORMANCE_RATING']}</td>";
            echo "<td>{$row['CONTENT_RATING']}</td>";
            echo "<td>{$row['RECOMMENDATION_RATE']}</td>";
            echo "<td>{$row['POSITIVE_FEEDBACK']}</td>";
            echo "<td>{$row['IMPROVEMENTS']}</td>";
            echo "<td>{$row['MISSING_INFO']}</td>";
            echo "<td>{$row['NAV_DIFFICULTY']}</td>";
            echo "<td>{$row['VISIT_REASON']}</td>";
            echo "<td>{$row['WEB_DISCOVERY']}</td>";
            echo "<td>{$row['FUNCTIONALITY_ISSUE']}</td>";
            echo "<td>{$row['LOADING_SPEED']}</td>";
            echo "<td>{$row['ADDITIONAL_COMMENTS']}</td>";
            echo "<td>{$row['FOLLOW_UP']}</td>";
            echo "<td>{$row['SUBMISSION_DATE']}</td>";
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
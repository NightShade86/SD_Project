<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the dashboard link based on user role
$dashboardLink = "index.php";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $dashboardLink = "admin_dashboard.php";
    } elseif ($_SESSION['role'] === 'staff') {
        $dashboardLink = "staff_dashboard.php";
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the IC number from the POST request
    $ic = $_POST['ic'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, USER_ID, PASSWORD, USERTYPE, IMAGE FROM user_info WHERE IC = ?");
    $stmt->bind_param("s", $ic); // 's' specifies the variable type => 'string'

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $user_data = $result->fetch_assoc();

        // Store user info in session or return it
        $_SESSION['user_data'] = $user_data;
        header("Location: {$dashboardLink}?section=add-bills");
        // You can also return the user info in JSON format for API usage

    } else {
        // User does not exist
        echo "User not found!";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

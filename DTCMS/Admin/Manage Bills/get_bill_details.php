<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Get user data
if ($_SESSION['loggedin']) {
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
}

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new MySQLi instance
$connection = new mysqli($host, $username, $password, $dbname);

// Check if bill_id is provided
if (isset($_POST['bill_id'])) {
    $bill_id = $_POST['bill_id'];

    // Fetch the bill details
    $bill_query = $connection->prepare("SELECT * FROM clinic_bills WHERE bill_id = ?");
    $bill_query->bind_param("i", $bill_id);
    $bill_query->execute();
    $bill_result = $bill_query->get_result();
    $bill = $bill_result->fetch_assoc();

    // Fetch the bill items
    $items_query = $connection->prepare("SELECT * FROM bill_items WHERE bill_id = ?");
    $items_query->bind_param("i", $bill_id);
    $items_query->execute();
    $items_result = $items_query->get_result();
    $items = $items_result->fetch_all(MYSQLI_ASSOC);

    // Generate the HTML for the modal content
    echo '<h5>Patient IC: ' . $bill['patient_ic'] . '</h5>';
    echo '<p>Payment Status: ' . $bill['payment_status'] . '</p>';
    echo '<p>Total Amount: RM ' . number_format($bill['total_amount'], 2) . '</p>';
    echo '<h6>Items:</h6>';
    echo '<ul>';
    foreach ($items as $item) {
        echo '<li>' . $item['item_name'] . ' - RM ' . number_format($item['price'], 2) . ' x ' . $item['quantity'] . ' = RM ' . number_format($item['total'], 2) . '</li>';
    }
    echo '</ul>';
}
?>

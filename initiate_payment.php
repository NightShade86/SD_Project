<?php
// Start session and ensure the user is logged in
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error_message'] = "You need to log in";
    header("Location: login_guess.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";
$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch appointment details using appointment_id
$appointment_id = $_GET['appointment_id'];
$sql = "SELECT * FROM appointment_info WHERE appointment_id = '$appointment_id'";
$result = $connection->query($sql);

if ($result->num_rows == 1) {
    $appointment = $result->fetch_assoc();
    $amount = 5000; // Set amount in cents, e.g., RM50.00 (ToyyibPay accepts amounts in cents)
    $billName = "Clinic Appointment Payment"; 
    $billDescription = "Payment for Appointment on " . $appointment['appointment_date'];
    
    // ToyyibPay API parameters
    $params = [
        'userSecretKey' => 'YOUR_TOYYIBPAY_SECRET_KEY', // ToyyibPay secret key
        'categoryCode' => 'YOUR_CATEGORY_CODE', // ToyyibPay category code
        'billName' => $billName,
        'billDescription' => $billDescription,
        'billAmount' => $amount,
        'billTo' => $appointment['fname'] . " " . $appointment['lname'],
        'billEmail' => $appointment['email'],
        'billPhone' => $appointment['number'],
        'billReturnUrl' => 'https://yourwebsite.com/payment_success.php', // Set your success URL
        'billCallbackUrl' => 'https://yourwebsite.com/payment_callback.php', // Set your callback URL
    ];

    // Convert data to URL-encoded query string format
    $postData = http_build_query($params);

    // cURL setup for ToyyibPay request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://toyyibpay.com/index.php/api/createBill");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode ToyyibPay JSON response to extract bill code
    $responseObj = json_decode($response, true);
    if (isset($responseObj[0]['BillCode'])) {
        $billCode = $responseObj[0]['BillCode'];
        // Redirect user to ToyyibPay payment page
        header("Location: https://toyyibpay.com/$billCode");
        exit();
    } else {
        echo "Error initiating payment. Please try again later.";
    }
} else {
    echo "Appointment not found.";
}

// Close the database connection
$connection->close();
?>

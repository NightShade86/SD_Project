<?php
session_start();
require_once 'db_conn.php'; // Ensure db_conn.php connects to the database

error_reporting(E_ALL);
ini_set('display_errors', 1);

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $billID = $_POST['bill_id'];

    // Retrieve bill information for payment details
    $sql = "SELECT c.*, u.EMAIL, u.NO_TEL, CONCAT(u.FIRSTNAME, ' ', u.LASTNAME) AS full_name 
            FROM clinic_bills AS c 
            JOIN user_info AS u ON c.patient_ic = u.IC 
            WHERE c.id = '$billID'";
    $result = $connection->query($sql);
    
    if ($result->num_rows > 0) {
        $bill = $result->fetch_assoc();
        $totalAmount = $bill['total_amount'];
        
        // ToyyibPay API settings
        $apiURL = "https://dev.toyyibpay.com/api";
        $apiKey = "2871juf5-0xxo-yzee-8ucv-h2lx1x4luz40"; 
        $categoryCode = "4hba40gp"; 

        // Setup payment parameters
        $params = [
            'userSecretKey' => $apiKey,
            'categoryCode' => $categoryCode,
            'billName' => 'Clinic Bill Payment',
            'billDescription' => 'Payment for medical services',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => number_format($totalAmount * 100, 0, '', ''), // Convert to cents
            'billReturnUrl' => 'http://localhost/clinicdb/SD_Project/callback.php',
            'billCallbackUrl' => 'http://localhost/clinicdb/SD_Project/callback.php',
            'billExternalReferenceNo' => $billID,
            'billTo' => $bill['full_name'],
            'billEmail' => $bill['EMAIL'],
            'billPhone' => $bill['NO_TEL'],
        ];

        // Redirect to ToyyibPay
        header("Location: " . $apiURL . "/createBill?" . http_build_query($params));
        exit;
    } else {
        echo "Bill not found or no pending amount.";
        exit;
    }
}
?>

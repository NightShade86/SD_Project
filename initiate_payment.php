<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// ToyyibPay information
$toyyibpay_key = '2871juf5-0xxo-yzee-8ucv-h2lx1x4luz40';
$toyyibpay_category_code = '4hba40gp';

// Open connection
$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bill_id'])) {
    $billID = $_POST['bill_id'];

    // Debug: Check if bill_id is passed
    echo "Bill ID: $billID<br>";

    // Retrieve bill details and join with user_info to get email and phone number
    $stmt = $connection->prepare("
        SELECT clinic_bills.*, user_info.email, user_info.NO_TEL 
        FROM clinic_bills 
        JOIN user_info ON clinic_bills.patient_ic = user_info.IC 
        WHERE clinic_bills.id = ? 
    ");
    $stmt->bind_param("i", $billID);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill = $result->fetch_assoc();

    // Debugging: Show the bill data
    if ($bill) {
        echo "<pre>";
        print_r($bill); // Check the bill data retrieved
        echo "</pre>";
        
        // Check if payment status is "Unpaid" (or other valid status)
        if ($bill['payment_status'] != 'Unpaid') {
            echo "Error: Bill is not in 'Unpaid' status. Current status: " . $bill['payment_status'];
            exit();
        }

        // Ensure the amount is correctly retrieved and formatted
        $totalAmount = floatval($bill['total_amount']); // Ensure it's a float
        if ($totalAmount <= 0) {
            echo "Invalid bill amount.";
            exit();
        }

        $transaction_id = uniqid("txn_"); // Generate a unique transaction ID
        
        // ToyyibPay parameters
        $toyyibpay_params = [
            'userSecretKey' => $toyyibpay_key,
            'categoryCode' => $toyyibpay_category_code,
            'billName' => "Clinic Payment",
            'billDescription' => "Payment for bill #{$billID}",
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => intval($totalAmount * 100), // ToyyibPay requires the amount in cents
            'billReturnUrl' => 'http://localhost/clinicdb/SD_Project/payment_success.php',
            'billCallbackUrl' => 'http://localhost/clinicdb/SD_Project/payment_callback.php',
            'billExternalReferenceNo' => $transaction_id,
            'billTo' => $bill['patient_ic'],
            'billEmail' => $bill['email'],
            'billPhone' => $bill['NO_TEL'],
        ];

        // Call ToyyibPay API to create the bill
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://dev.toyyibpay.com/api/createBill");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($toyyibpay_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $response_data = json_decode($response, true);

        // Debugging: Show the ToyyibPay API response
        echo "<pre>";
        print_r($response_data);
        echo "</pre>";

        // Check ToyyibPay API response
        if ($response_data) {
            if (isset($response_data[0]['BillCode'])) {
                $billCode = $response_data[0]['BillCode'];
                header("Location: https://dev.toyyibpay.com/{$billCode}");
                exit();
            } else {
                echo "Error initiating payment. ToyyibPay Response: ";
                echo "<pre>" . print_r($response_data, true) . "</pre>";
            }
        } else {
            echo "Error initiating payment. Invalid response from ToyyibPay.";
            echo "<pre>" . print_r($response, true) . "</pre>";
        }
    } else {
        echo "Invalid or already paid bill.";
    }
} else {
    echo "Invalid request.";
}

$connection->close();
?>

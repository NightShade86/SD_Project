<?php
session_start();

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Process the bill submission
if (isset($_POST['submit_bill'])) {
    // Get patient IC from session data
    $patient_ic = $_SESSION['user_data']['IC'];

    // Set default payment status
    $payment_status = 'Pending';

    // Get payment method from the form
    $payment_method = $_POST['payment_method'];

    // Generate a unique transaction ID
    $transaction_id = uniqid();

    // Get optional insurance details
    $insurance_company = $_POST['insurance_company'] ?? '';
    $insurance_policy_number = $_POST['insurance_policy_number'] ?? '';

    // Initialize total amount to 0 (calculated later)
    $total_amount = 0.00;

    // Insert the bill into the `clinic_bills` table
    $stmt = $pdo->prepare("INSERT INTO clinic_bills (patient_ic, payment_status, payment_method, transaction_id, insurance_company, insurance_policy_number, total_amount, total_paid, outstanding_payment) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$patient_ic, $payment_status, $payment_method, $transaction_id, $insurance_company, $insurance_policy_number, 0.00, 0.00, 0.00]);

    // Get the last inserted bill ID
    $bill_id = $pdo->lastInsertId();

    // Process and insert each cart item into the `bill_items` table
    $items = $_POST['items']; // Assuming items are passed as part of the form data
    foreach ($items as $item) {
        $item_name = $item['item'];
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $item_total = floatval($item['total']);

        // Calculate the total amount for the bill
        $total_amount += $item_total;

        // Insert the item into the `bill_items` table
        $stmt = $pdo->prepare("INSERT INTO bill_items (bill_id, item_name, price, quantity, total) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$bill_id, $item_name, $price, $quantity, $item_total]);
    }

    // Update the total amount for the bill in the `clinic_bills` table
    $stmt = $pdo->prepare("UPDATE clinic_bills SET total_amount = ?, outstanding_payment = ? WHERE id = ?");
    $stmt->execute([$total_amount, $total_amount, $bill_id]);

    // Clear the cart after processing the bill
    $_SESSION['cart'] = [];

    // Redirect or show a success message
    header("Location: index.php?success=Bill created successfully!");
    exit();
}
?>

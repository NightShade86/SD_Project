<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Restrict access based on user role
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'staff'])) {
    header("Location: login_guess.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$message = '';
$patient_exists = false;
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'check_ic' button was clicked to validate the Patient IC
    if (isset($_POST['check_ic'])) {
        $patient_ic = $_POST['patient_ic'];
        
        // Check if patient IC exists in user_info table
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_info WHERE IC = ?");
        $stmt->execute([$patient_ic]);
        
        if ($stmt->fetchColumn() == 0) {
            $message = "Error: Patient IC not found in records. Bill cannot be created.";
        } else {
            $patient_exists = true;
        }
    }

    // Process form submission for creating a bill
    if (isset($_POST['create_bill']) && !empty($_POST['items'])) {
        $patient_ic = $_POST['patient_ic'];
        $payment_status = $_POST['payment_status'];
        $payment_method = $_POST['payment_method'];
        $insurance_company = $_POST['insurance_company'] ?? '';
        $insurance_policy_number = $_POST['insurance_policy_number'] ?? '';
        $total_amount = 0;

        // Begin transaction
        $pdo->beginTransaction();

        try {
            // Insert new bill in clinic_bills
            $stmt = $pdo->prepare("INSERT INTO clinic_bills (patient_ic, payment_status, payment_method, insurance_company, insurance_policy_number, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$patient_ic, $payment_status, $payment_method, $insurance_company, $insurance_policy_number, $total_amount]);
            $bill_id = $pdo->lastInsertId(); // Get the generated bill_id after the insert

            if (!$bill_id) {
                throw new Exception("Failed to get the bill ID");
            }

            // Insert bill items and calculate total amount
            $items = $_POST['items'];
            foreach ($items as $item) {
                $item_name = $item['item_name'];
                $price = floatval($item['price']);
                $quantity = intval($item['quantity']);
                $total = $price * $quantity;
                $total_amount += $total;

                // Insert item into bill_items
                $stmt = $pdo->prepare("INSERT INTO bill_items (bill_id, item_name, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$bill_id, $item_name, $price, $quantity, $total]);
            }

            // Update total amount in clinic_bills after inserting all items
            $stmt = $pdo->prepare("UPDATE clinic_bills SET total_amount = ? WHERE bill_id = ?");
            $stmt->execute([$total_amount, $bill_id]);

            // Commit transaction
            $pdo->commit();
            
            // Set success to true to trigger JavaScript alert
            $success = true;

        } catch (Exception $e) {
            // Rollback transaction if something goes wrong
            $pdo->rollBack();
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Bill</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        h1 { color: #333; text-align: center; }
        .form-container { max-width: 600px; margin: 0 auto; padding: 20px; background: #fff; border: 1px solid #ccc; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        .form-group button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .form-group button:hover { background-color: #45a049; }
        .error-message { color: red; }
    </style>
</head>
<body>

<h1>Create New Bill</h1>

<div class="form-container">
    <?php if ($message): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Patient IC:</label>
            <input type="text" name="patient_ic" value="<?= htmlspecialchars($_POST['patient_ic'] ?? '') ?>" required>
            <button type="submit" name="check_ic">Check</button>
        </div>

        <?php if ($patient_exists): ?>
            <div class="form-group">
                <label>Payment Status:</label>
                <select name="payment_status" required>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>

            <div class="form-group">
                <label>Payment Method:</label>
                <select name="payment_method" required>
                    <option value="Online">Online</option>
                    <option value="Cash">Cash</option>
                </select>
            </div>

            <div class="form-group">
                <label>Insurance Company:</label>
                <input type="text" name="insurance_company">
            </div>

            <div class="form-group">
                <label>Insurance Policy Number:</label>
                <input type="text" name="insurance_policy_number">
            </div>

            <h3>Items</h3>
            <div id="items">
                <div class="form-group">
                    <label>Item Name:</label>
                    <input type="text" name="items[0][item_name]" required>
                    <label>Price (RM):</label>
                    <input type="number" name="items[0][price]" required step="0.01">
                    <label>Quantity:</label>
                    <input type="number" name="items[0][quantity]" required>
                </div>
            </div>

            <button type="submit" name="create_bill">Create Bill</button>
        <?php endif; ?>
    </form>
</div>

<script>
// JavaScript to display success message
<?php if ($success): ?>
    alert("Success: Bill created successfully!");
<?php endif; ?>

</script>

</body>
</html>

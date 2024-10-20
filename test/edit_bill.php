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

// Get the bill ID from the URL
$bill_id = $_GET['bill_id'] ?? null;

if (!$bill_id) {
    echo "No bill ID provided.";
    exit();
}

// Fetch the bill details
$stmt = $pdo->prepare("SELECT * FROM clinic_bills WHERE id = ?");
$stmt->execute([$bill_id]);
$bill = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bill) {
    echo "Bill not found.";
    exit();
}

// Fetch the items associated with the bill
$stmt = $pdo->prepare("SELECT * FROM bill_items WHERE bill_id = ?");
$stmt->execute([$bill_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process form submission for editing the bill
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_status = $_POST['payment_status'];
    $payment_method = $_POST['payment_method'];
    $insurance_company = $_POST['insurance_company'] ?? '';
    $insurance_policy_number = $_POST['insurance_policy_number'] ?? '';
    $total_amount = 0.00; // We'll recalculate this from the items

    // Update the bill items
    $updated_items = $_POST['items'] ?? [];
    foreach ($updated_items as $item_id => $updated_item) {
        $item_name = $updated_item['item_name'];
        $price = floatval($updated_item['price']);
        $quantity = intval($updated_item['quantity']);
        $total = $price * $quantity;
        $total_amount += $total;

        if (isset($updated_item['remove'])) {
            // Remove the item if requested
            $stmt = $pdo->prepare("DELETE FROM bill_items WHERE id = ?");
            $stmt->execute([$item_id]);
        } else {
            // Update the item in the database
            $stmt = $pdo->prepare("UPDATE bill_items SET item_name = ?, price = ?, quantity = ?, total = ? WHERE id = ?");
            $stmt->execute([$item_name, $price, $quantity, $total, $item_id]);
        }
    }

    // Add new items
    if (isset($_POST['new_items'])) {
        $new_items = $_POST['new_items'];
        foreach ($new_items as $new_item) {
            $item_name = $new_item['item_name'];
            $price = floatval($new_item['price']);
            $quantity = intval($new_item['quantity']);
            $total = $price * $quantity;
            $total_amount += $total;

            // Insert new item into the database
            $stmt = $pdo->prepare("INSERT INTO bill_items (bill_id, item_name, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$bill_id, $item_name, $price, $quantity, $total]);
        }
    }

    // Update the bill total and other details
    $stmt = $pdo->prepare("UPDATE clinic_bills SET payment_status = ?, payment_method = ?, insurance_company = ?, insurance_policy_number = ?, total_amount = ?, outstanding_payment = ? WHERE id = ?");
    $stmt->execute([$payment_status, $payment_method, $insurance_company, $insurance_policy_number, $total_amount, $total_amount, $bill_id]);

    // Redirect to the bills page with success message
    header("Location: bill.php?success=Bill updated successfully!");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bill</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .form-control {
            padding: 5px;
            width: 100%;
            margin-bottom: 10px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .btn-add {
            background-color: #2196F3;
            margin-top: 10px;
        }
    </style>
    <script>
        let itemIndex = 0; // Keeps track of how many new items have been added

        function addNewItemRow() {
            itemIndex++;
            const table = document.getElementById("new-items-table");
            const row = document.createElement("tr");
            row.innerHTML = `
                <td><input type="text" name="new_items[${itemIndex}][item_name]" class="form-control"></td>
                <td><input type="text" name="new_items[${itemIndex}][price]" class="form-control"></td>
                <td><input type="number" name="new_items[${itemIndex}][quantity]" class="form-control"></td>
            `;
            table.appendChild(row);
        }
    </script>
</head>
<body>

<h1>Edit Bill</h1>

<form action="" method="POST">
    <h2>Bill Information</h2>

    <label for="payment_status">Payment Status:</label>
    <select id="payment_status" name="payment_status" class="form-control">
        <option value="Pending" <?= $bill['payment_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Paid" <?= $bill['payment_status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
    </select>

    <label for="payment_method">Payment Method:</label>
    <select id="payment_method" name="payment_method" class="form-control">
        <option value="Cash" <?= $bill['payment_method'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
        <option value="Card" <?= $bill['payment_method'] == 'Card' ? 'selected' : '' ?>>Card</option>
        <option value="Insurance" <?= $bill['payment_method'] == 'Insurance' ? 'selected' : '' ?>>Insurance</option>
    </select>

    <label for="insurance_company">Insurance Company (if applicable):</label>
    <input type="text" id="insurance_company" name="insurance_company" value="<?= htmlspecialchars($bill['insurance_company']) ?>" class="form-control">

    <label for="insurance_policy_number">Insurance Policy Number (if applicable):</label>
    <input type="text" id="insurance_policy_number" name="insurance_policy_number" value="<?= htmlspecialchars($bill['insurance_policy_number']) ?>" class="form-control">

    <h2>Items</h2>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><input type="text" name="items[<?= $item['id'] ?>][item_name]" value="<?= htmlspecialchars($item['item_name']) ?>" class="form-control"></td>
                <td><input type="text" name="items[<?= $item['id'] ?>][price]" value="<?= htmlspecialchars($item['price']) ?>" class="form-control"></td>
                <td><input type="number" name="items[<?= $item['id'] ?>][quantity]" value="<?= htmlspecialchars($item['quantity']) ?>" class="form-control"></td>
                <td>$<?= number_format($item['total'], 2) ?></td>
                <td><input type="checkbox" name="items[<?= $item['id'] ?>][remove]" value="1"> Remove</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Add New Items</h2>
    <table id="new-items-table">
        <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </table>
    <button type="button" class="btn btn-add" onclick="addNewItemRow()">Add New Item</button>

    <br><br>
    <button type="submit" class="btn">Update Bill</button>
</form>

<a href="bill.php">Back to Bills</a>

</body>
</html>


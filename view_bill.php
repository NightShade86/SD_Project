<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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

if ($bill_id) {
    // Fetch the bill details
    $stmt = $pdo->prepare("SELECT * FROM clinic_bills WHERE id = ?");
    $stmt->execute([$bill_id]);
    $bill = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bill) {
        // Fetch the items associated with the bill
        $stmt = $pdo->prepare("SELECT * FROM bill_items WHERE bill_id = ?");
        $stmt->execute([$bill_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Bill not found.";
        exit();
    }
} else {
    echo "No bill ID provided.";
    exit();
}

// Determine the redirection link based on the role
$backLink = "index.php";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $backLink = "admin_dashboard.php?section=view-bills";
    } elseif ($_SESSION['role'] === 'staff') {
        $backLink = "staff_dashboard.php?section=view-bills";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bill Details</title>
</head>
<body>

<h1>Bill Details</h1>

<p>Transaction ID: <?= htmlspecialchars($bill['transaction_id']) ?></p>
<p>Total Amount: $<?= number_format($bill['total_amount'], 2) ?></p>
<p>Outstanding Payment: $<?= number_format($bill['outstanding_payment'], 2) ?></p>
<p>Patient IC: <?= htmlspecialchars($bill['patient_ic']) ?></p>
<p>Payment Status: <?= htmlspecialchars($bill['payment_status']) ?></p>

<h2>Items</h2>
<table>
    <tr>
        <th>Item Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['item_name']) ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td>$<?= number_format($item['total'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Back to Bills link based on role -->
<a href="<?= $backLink ?>">Back to Bills</a>

</body>
</html>

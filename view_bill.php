<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'staff'])) {
    header("Location: index.php");
    exit();
}

// Database connection parameters
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

// Fetch all bills
$stmt = $pdo->query("SELECT * FROM clinic_bills ORDER BY created_at ASC");

$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bills</title>
</head>
<body>
<h1>Bills</h1>
<?php if (isset($_GET['success'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif; ?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Patient IC</th>
        <th>Status</th>
        <th>Total Amount</th>
        <th>Action</th>
    </tr>
    <?php foreach ($bills as $bill): ?>
        <tr>
            <td><?= htmlspecialchars($bill['id']) ?></td>
            <td><?= htmlspecialchars($bill['patient_ic']) ?></td>
            <td><?= htmlspecialchars($bill['payment_status']) ?></td>
            <td>$<?= number_format($bill['total_amount'], 2) ?></td>
            <td>
                <a href="edit_bill.php?bill_id=<?= $bill['id'] ?>">Edit</a>
                <a href="delete_bill.php?bill_id=<?= $bill['id'] ?>" onclick="return confirm('Are you sure you want to delete this bill?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

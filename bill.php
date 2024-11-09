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

// Fetch all bills from the clinic_bills table
$stmt = $pdo->prepare("SELECT * FROM clinic_bills ORDER BY created_at DESC");
$stmt->execute();
$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Determine the dashboard link based on user role
$dashboardLink = "index.php";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $dashboardLink = "admin_dashboard.php";
    } elseif ($_SESSION['role'] === 'staff') {
        $dashboardLink = "staff_dashboard.php";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
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
        .action-btn {
            margin-right: 10px;
            padding: 5px 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }
        .delete-btn {
            background-color: #f44336;
        }
    </style>
</head>
<body>

<h1>List of Bills</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Patient IC</th>
        <th>Payment Status</th>
        <th>Payment Method</th>
        <th>Total Amount</th>
        <th>Outstanding Payment</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($bills as $bill): ?>
        <tr>
            <td><?= htmlspecialchars($bill['id']) ?></td>
            <td><?= htmlspecialchars($bill['patient_ic']) ?></td>
            <td><?= htmlspecialchars($bill['payment_status']) ?></td>
            <td><?= htmlspecialchars($bill['payment_method']) ?></td>
            <td>RM <?= number_format($bill['total_amount'], 2) ?></td>
            <td>RM <?= number_format($bill['outstanding_payment'], 2) ?></td>
            <td>
                <!-- View Button -->
                <a href="<?= $dashboardLink ?>?section=show-bills&bill_id=<?= $bill['id'] ?>" class="action-btn">View</a>

                <!-- Edit Button -->
                <a href="<?= $dashboardLink ?>?section=edit-bills&bill_id=<?= $bill['id'] ?>" class="action-btn">Edit</a>

                <!-- Delete Button -->
                <a href="<?= $dashboardLink ?>?section=delete-bills&bill_id=<?= $bill['id'] ?>" class="action-btn delete-btn"
                   onclick="return confirm('Are you sure you want to delete this bill?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is an admin or staff
if (empty($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'staff'])) {
    header('Location: index.php');
    exit();
}

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

// Update the payment status in the database based on the button clicked
if (isset($_POST['mark_paid'])) {
    $bill_id = $_POST['bill_id'];
    $updateStatus = $pdo->prepare("UPDATE clinic_bills SET payment_status = 'Paid' WHERE id = ?");
    $updateStatus->execute([$bill_id]);
}

if (isset($_POST['undo_paid'])) {
    $bill_id = $_POST['bill_id'];
    $updateStatus = $pdo->prepare("UPDATE clinic_bills SET payment_status = 'Pending' WHERE id = ?");
    $updateStatus->execute([$bill_id]);
}

// Fetch bills where payment status is either 'Paid' or 'Pending'
$stmt = $pdo->prepare("SELECT * FROM clinic_bills WHERE payment_status IN ('Paid', 'Pending') ORDER BY payment_date DESC");
$stmt->execute();
$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
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
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-undo {
            background-color: #f44336; /* Red */
        }
        .paid {
            background-color: #d4edda; /* Light green for paid */
        }
        .pending {
            background-color: #f8d7da; /* Light red for pending */
        }
    </style>
</head>
<body>

<h1>View Transactions</h1>

<table>
    <tr>
        <th>Bill ID</th>
        <th>Receipt ID</th>
        <th>Patient IC</th>
        <th>Total Amount</th>
        <th>Payment Status</th>
        <th>Payment Method</th>
        <th>Transaction Date</th>
        <th>Action</th>
    </tr>

    <?php foreach ($bills as $bill): ?>
        <tr class="<?= strtolower($bill['payment_status']) ?>">
            <td><?= htmlspecialchars($bill['id']) ?></td> <!-- Bill ID -->
            <td><?= htmlspecialchars($bill['receipt_id']) ?></td> <!-- Receipt ID -->
            <td><?= htmlspecialchars($bill['patient_ic']) ?></td>
            <td>RM <?= number_format($bill['total_amount'], 2) ?></td>
            <td><?= htmlspecialchars($bill['payment_status']) ?></td>
            <td><?= htmlspecialchars($bill['payment_method']) ?></td>
            <td><?= htmlspecialchars($bill['payment_date']) ?></td>
            <td>
                <?php if ($bill['payment_status'] == 'Pending'): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="bill_id" value="<?= $bill['id'] ?>">
                        <button type="submit" name="mark_paid" class="btn">Mark as Paid</button>
                    </form>
                <?php elseif ($bill['payment_status'] == 'Paid'): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="bill_id" value="<?= $bill['id'] ?>">
                        <button type="submit" name="undo_paid" class="btn btn-undo">Undo</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

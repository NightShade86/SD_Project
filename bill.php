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

// Fetch bills from clinic_bills table using JOIN with bill_items
$stmt = $pdo->prepare("SELECT clinic_bills.*, bill_items.item_name, bill_items.price 
                       FROM clinic_bills
                       LEFT JOIN bill_items ON clinic_bills.id = bill_items.bill_id
                       ORDER BY clinic_bills.created_at DESC");
$stmt->execute();
$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Determine the dashboard link based on user role
$dashboardLink = "index.php"; // Default dashboard link for guests
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $dashboardLink = "admin_dashboard.php"; // Admin dashboard
    } elseif ($_SESSION['role'] === 'staff') {
        $dashboardLink = "staff_dashboard.php"; // Staff dashboard
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
        }
        th, td {
            padding: 14px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #333;
        }
        th {
            background-color: #444;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .action-btns a {
            text-decoration: none;
            padding: 5px 12px; /* Reduced padding */
            font-size: 14px; /* Smaller font size */
            border-radius: 5px;
            margin: 0 5px; /* Reduced margin for buttons to be closer */
            font-weight: bold;
            color: white;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .edit-btn {
            background-color: #ffc107;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .edit-btn:hover {
            background-color: #e0a800;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .btn-icon {
            margin-right: 5px; /* Adjust icon spacing */
        }
    </style>
</head>
<body>

<h1>List of Bills</h1>

<!-- Bill Table -->
<table>
    <tr>
        <th>ID</th>
        <th>Patient IC</th>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total Amount</th>
        <th>Payment Status</th> <!-- Added Payment Status Column -->
        <th>Actions</th>
    </tr>

    <?php $counter = 1; ?>
    <?php foreach ($bills as $bill): ?>
        <tr>
            <td><?= $counter++ ?></td> <!-- ID starts from 1 and increments -->
            <td><?= htmlspecialchars($bill['patient_ic']) ?></td>
            <td><?= isset($bill['item_name']) ? htmlspecialchars($bill['item_name']) : 'N/A' ?></td>
            <td>RM <?= isset($bill['price']) && is_numeric($bill['price']) ? number_format($bill['price'], 2) : '0.00' ?></td>
            <td><?= isset($bill['quantity']) ? htmlspecialchars($bill['quantity']) : '0' ?></td>
            <td>RM <?= isset($bill['total_amount']) && is_numeric($bill['total_amount']) ? number_format($bill['total_amount'], 2) : '0.00' ?></td>
            <td>
                <!-- Display the payment status -->
                <?php
                if ($bill['payment_status'] == 'Paid') {
                    echo '<span style="color: green; font-weight: bold;">Paid</span>';
                } elseif ($bill['payment_status'] == 'Pending') {
                    echo '<span style="color: orange; font-weight: bold;">Pending</span>';
                } else {
                    echo '<span style="color: red; font-weight: bold;">Unpaid</span>';
                }
                ?>
            </td>
            <td class="action-btns">
                <!-- Edit Button -->
                <a href="<?= $dashboardLink ?>?section=edit-bills&bill_id=<?= $bill['id'] ?>" class="edit-btn">
                    <i class="fas fa-edit btn-icon"></i> Edit
                </a>

                <!-- Delete Button -->
                <a href="<?= $dashboardLink ?>?section=delete-bills&bill_id=<?= $bill['id'] ?>" class="delete-btn"
                   onclick="return confirm('Are you sure you want to delete this bill?')">
                    <i class="fas fa-trash-alt btn-icon"></i> Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Include FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>

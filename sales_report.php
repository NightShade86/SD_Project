<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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

// Initialize filter variables
$startDate = '';
$endDate = '';
$filterType = 'daily'; // Default filter (daily)

// Check if a filter is applied
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['filter_type'])) {
        $filterType = $_POST['filter_type'];
    }
    if ($filterType == 'daily' && isset($_POST['date'])) {
        $startDate = $_POST['date'] . ' 00:00:00'; // Start of the selected day
        $endDate = $_POST['date'] . ' 23:59:59'; // End of the selected day
    } elseif ($filterType == 'monthly' && isset($_POST['month'])) {
        $startDate = $_POST['month'] . '-01 00:00:00'; // Start of the month
        $endDate = $_POST['month'] . '-31 23:59:59'; // End of the month (assumes 31 days, adjust as needed)
    }
}

// Prepare the SQL query based on the selected filter
$sql = "SELECT * FROM clinic_bills WHERE payment_date BETWEEN :startDate AND :endDate ORDER BY payment_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total sales (income and unpaid)
$totalIncome = 0;
$totalUnpaid = 0;
foreach ($bills as $bill) {
    if ($bill['payment_status'] == 'Paid') {
        $totalIncome += $bill['total_amount'];
    } elseif ($bill['payment_status'] == 'Pending') {
        $totalUnpaid += $bill['total_amount'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - DR. THONG CLINIC</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1, h3 {
            color: #4CAF50;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 30px;
        }

        .header img {
            width: 80px;
            vertical-align: middle;
        }

        .clinic-name {
            font-size: 2em;
            font-weight: bold;
            margin-top: 10px;
        }

        .filter-form {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-form select, .filter-form input {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .report-summary, .report-table {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .report-summary p {
            font-size: 18px;
            margin: 10px 0;
        }

        .report-summary strong {
            font-size: 20px;
            color: #4CAF50;
        }

        .report-table table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th, .report-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .report-table th {
            background-color: #4CAF50;
            color: white;
        }

        .report-table tr:hover {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto;
        }

        .btn:hover {
            background-color: #45a049;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .btn {
                display: none;
            }

            .filter-form, .header {
                display: none;
            }

            .container {
                max-width: 100%;
                margin: 0;
            }

            .report-summary, .report-table {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="logo.png" alt="Dr. Thong Clinic Logo">
        <div class="clinic-name">DR. THONG CLINIC</div>
        <h1>Sales Report</h1>
    </div>

    <p>Date: <?php echo date('Y-m-d H:i:s'); ?></p>

    <!-- Filter Form -->
    <div class="filter-form">
        <form method="POST" action="">
            <label for="filter_type">Choose Report Type:</label>
            <select name="filter_type" id="filter_type" onchange="this.form.submit()">
                <option value="daily" <?php echo ($filterType == 'daily') ? 'selected' : ''; ?>>Daily</option>
                <option value="monthly" <?php echo ($filterType == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
            </select>

            <br><br>

            <!-- Monthly or Daily Filter -->
            <?php if ($filterType == 'daily'): ?>
                <label for="date">Choose Date:</label>
                <input type="date" name="date" value="<?php echo $startDate ? date('Y-m-d', strtotime($startDate)) : ''; ?>" onchange="this.form.submit()">
            <?php elseif ($filterType == 'monthly'): ?>
                <label for="month">Choose Month:</label>
                <input type="month" name="month" value="<?php echo $startDate ? date('Y-m', strtotime($startDate)) : ''; ?>" onchange="this.form.submit()">
            <?php endif; ?>
        </form>
    </div>

    <!-- Sales Summary -->
    <div class="report-summary">
        <h3>Sales Summary</h3>
        <p><strong>Total Income (Paid):</strong> RM <?php echo number_format($totalIncome, 2); ?></p>
        <p><strong>Total Unpaid (Pending):</strong> RM <?php echo number_format($totalUnpaid, 2); ?></p>
    </div>

    <!-- Sales Report Table -->
    <div class="report-table">
        <h3>Sales Report for <?php echo ucfirst($filterType); ?>: <?php echo ($filterType == 'daily' ? $startDate : date('F', strtotime($startDate))); ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Patient IC</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?= htmlspecialchars($bill['id']) ?></td>
                        <td><?= htmlspecialchars($bill['patient_ic']) ?></td>
                        <td>RM <?= number_format($bill['total_amount'], 2) ?></td>
                        <td><?= htmlspecialchars($bill['payment_status']) ?></td>
                        <td><?= htmlspecialchars($bill['payment_method']) ?></td>
                        <td><?= htmlspecialchars($bill['payment_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Print Button -->
    <button class="btn" onclick="window.print()">Print Report</button>
</div>

</body>
</html>

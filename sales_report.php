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

$stmt = $pdo->prepare("SELECT * FROM clinic_bills ORDER BY payment_date DESC");
$stmt->execute();
$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the report content (you can adjust this part as needed)
$report_content = "Sales Report\n";
$report_content .= "Date: " . date('Y-m-d H:i:s') . "\n\n";

foreach ($bills as $bill) {
    $report_content .= "Bill ID: " . $bill['id'] . "\n";
    $report_content .= "Patient IC: " . $bill['patient_ic'] . "\n";
    $report_content .= "Total Amount: $" . number_format($bill['total_amount'], 2) . "\n";
    $report_content .= "Payment Status: " . $bill['payment_status'] . "\n";
    $report_content .= "Payment Method: " . $bill['payment_method'] . "\n";
    $report_content .= "Payment Date: " . $bill['payment_date'] . "\n\n";
}

// Output the report (or save it to a file)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .report-content {
            white-space: pre-wrap;  /* Maintains line breaks */
        }
    </style>
</head>
<body>

<h1>Sales Report</h1>

<div class="report-content">
    <?php
    // Display the report content
    echo nl2br($report_content);  
    ?>
</div>

<!-- Print Button -->
<button onclick="printReport()">Print Report</button>

<script>
    function printReport() {
        window.print(); // This will open the browser's print dialog
    }
</script>

</body>
</html>

<?php
// Optionally, you can also save it to a file
file_put_contents('sales_report.txt', $report_content);
?>

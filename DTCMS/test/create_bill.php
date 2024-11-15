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

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add item to cart
    if (isset($_POST['add_item'])) {
        $item = $_POST['item'];
        $price = floatval($_POST['price']);
        $quantity = intval($_POST['quantity']);

        // Add the item to the cart
        $_SESSION['cart'][] = ['item' => $item, 'price' => $price, 'quantity' => $quantity];
    }

    // Delete item from cart
    if (isset($_POST['delete_item'])) {
        $index = intval($_POST['index']);
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
    }

    // Update item in cart
    if (isset($_POST['update_item'])) {
        $index = intval($_POST['index']);
        $item = $_POST['item'];
        $price = floatval($_POST['price']);
        $quantity = intval($_POST['quantity']);

        $_SESSION['cart'][$index] = ['item' => $item, 'price' => $price, 'quantity' => $quantity];
    }

    // Process the bill submission
    if (isset($_POST['submit_bill'])) {
        $patient_ic = $_POST['ic'];
        $payment_status = 'Pending'; // Initial status
        $payment_method = $_POST['payment_method']; // Payment method chosen by user
        $transaction_id = uniqid(); // Generate a unique transaction ID
        $insurance_company = $_POST['insurance_company'] ?? '';
        $insurance_policy_number = $_POST['insurance_policy_number'] ?? '';
        $total_amount = calculateTotal($_SESSION['cart']);
        $total_paid = 0.00; // Total paid initially
        $outstanding_payment = $total_amount; // Initially, total is outstanding

        // Insert bill into the database
        $stmt = $pdo->prepare("INSERT INTO clinic_bills (patient_ic, payment_status, payment_method, transaction_id, insurance_company, insurance_policy_number, total_amount, total_paid, outstanding_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$patient_ic, $payment_status, $payment_method, $transaction_id, $insurance_company, $insurance_policy_number, $total_amount, $total_paid, $outstanding_payment]);

        // Get the last inserted bill ID
        $bill_id = $pdo->lastInsertId();

        // Insert each cart item into the database
        foreach ($_SESSION['cart'] as $cartItem) {
            $item_name = $cartItem['item'];
            $price = $cartItem['price'];
            $quantity = $cartItem['quantity'];
            $item_total = $price * $quantity;

            $stmt = $pdo->prepare("INSERT INTO bill_items (bill_id, item_name, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$bill_id, $item_name, $price, $quantity, $item_total]);
        }

        // Clear the cart after processing the bill
        $_SESSION['cart'] = [];

        // Redirect or show a success message
        header("Location: index.php?success=Bill created successfully!");
        exit();
    }
}

function calculateTotal($cart) {
    $total = 0;
    foreach ($cart as $cartItem) {
        $total += $cartItem['price'] * $cartItem['quantity'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Billing System</title>
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
        .user-form {
            display: none; /* By default, the form is hidden */
            max-width: 400px;
            margin: 20px auto;
        }
        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        input[readonly] {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<h1>Create Bill for Patient</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_GET['success']); ?></p>
<?php endif; ?>

<form method="post" action="icverify.php">
    <label for="ic">Identification Number:</label>
    <input type="text" name="ic" required>

    <button type="submit" name="submit">Check</button>
</form>

<br>
<?php
if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
    $fname = $user_data['FIRSTNAME'];
    $lname = $user_data['LASTNAME'];
    $pnum = $user_data['NO_TEL'];
    $email = $user_data['EMAIL'];
    $ic = $user_data['IC'];
    $usertype = $user_data['USERTYPE'];
    $image = $user_data['IMAGE'] ?? 'default-avatar.png';
// Display the form since session data is set
echo '<style>.user-form { display: block; }</style>';
} else {
    echo "<p>No user information found in the session.</p>";
}
?>
<!-- The form is only shown if session data is available -->
<form class="user-form">
    <div>
        <img src="<?= htmlspecialchars($image) ?>" alt="User Avatar" class="user-avatar">
    </div>
    <div>
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?= isset($fname) ? htmlspecialchars($fname) : '' ?>" readonly>
    </div>
    <div>
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" value="<?= isset($lname) ? htmlspecialchars($lname) : '' ?>" readonly>
    </div>
    <div>
        <label for="pnum">Phone Number:</label>
        <input type="text" id="pnum" name="pnum" value="<?= isset($pnum) ? htmlspecialchars($pnum) : '' ?>" readonly>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" readonly>
    </div>
    <div>
        <label for="ic">IC Number:</label>
        <input type="text" id="ic" name="ic" value="<?= isset($ic) ? htmlspecialchars($ic) : '' ?>" readonly>
    </div>
    <div>
        <label for="usertype">User Type:</label>
        <input type="text" id="usertype" name="usertype" value="<?= isset($usertype) ? htmlspecialchars($usertype) : '' ?>" readonly>
    </div>
</form>
<br>
<button onclick="window.location.href='http://localhost/clinicdb/SD_Project/logout.php';">Clear session</button>
<br>

<form method="post">
    <label for="item">Item:</label>
    <input type="text" name="item" required>

    <label for="price">Price:</label>
    <input type="number" name="price" step="0.01" required>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required>

    <button type="submit" name="add_item">Add Item</button>
</form>


<h2>Cart Preview</h2>
<table>
    <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    <?php foreach ($_SESSION['cart'] as $index => $cartItem): ?>
        <tr>
            <form method="post">
                <td><input type="text" name="item" value="<?= htmlspecialchars($cartItem['item']) ?>" required></td>
                <td><input type="number" name="price" step="0.01" value="<?= htmlspecialchars($cartItem['price']) ?>" required></td>
                <td><input type="number" name="quantity" value="<?= htmlspecialchars($cartItem['quantity']) ?>" required></td>
                <td>
                    <?php
                    $itemTotal = $cartItem['price'] * $cartItem['quantity'];
                    echo number_format($itemTotal, 2);
                    ?>
                </td>
                <td>
                    <button type="submit" name="update_item">Update</button>
                    <button type="submit" name="delete_item">Delete</button>
                    <input type="hidden" name="index" value="<?= $index ?>">
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Total: $<?= number_format(calculateTotal($_SESSION['cart']), 2) ?></h3>

<!-- Bill submission form -->
<h2>Submit Bill</h2>
<form method="post" action="submit_bill.php">
    <label for="payment_method">Payment Method:</label>
    <select name="payment_method" required>
        <option value="Cash">Cash</option>
        <option value="Online">Online</option>
    </select>

    <label for="insurance_company">Insurance Company (optional):</label>
    <input type="text" name="insurance_company">

    <label for="insurance_policy_number">Insurance Policy Number (optional):</label>
    <input type="text" name="insurance_policy_number">

    <!-- Hidden inputs for cart items -->
    <?php foreach ($_SESSION['cart'] as $index => $cartItem): ?>
        <input type="hidden" name="items[<?= $index ?>][item]" value="<?= htmlspecialchars($cartItem['item']) ?>">
        <input type="hidden" name="items[<?= $index ?>][price]" value="<?= htmlspecialchars($cartItem['price']) ?>">
        <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= htmlspecialchars($cartItem['quantity']) ?>">
        <input type="hidden" name="items[<?= $index ?>][total]" value="<?= htmlspecialchars($cartItem['price'] * $cartItem['quantity']) ?>">
    <?php endforeach; ?>

    <button type="submit" name="submit_bill">Submit Bill</button>
</form>

</body>
</html>

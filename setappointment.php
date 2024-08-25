<?php
// Database connection details
$host = 'localhost';
$db = 'appointments_db'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Read form values
$success = false;
$senderName = isset($_POST['username']) ? $_POST['username'] : "";
$senderPhone = isset($_POST['phone']) ? $_POST['phone'] : "";
$senderEmail = isset($_POST['email']) ? $_POST['email'] : "";
$department = isset($_POST['departments']) ? $_POST['departments'] : "";
$senderDate = isset($_POST['date']) ? $_POST['date'] : "";
$senderTime = isset($_POST['time']) ? $_POST['time'] : "";
$message = isset($_POST['message']) ? $_POST['message'] : "";

// Insert the appointment into the database
if ($senderName && $senderEmail && $senderPhone && $department && $senderDate && $senderTime && $message) {
    try {
        $stmt = $pdo->prepare("INSERT INTO appointments (name, phone, email, department, date, time, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$senderName, $senderPhone, $senderEmail, $department, $senderDate, $senderTime, $message]);
        $success = true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Redirect based on success
if ($success) {
    echo "<script>alert('Your appointment has been successfully scheduled. Thank you! 🙂');</script>";
    echo "<script>document.location.href='index.html'</script>";
} else {
    echo "<script>alert('Appointment was not scheduled. Please try again.');</script>";
    echo "<script>document.location.href='contact.html'</script>";
}
?>

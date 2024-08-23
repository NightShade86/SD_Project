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
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Fetch appointments from the database
try {
    $stmt = $pdo->query("SELECT * FROM appointments ORDER BY date DESC, time ASC");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($appointments);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

<?php
// MySQL connection details
$servername = "localhost";
$username = "root";

$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS medical_dashboard";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Connect to the newly created database
$conn->select_db('medical_dashboard');

// Create the 'patients' table
$sql = "CREATE TABLE IF NOT EXISTS patients (
            patientNumber INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            age INT NOT NULL,
            address VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            email VARCHAR(255) NOT NULL
        )";
if ($conn->query($sql) === TRUE) {
    echo "Patients table created successfully.<br>";
} else {
    echo "Error creating patients table: " . $conn->error . "<br>";
}

// Create the 'appointments' table
$sql = "CREATE TABLE IF NOT EXISTS appointments (
            appointmentID INT PRIMARY KEY AUTO_INCREMENT,
            patientNumber INT,
            date DATE NOT NULL,
            time TIME NOT NULL,
            type VARCHAR(50),
            FOREIGN KEY (patientNumber) REFERENCES patients(patientNumber) ON DELETE CASCADE
        )";
if ($conn->query($sql) === TRUE) {
    echo "Appointments table created successfully.<br>";
} else {
    echo "Error creating appointments table: " . $conn->error . "<br>";
}

// Insert sample data if tables are empty
$sql = "SELECT COUNT(*) AS count FROM patients";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sql = "INSERT INTO patients (name, age, address, phone, email) 
            VALUES 
            ('John Doe', 45, '123 Maple Street', '123-456-7890', 'john.doe@example.com'),
            ('Jane Smith', 37, '456 Oak Avenue', '987-654-3210', 'jane.smith@example.com')";
    if ($conn->query($sql) === TRUE) {
        echo "Sample patients inserted successfully.<br>";
    }

    $sql = "INSERT INTO appointments (patientNumber, date, time, type) 
            VALUES 
            (1, CURDATE(), '10:00:00', 'General Checkup'),
            (2, CURDATE(), '11:30:00', 'Follow-up Consultation')";
    if ($conn->query($sql) === TRUE) {
        echo "Sample appointments inserted successfully.<br>";
    }
}

// Close the connection
$conn->close();
?>

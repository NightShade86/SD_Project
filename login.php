<?php
session_start();
require('db_connection.php'); // Assume this includes the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "clinicdb";

// Open connection
    $connection = new mysqli($servername, $username, $password, $dbname);


    // Query to fetch user by username and password
    $query = "SELECT id, username, role FROM users WHERE username=? AND password=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $role);
        $stmt->fetch();

        // Store user info in session
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect user based on role
        if ($role == '1') {
            header("Location: patient_dashboard.php");
        } elseif ($role == '2') {
            header("Location: staff_dashboard.php?section=patients");
        } elseif ($role == '3') {
            header("Location: admin_dashboard.php?section=staff");
        }
    } else {
        echo "Invalid username or password";
    }
}
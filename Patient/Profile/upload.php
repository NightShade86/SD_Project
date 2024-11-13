<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'your_database_name'; // Database name
$username = 'your_username'; // Database username
$password = 'your_password'; // Database password

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a file was uploaded
if (isset($_FILES['profilePicture'])) {
    $file = $_FILES['profilePicture'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file['error']);
    }

    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        die("File size exceeds the maximum limit of 5MB.");
    }

    // Validate file type (you can add more types if needed)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Invalid file type. Only JPG, PNG, and GIF files are allowed.");
    }

    // Read the file contents
    $fileData = file_get_contents($file['tmp_name']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO your_table_name (profile_picture) VALUES (?)");
    $stmt->bind_param('b', $fileData);

    // Execute the query
    if ($stmt->execute()) {
        echo "Profile picture uploaded successfully.";
    } else {
        echo "Error uploading profile picture: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No file uploaded.";
}

// Close the database connection
$conn->close();
?>

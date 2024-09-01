<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['token'])) {
        $token = $conn->real_escape_string($_GET['token']);

        // Fetch token from database
        $sql = "SELECT * FROM email_verification_tokens WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $tokenData = $result->fetch_assoc();

        if ($tokenData) {
            // Check if token has expired
            $currentTime = (new DateTime())->format('Y-m-d H:i:s');
            if ($currentTime > $tokenData['expires_at']) {
                echo "Token has expired.";
                exit;
            }

            // Mark email as verified
            $userId = $tokenData['user_id'];
            $sqlUpdate = "UPDATE user_info SET verified = TRUE WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("i", $userId);
            $stmtUpdate->execute();

            // Delete the token
            $sqlDelete = "DELETE FROM email_verification_tokens WHERE token = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("s", $token);
            $stmtDelete->execute();

            echo "Email successfully verified!";
        } else {
            echo "Invalid token.";
        }
    } else {
        echo "No token provided.";
    }

    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

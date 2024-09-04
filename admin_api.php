<?php
// Retrieve data based on the feature
$feature = isset($_GET['feature']) ? $_GET['feature'] : '';
$data = [];

switch ($feature) {
    case 'view-staff':
        // Sample data for 'view-staff'
        $data = [
            ["id" => 1, "name" => "Alice Johnson", "position" => "Nurse", "email" => "alice.johnson@example.com"],
            ["id" => 2, "name" => "Bob Brown", "position" => "Doctor", "email" => "bob.brown@example.com"]
        ];
        break;

    case 'view-appointment':
        // Sample data for 'view-appointment'
        $data = [
            ["id" => 1, "patient" => "Michael Scott", "date" => "2024-09-01", "time" => "10:00 AM", "doctor" => "Dr. Brown"],
            ["id" => 2, "patient" => "Pam Beesly", "date" => "2024-09-02", "time" => "11:00 AM", "doctor" => "Dr. Johnson"]
        ];
        break;

    case 'view-patients':
        // Sample data for 'view-patients'
        $data = [
            ["id" => 1, "name" => "Jim Halpert", "age" => 35, "condition" => "Flu"],
            ["id" => 2, "name" => "Dwight Schrute", "age" => 38, "condition" => "Back pain"]
        ];
        break;

    case 'view-bills':
        // Sample data for 'view-bills'
        $data = [
            ["id" => 1, "patient" => "Jim Halpert", "amount" => "$200", "status" => "Paid"],
            ["id" => 2, "patient" => "Pam Beesly", "amount" => "$150", "status" => "Unpaid"]
        ];
        break;

    case 'view-transaction':
        // Sample data for 'view-transaction'
        $data = [
            ["id" => 1, "transaction_id" => "TXN123456", "amount" => "$200", "date" => "2024-09-01", "status" => "Success"],
            ["id" => 2, "transaction_id" => "TXN789012", "amount" => "$150", "date" => "2024-09-02", "status" => "Pending"]
        ];
        break;

    case 'generate-sales-report':
        // Sample data for 'generate-sales-report'
        $data = [
            ["month" => "August", "total_sales" => "$5000", "number_of_transactions" => 30],
            ["month" => "September", "total_sales" => "$4500", "number_of_transactions" => 25]
        ];
        break;
    
    case 'view-feedback':
        // Sample data for 'view-feedback'
        $data = [
            ["id" => 1, "message" => "Great service!"],
            ["id" => 2, "message" => "Needs improvement."]
        ];
        break;

    //case 'view-profile':
        // Simulating fetching profile data
        // Replace with actual database connection and query
        // Assuming profile id is 1 for this example
       // $profile_id = 1;
        // Replace with your database connection code
      //  $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
      //  $stmt = $pdo->prepare("SELECT profile_pic, address, email FROM profiles WHERE id = ?");
      //  $stmt->execute([$profile_id]);
      //  $data = $stmt->fetch(PDO::FETCH_ASSOC);
      //  break;

    default:
        // Return an error message for unknown features
        $data = ["error" => "Unknown feature: " . htmlspecialchars($feature)];
}

// Set the content type to JSON
header('Content-Type: application/json');

// Return the data as JSON
echo json_encode($data);
?>

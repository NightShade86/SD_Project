<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtcmsdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['fname']);  // First Name
    $lname = $conn->real_escape_string($_POST['lname']);  // Last Name
    $email = $conn->real_escape_string($_POST['email']);  // Email
// Retrieving range inputs (1-10 scale ratings)
    $overall_rating = $conn->real_escape_string($_POST['overall_rating']);  // Overall Satisfaction
    $design_rating = $conn->real_escape_string($_POST['design_rating']);    // Design Rating
    $usability_rating = $conn->real_escape_string($_POST['usability_rating']);  // Usability Rating
    $performance_rating = $conn->real_escape_string($_POST['performance_rating']);  // Performance Rating
    $content_rating = $conn->real_escape_string($_POST['content_rating']);  // Content Relevance Rating
    $recommendation_rate = $conn->real_escape_string($_POST['recommendation_rate']);  // Recommendation (NPS) score
// Retrieving open-ended questions
    $positive_feedback = $conn->real_escape_string($_POST['positive_feedback']);  // Positive Feedback
    $improvements = $conn->real_escape_string($_POST['improvements']);  // Suggested Improvements
    $missing_info = $conn->real_escape_string($_POST['missing_info']);  // Missing Information
// Retrieving multiple-choice questions
    $navigation_difficulty = $conn->real_escape_string($_POST['navigation_difficulty']);  // Navigation Ease
    $visit_reason = $conn->real_escape_string($_POST['visit_reason']);  // Reason for Visiting
    $website_discovery = $conn->real_escape_string($_POST['website_discovery']);  // How They Found the Website
// Retrieving usability & functionality questions
    $functionality_issue = $conn->real_escape_string($_POST['functionality_issue']);  // Site Functionality Issues
    $loading_speed = $conn->real_escape_string($_POST['loading_speed']);  // Website Loading Speed
// Retrieving additional feedback
    $additional_comments = $conn->real_escape_string($_POST['additional_comments']);  // Additional Comments
// Retrieving consent for follow-up
    $follow_up = $conn->real_escape_string($_POST['follow_up']);  // Follow-up Consent
// Retrieving hidden fields (User ID, Role)
    $userid = $conn->real_escape_string($_POST['userid']);  // User ID
    $role = $conn->real_escape_string($_POST['role']);  // Role

    $sql = "INSERT INTO user_feedback (USERID,ROLE,FNAME,LNAME,EMAIL,OVERALL_RATING,DESIGN_RATING,USABILITY_RATING,PERFORMANCE_RATING,CONTENT_RATING,RECOMMENDATION_RATE,POSITIVE_FEEDBACK,IMPROVEMENTS,MISSING_INFO,NAV_DIFFICULTY,VISIT_REASON,WEB_DISCOVERY,FUNCTIONALITY_ISSUE,LOADING_SPEED,ADDITIONAL_COMMENTS,FOLLOW_UP,SUBMISSION_DATE)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssss", $userid, $role, $fname, $lname, $email, $overall_rating, $design_rating, $usability_rating, $performance_rating, $content_rating, $recommendation_rate, $positive_feedback, $improvements, $missing_info, $navigation_difficulty, $visit_reason, $website_discovery, $functionality_issue, $loading_speed, $additional_comments, $follow_up, $submission_date);

    if ($stmt->execute() === TRUE) {
        $_SESSION['success_message'] = "Feedback Sent Successfully!";

        if ($_SESSION['loggedin']) {
            header("Location: index_patient.php");
        }else{
            header("Location: index_guess.php");
        }

    } else {
        $_SESSION['error_message'] = "There was an issue with the sending feedback. Please try again.";

        if ($_SESSION['loggedin']) {
            header("Location: index_patient.php");
        }else{
            header("Location: index_guess.php");
        }

    }
    $stmt->close();
    $conn->close();
    echo $userid;
    echo $role;


} else {
    echo "No form data submitted.";
}






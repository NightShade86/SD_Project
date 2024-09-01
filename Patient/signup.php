<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "localhost";
    $username = "root"; 
    $password = "root"; 
    $dbname = "dtcmsdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $no_tel = $conn->real_escape_string($_POST['no_tel']);
    $email = $conn->real_escape_string($_POST['email']);
    $ic = $conn->real_escape_string($_POST['ic']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $pass = $conn->real_escape_string($_POST['password']);

    

    
    

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Set user type to 'patient'
    $usertype = '2'; //assume 2 as patient

    // Insert user data into the database
    $sql = "INSERT INTO user_info (FIRSTNAME, LASTNAME, NO_TEL, EMAIL, IC, USER_ID, PASSWORD, USERTYPE) 
            VALUES ('$firstname', '$lastname', '$no_tel', '$email', '$ic', '$user_id', '$hashed_password', '$usertype')";

    if ($conn->query($sql) === TRUE) {
			header("Location:index_patient.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

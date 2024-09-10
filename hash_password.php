<?php
    // The password you want to hash
    $password = "Fohoxe@1";

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Output the hashed password
    echo $hashedPassword;
?>

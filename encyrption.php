<?php
// Encryption and Decryption Configuration
define('ENCRYPTION_METHOD', 'AES-256-CBC'); // Encryption method
define('SECRET_KEY', 'my_secret_key');      // Secret key
define('SECRET_IV', 'my_secret_iv');        // Secret initialization vector

// Encrypt function
function encryptPassword($password) {
    $key = hash('sha256', SECRET_KEY); // Generate a 256-bit key
    $iv = substr(hash('sha256', SECRET_IV), 0, 16); // Generate a 128-bit IV

    // Encrypt the password
    $encrypted = openssl_encrypt($password, ENCRYPTION_METHOD, $key, 0, $iv);
    return base64_encode($encrypted); // Encode in base64 to store in the database
}

// Decrypt function
function decryptPassword($encryptedPassword) {
    $key = hash('sha256', SECRET_KEY); // Generate a 256-bit key
    $iv = substr(hash('sha256', SECRET_IV), 0, 16); // Generate a 128-bit IV

    // Decrypt the password
    $decrypted = openssl_decrypt(base64_decode($encryptedPassword), ENCRYPTION_METHOD, $key, 0, $iv);
    return $decrypted;
}

// Example usage
$originalPassword = '12354';
echo "Original Password: " . $originalPassword . "\n";

// Encrypt the password
$encryptedPassword = encryptPassword($originalPassword);
echo "Encrypted Password: " . $encryptedPassword . "\n";

// Decrypt the password
$decryptedPassword = decryptPassword($encryptedPassword);
echo "Decrypted Password: " . $decryptedPassword . "\n";
?>
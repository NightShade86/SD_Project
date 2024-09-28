<?php
session_start();

// Check if there's a message to display
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type']; // 'success' or 'error'
    $token = isset($_SESSION['token']) ? $_SESSION['token'] : null;

    // Unset the session message after it's displayed
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
} else {
    $message = null;
    $message_type = null;
    $token = null;
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>

    <!-- Include Bootstrap and custom styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Custom styles for SweetAlert to match your project's fonts */
        .swal2-popup {
            font-family: inherit; /* Inherits the font from your page */
        }
    </style>
</head>
<body>

<script>
    <?php if ($message): ?>
    Swal.fire({
        title: '<?php echo ($message_type == 'success') ? 'Success' : 'Error'; ?>',
        text: '<?php echo $message; ?>',
        icon: '<?php echo $message_type; ?>', // success or error
    }).then(function() {
        <?php if ($message_type == 'success'): ?>
            // On success, redirect to the login page
            window.location.href = 'login_guess.php';
        <?php else: ?>
            // On error, redirect back to the reset password form
            window.location.href = 'reset_password.php?token=<?php echo $token; ?>';
        <?php endif; ?>
    });
    <?php endif; ?>
</script>

</body>
</html>

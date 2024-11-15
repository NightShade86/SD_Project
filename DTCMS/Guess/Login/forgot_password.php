<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
		body {
	  font-family: Arial, sans-serif;
	  background-color: #f4f4f4;
	  margin: 20px;
	}

	h1 {
	  text-align: center;
	  color: #333;
	  font-weight: bold;
	  margin-bottom: 20px;
	}

	.instructions {
	  font-size: 0.9em;
	  color: #666;
	  margin-bottom: 20px;
	  text-align: center;
	}

	form {
	  background-color: #fff;
	  padding: 30px;
	  border-radius: 10px;
	  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	  max-width: 400px;
	  width: 100%;
	  box-sizing: border-box;
	  margin: 0 auto;
	}

	label {
	  display: block;
	  font-size: 1.1em;
	  color: #333;
	  margin-bottom: 8px;
	}

	input[type="email"] {
	  width: 100%;
	  padding: 12px;
	  margin-bottom: 20px;
	  border: 1px solid #ccc;
	  border-radius: 5px;
	  font-size: 1em;
	  box-sizing: border-box;
	  transition: border-color 0.3s;
	}

	input[type="email"]:focus {
	  border-color: #007BFF;
	  box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
	}

	button {
	  background-color: #007BFF;
	  color: #fff;
	  padding: 12px 20px;
	  border: none;
	  border-radius: 5px;
	  font-size: 1em;
	  cursor: pointer;
	  width: 100%;
	  transition: background-color 0.3s;
	}

	button:hover {
	  background-color: #0056b3;
	}

	@media (max-width: 768px) {
	  form {
		padding: 20px;
	  }

	  button {
		font-size: 0.9em;
	  }
	}

    </style>
</head>
<body>

    <h1>Forgot Password</h1>

    <form method="post" action="send_reset_password.php">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <button>Send</button>

    </form>

    <div class="instructions">
        <p>Enter your email address and click "Send" to receive a password reset link.</p>
        <p>Follow the instructions in the email to reset your password.</p>
    </div>

</body>
</html>

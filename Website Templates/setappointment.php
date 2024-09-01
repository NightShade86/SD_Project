<?php

// Define some constants
define( "RECIPIENT_NAME", "John Doe" );
define( "RECIPIENT_EMAIL", "youremail@mail.com" );


// Read the form values
$success = false;
$senderName = isset( $_POST['username'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['username'] ) : "";
$senderPhone = isset( $_POST['phone'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone'] ) : "";
$senderEmail = isset( $_POST['email'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email'] ) : "";
$senderVehicle = isset( $_POST['vehicle'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['vehicle'] ) : "";
$senderDate = isset( $_POST['date'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['date'] ) : "";
$senderTime = isset( $_POST['time'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['time'] ) : "";
$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";

// If all values exist, send the email
if ( $senderName && $senderEmail && $senderPhone && $senderVehicle && $senderDate && $senderTime && $message) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $senderName . "";
  $msgBody = " Email: ". $senderEmail.  "\n Phone: ". $senderPhone . "\n vehicle: ". $senderVehicle . "\n date: ". $senderDate ."\n time: ". $senderTime .  "\n Message: " . $message . "";
  $success = mail( $recipient, $headers, $msgBody );

  echo "<script>alert('Your message has been sucessfully submitted Thanks. 🙂');</script>";
  echo "<script>document.location.href='index.html'</script>";
}

else{
  echo "<script>alert('Mail was not Send');</script>";
  echo "<script>document.location.href='contact.html'</script>";
}

?>
<?php
$to = "pranjalsaxena597@gmail.com";
$subject = "Test Email";
$message = "This is a test email.";

// Additional headers
$headers = "From: irrs.ticket@gmail.com\r\n";
$headers .= "Reply-To: irrs.ticket@gmail.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Sending email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?>

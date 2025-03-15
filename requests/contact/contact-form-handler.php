<?php
// Include Composer's autoloader
require 'vendor/autoload.php';

// Include the email templates
include 'admin-email-template.php';
include 'auto-reply-template.php';

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Replace placeholders with the actual values
    $adminEmailBody = str_replace(
        ['{name}', '{email}', '{message}'],
        [$name, $email, nl2br($message)],
        $html 
    );

    $userEmailBody = str_replace(
        ['{name}', '{message}'],
        [$name, nl2br($message)],
        $html // auto-reply-template.php content
    );

    // Create a new PHPMailer instance for the admin email
    $mail = new PHPMailer(true);
    try {
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Your email
        $mail->Password = 'your-email-password'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set email sender and recipient
        $mail->setFrom('your-email@example.com', 'Your Company Name');
        $mail->addAddress('admin@example.com', 'Admin'); // Admin email
        $mail->addReplyTo($email, $name);

        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Subject = "New message from $name";
        $mail->Body = $adminEmailBody; // Admin email content

        // Send the admin email
        $mail->send();

        // Create a new PHPMailer instance for the auto-reply
        $mailAutoReply = new PHPMailer(true);
        $mailAutoReply->isSMTP();
        $mailAutoReply->Host = 'smtp.example.com';
        $mailAutoReply->SMTPAuth = true;
        $mailAutoReply->Username = 'your-email@example.com';
        $mailAutoReply->Password = 'your-email-password';
        $mailAutoReply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailAutoReply->Port = 587;

        // Set the auto-reply email sender and recipient
        $mailAutoReply->setFrom('your-email@example.com', 'Your Company Name');
        $mailAutoReply->addAddress($email, $name); // Sender's email

        // Set email format to HTML
        $mailAutoReply->isHTML(true);
        $mailAutoReply->Subject = "Thank you for contacting us!";
        $mailAutoReply->Body = $userEmailBody; // Auto-reply email content

        // Send the auto-reply
        $mailAutoReply->send();

        // Redirect to a thank-you page (optional)
        header("Location: thank-you.html");
        exit();

    } catch (Exception $e) {
        // Handle errors (e.g., failed email sending)
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

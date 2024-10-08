<?php
// process_contact.php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize data
    $name = mysqli_real_escape_string($conn, trim($_POST['contact_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['contact_email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['contact_message']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Handle error
        echo "Please fill in all required fields.";
        exit;
    }

    // You can store the message in the database or send an email
    // For this example, we'll send an email to your support email

    $to = "info@yourhandymanservice.com"; // Replace with your email
    $headers = "From: " . $email . "\r\n";
    $full_message = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

    if (mail($to, $subject, $full_message, $headers)) {
        echo "<script>alert('Your message has been sent successfully.'); window.location.href = 'contact.php';</script>";
    } else {
        echo "There was an error sending your message. Please try again later.";
    }
}
?>

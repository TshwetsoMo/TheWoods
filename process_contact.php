<?php
// process_contact.php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize data
    $FullName = trim($_POST['FullName']);
    $Email = trim($_POST['Email']);
    $Phone = trim($_POST['Phone']);
    $Subject = trim($_POST['Subject']);
    $Message = trim($_POST['Message']);

    // Validate required fields
    if (empty($FullName) || empty($Email) || empty($Message)) {
        // Handle error
        echo "Please fill in all required fields.";
        exit;
    }

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Optional fields handling
    $Phone = !empty($Phone) ? $Phone : NULL;
    $Subject = !empty($Subject) ? $Subject : NULL;

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_messages (FullName, Email, Phone, Subject, Message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $FullName, $Email, $Phone, $Subject, $Message);

    if ($stmt->execute()) {
        // Success message
        echo "<script>alert('Your message has been sent successfully.'); window.location.href = 'contact.php';</script>";
    } else {
        // Handle error
        echo "Error inserting message: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

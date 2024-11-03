<?php
// process_booking.php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize data
    $FullName = trim($_POST['FullName']);
    $Email = trim($_POST['Email']);
    $Phone = trim($_POST['Phone']);
    $Address = trim($_POST['Address']);
    $ServiceID = intval($_POST['ServiceID']);
    $PreferredDateTime = $_POST['PreferredDateTime'];
    $Message = trim($_POST['Message']);

    // Validate required fields
    if (empty($FullName) || empty($Email) || empty($Phone) || empty($Address) || empty($ServiceID) || empty($PreferredDateTime)) {
        // Handle error
        echo "Please fill in all required fields.";
        exit;
    }

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Validate PreferredDateTime is in the future
    if (strtotime($PreferredDateTime) <= time()) {
        echo "Preferred Date & Time must be in the future.";
        exit;
    }

    // Check if customer exists
    $stmt = $conn->prepare("SELECT CustomerID FROM customers WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Customer exists
        $row = $result->fetch_assoc();
        $CustomerID = $row['CustomerID'];
    } else {
        // Insert new customer
        $stmt = $conn->prepare("INSERT INTO customers (FullName, Email, Phone, Address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $FullName, $Email, $Phone, $Address);
        if ($stmt->execute()) {
            $CustomerID = $conn->insert_id;
        } else {
            // Handle error
            echo "Error inserting customer: " . $stmt->error;
            exit;
        }
    }

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (CustomerID, ServiceID, PreferredDateTime, Message, Status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("iiss", $CustomerID, $ServiceID, $PreferredDateTime, $Message);
    if ($stmt->execute()) {
        $BookingID = $conn->insert_id;
        // Success message
        echo "<script>alert('Booking successful! Your booking ID is " . $BookingID . "'); window.location.href = 'contact.php';</script>";
    } else {
        // Handle error
        echo "Error inserting booking: " . $stmt->error;
        exit;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

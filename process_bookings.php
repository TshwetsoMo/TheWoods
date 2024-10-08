<?php
// process_booking.php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize data
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $service_needed = mysqli_real_escape_string($conn, $_POST['service']);
    $preferred_datetime = mysqli_real_escape_string($conn, $_POST['preferred_datetime']);
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($service_needed) || empty($preferred_datetime)) {
        // Handle error
        echo "Please fill in all required fields.";
        exit;
    }

    // Check if customer exists
    $sql = "SELECT CustomerID FROM Customers WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Customer exists
        $row = $result->fetch_assoc();
        $customer_id = $row['CustomerID'];
    } else {
        // Insert new customer
        $sql = "INSERT INTO Customers (FullName, Email, Phone, Address) VALUES ('$name', '$email', '$phone', '$address')";
        if ($conn->query($sql) === TRUE) {
            $customer_id = $conn->insert_id;
        } else {
            // Handle error
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }
    }

    // Insert booking
    $sql = "INSERT INTO Bookings (CustomerID, ServiceID, PreferredDateTime, Message) VALUES ('$customer_id', '$service_needed', '$preferred_datetime', '$message')";
    if ($conn->query($sql) === TRUE) {
        $booking_id = $conn->insert_id;
        // Success message
        echo "<script>alert('Booking successful! Your booking ID is " . $booking_id . "'); window.location.href = 'contact.php';</script>";
    } else {
        // Handle error
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit;
    }
}
?>

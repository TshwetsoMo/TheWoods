<?php
// config.php

// Directly set your database credentials
$servername = "localhost";          // Replace with your database host
$username = "tkmthel6n3h7_Mowetshot";        // Replace with your database username
$password = "TKM0kg4t1h3";        // Replace with your database password
$dbname = "tkmthel6n8h7_handyman_service_db";    // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

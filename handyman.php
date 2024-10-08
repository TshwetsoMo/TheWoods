<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'tga');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
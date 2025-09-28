<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erp_db";

// First connect without database to create it if needed
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select the database
$conn->select_db($dbname);

// Create customers table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS customers (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(10) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    contact_number VARCHAR(20),
    district VARCHAR(50),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Add email column if it doesn't exist (for existing tables)
$check_column = "SHOW COLUMNS FROM customers LIKE 'email'";
$result = $conn->query($check_column);
if ($result->num_rows == 0) {
    $add_email = "ALTER TABLE customers ADD COLUMN email VARCHAR(100) AFTER district";
    $conn->query($add_email);
}
?>

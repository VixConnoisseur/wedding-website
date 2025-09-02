<?php
// db.php - Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Change if your MySQL root has a password
$dbname = "wedding_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// ✅ Set charset to avoid encoding issues
$conn->set_charset("utf8mb4");
?>

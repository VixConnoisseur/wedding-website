<?php
// Run once then delete for security
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'wedding_db';
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) { die('Connection failed: '.$conn->connect_error); }
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die($conn->error);
$conn->select_db($dbname);
$conn->query("CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password VARCHAR(255) NOT NULL)") or die($conn->error);
$conn->query("CREATE TABLE IF NOT EXISTS responses (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), attendance VARCHAR(10), guests INT DEFAULT 1, message TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)") or die($conn->error);
// insert default admin if not exists
$default_email = 'admin@wedding.com';
$default_pass = 'password123';
$hash = password_hash($default_pass, PASSWORD_DEFAULT);
$stmt = $conn->prepare('SELECT id FROM admins WHERE email = ?');
$stmt->bind_param('s', $default_email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    $ins = $conn->prepare('INSERT INTO admins (email, password) VALUES (?, ?)');
    $ins->bind_param('ss', $default_email, $hash);
    $ins->execute();
    $ins->close();
    echo 'Default admin created: '.$default_email.' / '.$default_pass.'<br>';
} else {
    echo 'Default admin already exists.<br>';
}
$stmt->close();
$conn->close();
echo 'Setup complete. Remove db_setup.php for security.';
?>
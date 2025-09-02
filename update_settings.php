<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['admin_id'];
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($email) {
    $stmt = $conn->prepare("UPDATE admins SET email=? WHERE id=?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
}

if ($password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE admins SET password=? WHERE id=?");
    $stmt->bind_param("si", $hashed, $id);
    $stmt->execute();
}

header("Location: dashboard.php?page=settings&success=1");
exit;

<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $attendance = trim($_POST['attendance']);
    $guests = isset($_POST['guests']) ? intval($_POST['guests']) : 1;
    $message = trim($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO responses (name, email, attendance, guests, message) VALUES (?, ?, ?, ?, ?)") or die($conn->error);
    $stmt->bind_param('sssds', $name, $email, $attendance, $guests, $message);
    if ($stmt->execute()) {
        echo "<p style='text-align:center;margin-top:20px;'>Thank you, $name — your RSVP has been recorded. <a href='index.php'>Back to home</a></p>";
    } else {
        echo "<p style='text-align:center;margin-top:20px;color:red;'>Error saving RSVP: " . htmlspecialchars($stmt->error) . "</p>";
    }
    $stmt->close();
} else {
    header('Location: index.php');
}
?>
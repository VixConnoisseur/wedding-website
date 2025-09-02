<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            header("Location: dashboard.php"); // Change to your admin panel
            exit;
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "⚠️ No account found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-900 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border-4 border-red-800">
    <h1 class="text-4xl text-red-900 text-center mb-6">🌸 Admin Login 🌸</h1>

    <?php if (isset($error)): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="email" name="email" placeholder="Email"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-700" required>
      <input type="password" name="password" placeholder="Password"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-700" required>
      <button type="submit" class="w-full bg-red-700 text-white py-2 rounded-lg hover:bg-red-800 transition">
        Login
      </button>
    </form>

    <p class="mt-4 text-sm text-gray-600 text-center">
      No account? <a href="register.php" class="text-red-700 font-semibold">Register</a>
    </p>
  </div>
</body>
</html>

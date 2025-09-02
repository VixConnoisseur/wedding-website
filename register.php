<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "⚠️ Email already exists.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
            $success = "✅ Admin registered successfully!";
        } else {
            $error = "❌ Error: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-900 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border-4 border-red-800">
    <h1 class="text-4xl text-red-900 text-center mb-6">🌸 Admin Register 🌸</h1>

    <?php if (isset($success)): ?>
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg text-center"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="email" name="email" placeholder="Email"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-700" required>
      <input type="password" name="password" placeholder="Password"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-700" required>
      <button type="submit" class="w-full bg-red-700 text-white py-2 rounded-lg hover:bg-red-800 transition">
        Register
      </button>
    </form>

    <p class="mt-4 text-sm text-gray-600 text-center">
      Already registered? <a href="login.php" class="text-red-700 font-semibold">Login</a>
    </p>
  </div>
</body>
</html>

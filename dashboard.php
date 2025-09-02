<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Sidebar navigation
$page = isset($_GET['page']) ? $_GET['page'] : 'rsvps';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Jennifer & Arvin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Playfair Display', serif; }
    h1, h2 { font-family: 'Great Vibes', cursive; }
  </style>
</head>
<body class="bg-red-50 flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-red-800 text-white flex flex-col p-6 space-y-6">
    <h1 class="text-3xl mb-6">🌸 Admin</h1>
    <nav class="flex flex-col space-y-4">
      <a href="?page=rsvps" class="hover:bg-red-700 p-2 rounded">📋 RSVPs</a>
      <a href="?page=admins" class="hover:bg-red-700 p-2 rounded">👥 Manage Admins</a>
      <a href="?page=settings" class="hover:bg-red-700 p-2 rounded">⚙️ Settings</a>
      <a href="?logout=true" class="hover:bg-red-700 p-2 rounded">🚪 Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <?php if ($page == "rsvps"): ?>
      <!-- RSVPs -->
      <h2 class="text-2xl text-red-900 mb-4">Guest RSVPs</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
          <thead class="bg-red-700 text-white">
            <tr>
              <th class="py-2 px-4">Name</th>
              <th class="py-2 px-4">Email</th>
              <th class="py-2 px-4">Attending</th>
              <th class="py-2 px-4">Message</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $conn->query("SELECT name, email, attending, message FROM rsvps");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr class="border-b hover:bg-red-100 transition">
              <td class="py-2 px-4"><?= htmlspecialchars($row['name']) ?></td>
              <td class="py-2 px-4"><?= htmlspecialchars($row['email']) ?></td>
              <td class="py-2 px-4"><?= $row['attending'] == 1 ? "✅ Yes" : "❌ No" ?></td>
              <td class="py-2 px-4"><?= htmlspecialchars($row['message']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    <?php elseif ($page == "admins"): ?>
      <!-- Manage Admins -->
      <h2 class="text-2xl text-red-900 mb-4">Manage Admin Accounts</h2>
      <div class="bg-white shadow-md rounded-lg p-4">
        <?php
        $admins = $conn->query("SELECT id, email FROM admins");
        ?>
        <table class="min-w-full">
          <thead class="bg-red-700 text-white">
            <tr>
              <th class="py-2 px-4">ID</th>
              <th class="py-2 px-4">Email</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($a = $admins->fetch_assoc()): ?>
              <tr class="border-b hover:bg-red-100">
                <td class="py-2 px-4"><?= $a['id'] ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($a['email']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <p class="mt-4 text-gray-700">Admins can only be added through <b>Register Page</b>.</p>

    <?php elseif ($page == "settings"): ?>
      <!-- Settings -->
      <h2 class="text-2xl text-red-900 mb-4">⚙️ Account Settings</h2>
      <form method="POST" action="update_settings.php" class="bg-white p-6 rounded-lg shadow-md space-y-4 max-w-md">
        <input type="email" name="email" placeholder="New Email"
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-700">
        <input type="password" name="password" placeholder="New Password"
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-700">
        <button type="submit"
                class="w-full bg-red-700 text-white py-2 rounded-lg hover:bg-red-800 transition">
          Update Settings
        </button>
      </form>
    <?php endif; ?>
  </main>
</body>
</html>

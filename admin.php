<?php
session_start();
require 'db.php';

// ✅ Protect dashboard
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch RSVPs
$rsvps = [];
$result = $conn->query("SELECT id, name, email, guests, message, created_at FROM rsvps ORDER BY created_at DESC");
if ($result) {
    $rsvps = $result->fetch_all(MYSQLI_ASSOC);
}
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
    h1 { font-family: 'Great Vibes', cursive; }
</style>
</head>
<body class="bg-red-900 min-h-screen text-gray-900">

<!-- Header -->
<header class="bg-red-800 p-6 shadow-md flex justify-between items-center">
    <h1 class="text-white text-4xl">🌸 Wedding Admin Dashboard 🌸</h1>
    <a href="logout.php" class="bg-white text-red-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition">Logout</a>
</header>

<!-- Main Content -->
<main class="p-8">
    <h2 class="text-2xl text-white mb-6">RSVP List</h2>

    <div class="bg-white shadow-lg rounded-2xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-red-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Guests</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Message</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Date Submitted</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (count($rsvps) > 0): ?>
                    <?php foreach($rsvps as $rsvp): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= $rsvp['id'] ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rsvp['name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rsvp['email']) ?></td>
                            <td class="px-6 py-4"><?= $rsvp['guests'] ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rsvp['message']) ?></td>
                            <td class="px-6 py-4"><?= $rsvp['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No RSVPs yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Search & Filter (interactive) -->
<script>
    // Simple search filter for table
    const searchInput = document.createElement('input');
    searchInput.setAttribute('placeholder', 'Search RSVPs...');
    searchInput.className = 'mb-4 p-2 rounded-lg border w-full max-w-sm';
    document.querySelector('main').prepend(searchInput);

    searchInput.addEventListener('keyup', () => {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
</body>
</html>

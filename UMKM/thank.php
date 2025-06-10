<?php
$orderId = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Terima Kasih</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow text-center max-w-lg">
    <h1 class="text-3xl font-bold text-green-600 mb-4">Pesanan Berhasil!</h1>
    <p class="text-gray-700 mb-6">Terima kasih telah melakukan pemesanan. ID Pesanan Anda: <strong>#<?= htmlspecialchars($orderId) ?></strong></p>
    <a href="index.php" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Kembali ke Beranda</a>
  </div>
</body>
</html>

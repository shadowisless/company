  <?php
  session_start();
  require 'db.php';

  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-red-500'>ID produk tidak valid.</p>";
    exit;
  }

  $productId = $_GET['id'];

  $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
  $stmt->bind_param("i", $productId);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();

  // Cek apakah produk ditemukan
  if (!$product) {
    echo "<p class='text-red-500'>Produk tidak ditemukan.</p>";
    exit;
  }
  ?>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['nama']) ?> | Detail Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 text-gray-800">
    <div class="max-w-6xl mx-auto px-4 py-6">
      
      <!-- Breadcrumb -->
      <nav class="text-sm text-gray-500 mb-4">
        <a href="index.php" class="hover:underline">Beranda</a> &gt;
        <span class="text-gray-700"><?= htmlspecialchars($product['nama']) ?></span>
      </nav>

      <!-- Card Utama -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 flex flex-col md:flex-row">
        
        <!-- Gambar Produk -->
        <div class="md:w-1/2 mb-4 md:mb-0">
          <div class="relative group">
            <img src="assets/images/<?= htmlspecialchars($product['gambar']) ?>" alt="<?= htmlspecialchars($product['nama']) ?>" class="w-full h-auto rounded-lg transition-transform duration-300 group-hover:scale-105">
            <?php if ($product['stok'] == 0): ?>
              <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">Stok Habis</span>
            <?php elseif ($product['promo'] ?? false): ?>
              <span class="absolute top-2 left-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">Promo</span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Informasi Produk -->
        <div class="md:w-1/2 md:pl-8">
          <div class="flex justify-between items-start">
            <h1 class="text-2xl font-bold mb-2"><?= htmlspecialchars($product['nama']) ?></h1>
            <button class="text-gray-400 hover:text-red-500 transition" title="Tambah ke Favorit">❤️</button>
          </div>

          <div class="text-blue-600 text-2xl font-semibold mb-3">
            Rp<?= number_format($product['harga'], 0, ',', '.') ?>
          </div>

          <div class="text-sm text-gray-600 mb-1">Kategori: <?= htmlspecialchars($product['kategori'] ?? 'Tidak ada') ?></div>
          <div class="text-sm text-gray-600 mb-1">Gender: <?= ucfirst($product['gender']) ?></div>
          <div class="text-sm text-gray-600 mb-4">Stok: <?= $product['stok'] ?></div>
          <div class="text-sm text-gray-700 mb-6">
            <?= nl2br(htmlspecialchars($product['deskripsi'] ?? 'Tidak ada deskripsi.')) ?>
          </div>

          <!-- Form Pembelian -->
          <?php if ($product['stok'] > 0): ?>
            <form method="post" action="shoppingcart.php">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <label class="block text-sm mb-1">Jumlah</label>
              <input type="number" name="quantity" value="1" min="1" max="<?= $product['stok'] ?>" class="w-24 px-3 py-2 border rounded mb-4" required>
              <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition w-full md:w-auto">+ Tambah ke Keranjang</button>
            </form>
          <?php else: ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">Stok produk ini sedang habis.</div>
            <button disabled class="bg-gray-400 text-white px-6 py-2 rounded cursor-not-allowed w-full md:w-auto">Stok Habis</button>
          <?php endif; ?>
        </div>
      </div>

      <!-- Produk Terkait (dummy, bisa pakai query nanti) -->
      <?php
// Ambil kategori produk sekarang
$kategori = $product['kategori'] ?? '';

// Query produk terkait berdasarkan kategori yang sama, kecuali produk yang sedang dibuka
$stmtRelated = $conn->prepare("SELECT * FROM produk WHERE kategori = ? AND id != ? ORDER BY RAND() LIMIT 4");
$stmtRelated->bind_param("si", $kategori, $productId);
$stmtRelated->execute();
$resultRelated = $stmtRelated->get_result();
?>

<div class="mt-12">
  <h2 class="text-2xl font-bold mb-6 text-gray-800">Produk Terkait</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
    <?php if ($resultRelated->num_rows > 0): ?>
      <?php while ($related = $resultRelated->fetch_assoc()): ?>
        <a href="detail_produk.php?id=<?= $related['id'] ?>" class="group bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
          <div class="relative">
            <img src="assets/images/<?= htmlspecialchars($related['gambar']) ?>" alt="<?= htmlspecialchars($related['nama']) ?>" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
            <?php if ($related['stok'] == 0): ?>
              <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">Stok Habis</span>
            <?php elseif ($related['promo'] ?? false): ?>
              <span class="absolute top-2 left-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">Promo</span>
            <?php endif; ?>
          </div>
          <div class="p-4">
            <h3 class="text-sm font-semibold text-gray-800 mb-1 group-hover:text-blue-600 transition"><?= htmlspecialchars($related['nama']) ?></h3>
            <p class="text-blue-600 font-bold text-sm">Rp<?= number_format($related['harga'], 0, ',', '.') ?></p>
          </div>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-gray-500 col-span-full">Tidak ada produk terkait.</p>
    <?php endif; ?>
  </div>
</div>


    </div>
  </body>
  </html>

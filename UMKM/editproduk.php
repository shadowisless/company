<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID produk tidak ditemukan.";
    header("Location: admin.php");
    exit();
}

$id = (int)$_GET['id'];
$produk = $conn->query("SELECT * FROM produk WHERE id = $id")->fetch_assoc();

if (!$produk) {
    $_SESSION['error'] = "Produk tidak ditemukan.";
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-2xl bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Produk</h2>

    <form action="prosesedit.php" method="POST" enctype="multipart/form-data" class="space-y-5">
      <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($produk['nama']); ?>" required
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
          <input type="number" name="harga" value="<?php echo $produk['harga']; ?>" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
          <input type="number" name="stok" value="<?php echo $produk['stok']; ?>" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
          <select name="gender" required
                  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="pria" <?php echo $produk['gender'] == 'pria' ? 'selected' : ''; ?>>Pria</option>
            <option value="wanita" <?php echo $produk['gender'] == 'wanita' ? 'selected' : ''; ?>>Wanita</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
          <select name="kategori" required
                  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="pakaian" <?php echo $produk['kategori'] == 'pakaian' ? 'selected' : ''; ?>>Pakaian</option>
            <option value="aksesoris" <?php echo $produk['kategori'] == 'aksesoris' ? 'selected' : ''; ?>>Aksesoris</option>
            <option value="lainlain" <?php echo $produk['kategori'] == 'lainlain' ? 'selected' : ''; ?>>Lain-lain</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Saat Ini</label>
        <img src="assets/images/<?php echo $produk['gambar']; ?>" alt="Gambar Produk" class="h-24 object-cover rounded border mb-2" />
        <input type="file" name="gambar" accept="image/*"
               class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm text-gray-600 bg-white file:border-0 file:bg-blue-100 file:text-blue-700" />
      </div>

      <div class="text-center">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition duration-200">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</body>
</html>

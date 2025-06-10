<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "db.php";

$where = [];
if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where[] = "nama LIKE '%$search%'";
}
if (!empty($_GET['kategori'])) {
    $kategori = $conn->real_escape_string($_GET['kategori']);
    $where[] = "kategori = '$kategori'";
}
if (!empty($_GET['gender'])) {
    $gender = $conn->real_escape_string($_GET['gender']);
    $where[] = "gender = '$gender'";
}
$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

// Sorting
$sortSQL = "";
if (!empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'harga_asc':
            $sortSQL = "ORDER BY harga ASC";
            break;
        case 'harga_desc':
            $sortSQL = "ORDER BY harga DESC";
            break;
        case 'nama_asc':
            $sortSQL = "ORDER BY nama ASC";
            break;
        case 'nama_desc':
            $sortSQL = "ORDER BY nama DESC";
            break;
    }
}

$totalPesanan = $conn->query("SELECT COUNT(*) as total FROM pesanan")->fetch_assoc()['total'];
$totalPendapatan = $conn->query("SELECT SUM(total) as total FROM pesanan")->fetch_assoc()['total'];
$pesananTerbaru = $conn->query("SELECT * FROM pesanan ORDER BY tanggal DESC LIMIT 5");

$limit = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalFiltered = $conn->query("SELECT COUNT(*) as total FROM produk $whereSQL")->fetch_assoc()['total'];
$totalPages = ceil($totalFiltered / $limit);

$produk = $conn->query("SELECT * FROM produk $whereSQL $sortSQL LIMIT $limit OFFSET $offset");

$totalProduk = $conn->query("SELECT COUNT(*) as total FROM produk")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  /* Notifikasi fade in/out */
  .notif {
    animation: fadeInOut 4s forwards;
  }
  @keyframes fadeInOut {
    0% {opacity: 0;}
    10% {opacity: 1;}
    90% {opacity: 1;}
    100% {opacity: 0;}
  }
</style>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php if (isset($_SESSION['msg'])): ?>
      <div class="notif bg-green-100 text-green-800 border border-green-300 p-3 rounded mb-4 mx-6">
        <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
      </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="notif bg-red-100 text-red-800 border border-red-300 p-3 rounded mb-4 mx-6">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

  <div class="flex min-h-screen">
    <aside class="w-64 bg-gradient-to-b from-blue-800 to-blue-600 text-white p-6 space-y-4">
      <h1 class="text-2xl font-bold mb-6">Admin UMKM</h1>
      <nav class="flex flex-col space-y-2 text-sm">
        <a href="dashboard.php" class="flex items-center gap-2 hover:text-yellow-300"><svg class="w-5 h-5" ...></svg> Dashboard</a>
        <a href="laporan.php" class="flex items-center gap-2 hover:text-yellow-300"><svg class="w-5 h-5" ...></svg> Laporan Pendapatan</a>
        <a href="index.php" class="flex items-center gap-2 hover:text-yellow-300"><svg class="w-5 h-5" ...></svg> Beranda</a>
        <a href="logout.php?role=admin" class="flex items-center gap-2 hover:text-red-300"><svg class="w-5 h-5" ...></svg> Logout</a>
      </nav>  
    </aside>

    <main class="flex-1 p-6 bg-gray-100">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded shadow text-center">
          <p class="text-sm text-gray-500">Total Produk</p>
          <p class="text-3xl font-bold text-blue-600"><?= $totalProduk ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
          <p class="text-sm text-gray-500">Total Pesanan</p>
          <p class="text-3xl font-bold text-green-600"><?= $totalPesanan ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
          <p class="text-sm text-gray-500">Total Pendapatan</p>
          <p class="text-3xl font-bold text-red-600">Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></p>
        </div>
      </div>

      <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
        <input type="text" name="search" placeholder="Cari nama produk..." value="<?= $_GET['search'] ?? '' ?>" class="w-full md:w-1/2 px-4 py-2 border rounded" />
        <select name="kategori" class="w-full md:w-1/4 px-4 py-2 border rounded">
          <option value="">Semua Kategori</option>
          <option value="pakaian" <?= ($_GET['kategori'] ?? '') == 'pakaian' ? 'selected' : '' ?>>Pakaian</option>
          <option value="aksesoris" <?= ($_GET['kategori'] ?? '') == 'aksesoris' ? 'selected' : '' ?>>Aksesoris</option>
          <option value="lainlain" <?= ($_GET['kategori'] ?? '') == 'lainlain' ? 'selected' : '' ?>>Lain-lain</option>
        </select>
        <select name="gender" class="w-full md:w-1/4 px-4 py-2 border rounded">
          <option value="">Semua Gender</option>
          <option value="pria" <?= ($_GET['gender'] ?? '') == 'pria' ? 'selected' : '' ?>>Pria</option>
          <option value="wanita" <?= ($_GET['gender'] ?? '') == 'wanita' ? 'selected' : '' ?>>Wanita</option>
        </select>
        <select name="sort" class="w-full md:w-1/4 px-4 py-2 border rounded">
          <option value="">Urutkan</option>
          <option value="harga_asc" <?= ($_GET['sort'] ?? '') == 'harga_asc' ? 'selected' : '' ?>>Harga Terendah</option>
          <option value="harga_desc" <?= ($_GET['sort'] ?? '') == 'harga_desc' ? 'selected' : '' ?>>Harga Tertinggi</option>
          <option value="nama_asc" <?= ($_GET['sort'] ?? '') == 'nama_asc' ? 'selected' : '' ?>>Nama A-Z</option>
          <option value="nama_desc" <?= ($_GET['sort'] ?? '') == 'nama_desc' ? 'selected' : '' ?>>Nama Z-A</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
      </form>
            <div class="mb-10">
              <h2 class="text-2xl font-semibold mb-4 text-blue-800">Tambah Produk</h2>
              <form action="proses_tambah.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="text" name="nama" placeholder="Nama Produk" required class="w-full px-4 py-2 border rounded" />
        <input type="number" name="harga" placeholder="Harga Produk" required class="w-full px-4 py-2 border rounded" />
        <select name="gender" required class="w-full px-4 py-2 border rounded">
          <option value="">Pilih Gender</option>
          <option value="pria">Pria</option>
          <option value="wanita">Wanita</option>
        </select>
        <select name="kategori" required class="w-full px-4 py-2 border rounded">
          <option value="">Pilih Kategori</option>
          <option value="aksesoris">Aksesoris</option>
          <option value="pakaian">Pakaian</option>
          <option value="lainlain">Lain-lain</option>
        </select>
        <input type="number" name="stok" placeholder="Stok Produk" required class="w-full px-4 py-2 border rounded" />
        <input type="file" name="gambar" accept="image/*" required class="w-full" />
        <textarea name="deskripsi" placeholder="Deskripsi Produk" required class="w-full md:col-span-2 px-4 py-2 border rounded"></textarea>
      </div>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Produk</button>
        </form>
      </div>

      <h2 class="text-2xl font-semibold mb-4 text-blue-800">Daftar Produk</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php while ($row = $produk->fetch_assoc()): ?>
          <div class="bg-white p-4 rounded shadow text-center transition-transform hover:scale-105 hover:shadow-lg">
            <img src="assets/images/<?php echo $row['gambar']; ?>" class="h-32 mx-auto mb-3 object-contain rounded" />
            <p class="font-semibold text-lg truncate"><?= htmlspecialchars($row['nama']) ?></p>
            <p class="text-blue-600 font-medium mb-1">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
            <p class="text-gray-600 mb-2">Stok: <?= $row['stok'] ?></p>

            <form action="update_harga.php" method="POST" class="mt-2 flex gap-2">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <input type="number" name="harga" value="<?= $row['harga'] ?>" class="border px-2 py-1 rounded w-full" min="0" />
              <button type="submit" class="bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500 transition">Ubah</button>
            </form>

            <a href="editproduk.php?id=<?= $row['id'] ?>" class="block mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">Edit</a>

            <form action="hapus_produk.php" method="POST" onsubmit="return confirm('Yakin ingin hapus?')" class="mt-2">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 w-full transition">Hapus</button>
            </form>
          </div>
        <?php endwhile; ?>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex justify-center items-center space-x-2">
        <?php if ($page > 1): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" class="px-3 py-1 border rounded bg-white text-blue-600 hover:bg-blue-100 transition">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
            class="px-3 py-1 rounded border <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?> transition">
            <?= $i ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" class="px-3 py-1 border rounded bg-white text-blue-600 hover:bg-blue-100 transition">Next</a>
        <?php endif; ?>
      </div>
    </main>
  </div>

  <script>
    const inputGambar = document.querySelector('input[name="gambar"]');
    const formTambah = inputGambar.closest('form');

    const previewContainer = document.createElement('div');
    previewContainer.classList.add('mb-4');
    formTambah.insertBefore(previewContainer, inputGambar);

    inputGambar.addEventListener('change', function() {
      previewContainer.innerHTML = '';
      const file = this.files[0];
      if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('h-32', 'object-contain', 'rounded', 'mx-auto');
        previewContainer.appendChild(img);
      }
    });
  setTimeout(() => {
    document.querySelectorAll('.notif').forEach(el => {
      el.style.opacity = 0;
      setTimeout(() => el.remove(), 500);
    });
  }, 3500);
  </script>
</body>
</html>

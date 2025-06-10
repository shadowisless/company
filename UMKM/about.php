<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang Kami - YourClothes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    .nav-link {
      position: relative;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 0;
      background-color: #3B82F6;
      transition: width 0.3s;
    }
    .nav-link:hover::after {
      width: 100%;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <header class="w-full shadow-md sticky top-0 bg-white z-50">
  <div class="container mx-auto px-4 flex justify-between items-center py-4">
    <div class="flex items-center space-x-2 text-2xl font-bold text-gray-800">
      <i class="fas fa-store text-blue-600"></i>
      <a href="index.php" class="hover:text-black-600 nav-link">
        <span>YourClothes</span>
      </a> <!-- ini sebelumnya belum ditutup -->
    </div>
    <nav class="hidden md:flex space-x-6 items-center">
      <a href="cart.php" class="hover:text-blue-600 nav-link">SHOPPING CART</a>
      <a href="checkout.php" class="hover:text-blue-600 nav-link">CHECKOUT</a>
      <a href="about.php" class="hover:text-blue-600 nav-link">ABOUT</a>
      <a href="kontak.php" class="hover:text-blue-600 nav-link">KONTAK</a>
      <a href="faq.php" class="hover:text-blue-600 nav-link">FAQ & ASK</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php?role=user" class="hover:text-red-600 font-semibold nav-link">LOGOUT</a>
      <?php else: ?>
        <a href="login.php" class="text-gray-600 hover:text-blue-600 transition inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </a>
      <?php endif; ?>
      <input type="search" id="searchInput" placeholder="Search..." class="px-2 py-1 border rounded ml-4 focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </nav>
    <div class="md:hidden flex items-center space-x-3">
      <button id="searchToggle" class="text-gray-600 hover:text-blue-600 focus:outline-none">
        <i class="fas fa-search text-xl"></i>
      </button>
      <button class="text-gray-600 focus:outline-none" id="menuToggle">
        <i class="fas fa-bars text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobileMenu" class="hidden flex flex-col bg-white mt-2 rounded-md shadow-md px-4 py-3 space-y-3">
    <a href="cart.php" class="hover:text-blue-600 nav-link">SHOPPING CART</a>
    <a href="checkout.php" class="hover:text-blue-600 nav-link">CHECKOUT</a>
    <a href="about.php" class="hover:text-blue-600 nav-link">ABOUT</a>
    <a href="kontak.php" class="hover:text-blue-600 nav-link">KONTAK</a>
    <a href="faq.php" class="hover:text-blue-600 nav-link">FAQ & ASK</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="logout.php?role=user" class="hover:text-red-600 font-semibold nav-link">LOGOUT</a>
    <?php else: ?>
      <a href="login.php" class="text-gray-600 hover:text-blue-600 transition inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </a>
    <?php endif; ?>
    <input type="search" id="mobileSearchInput" placeholder="Search..." class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 w-full" />
  </div>
</header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-16 shadow-md">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Tentang Kami</h1>
      <p class="text-lg md:text-xl max-w-2xl mx-auto">Kami adalah tim yang berkomitmen untuk mendukung pertumbuhan UMKM lokal melalui platform digital yang modern dan inklusif.</p>
    </div>
  </section>

  <!-- About Content -->
  <section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">
      <div>
        <img src="assets/images/images.jpg" alt="Tim Kami" class="rounded-2xl shadow-xl w-full object-cover">
      </div>
      <div>
        <h2 class="text-3xl font-bold text-indigo-600 mb-4">Siapa Kami?</h2>
        <p class="text-gray-700 mb-4 text-lg">Kami adalah platform e-commerce yang bertujuan membantu UMKM menjangkau pasar lebih luas. Didirikan oleh mahasiswa yang peduli terhadap ekonomi lokal, kami menyediakan sistem belanja online yang <strong>mudah, cepat, dan aman</strong>.</p>
        <p class="text-gray-700 text-lg">UMKM adalah tulang punggung perekonomian bangsa. Dengan digitalisasi, kami ingin menjadi jembatan menuju <strong>kesuksesan berkelanjutan</strong>.</p>
      </div>
    </div>
  </section>

  <!-- Nilai-Nilai -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold text-indigo-600 mb-8">Nilai-Nilai Kami</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-indigo-50 p-6 rounded-xl shadow-md hover:shadow-xl transition">
          <h3 class="text-xl font-semibold text-indigo-700 mb-2">Inovatif</h3>
          <p class="text-gray-700">Membawa solusi digital kreatif yang membantu UMKM berkembang secara efektif.</p>
        </div>
        <div class="bg-indigo-50 p-6 rounded-xl shadow-md hover:shadow-xl transition">
          <h3 class="text-xl font-semibold text-indigo-700 mb-2">Berkelanjutan</h3>
          <p class="text-gray-700">Fokus pada pengembangan jangka panjang dengan dampak positif untuk masyarakat lokal.</p>
        </div>
        <div class="bg-indigo-50 p-6 rounded-xl shadow-md hover:shadow-xl transition">
          <h3 class="text-xl font-semibold text-indigo-700 mb-2">Kolaboratif</h3>
          <p class="text-gray-700">Menjalin kemitraan dengan komunitas dan pemangku kepentingan secara aktif.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-6 text-center mt-10">
    <p class="text-sm">&copy; <?= date("Y") ?> CEPS. All rights reserved.</p>
  </footer>

  <!-- Mobile menu toggle script -->
  <script>
    const menuToggle = document.getElementById("menuToggle");
    const mobileMenu = document.getElementById("mobileMenu");

    menuToggle.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  </script>
</body>
</html>

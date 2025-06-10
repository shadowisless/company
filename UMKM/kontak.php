<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kontak - YourClothes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    .accordion-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease;
    }
    .accordion.open .accordion-content {
      max-height: 500px;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-blue-50 min-h-screen">

  <!-- Header Navigasi -->
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
  <!-- Konten Hubungi Kami -->
  <main class="mt-8 bg-white rounded-3xl shadow-2xl max-w-5xl mx-auto w-full p-8 md:p-10">
    <h1 class="text-4xl font-extrabold text-indigo-700 mb-10 text-center drop-shadow-md">Hubungi Kami</h1>
    
    <div class="flex flex-col md:flex-row gap-12">
      <!-- Info Kontak -->
      <section class="md:w-1/3 space-y-8">
        <div class="flex items-start space-x-4">
          <div class="text-indigo-600 text-3xl mt-1">
            <i class="fas fa-phone-alt" aria-hidden="true"></i>
          </div>
          <div>
            <h3 class="font-semibold text-lg text-gray-800">Telepon</h3>
            <p class="text-gray-600">+62 812 XXXX XXXX</p>
          </div>
        </div>

        <div class="flex items-start space-x-4">
          <div class="text-indigo-600 text-3xl mt-1">
            <i class="fas fa-envelope" aria-hidden="true"></i>
          </div>
          <div>
            <h3 class="font-semibold text-lg text-gray-800">Email</h3>
            <p class="text-gray-600">info@domainmu.com</p>
          </div>
        </div>

        <div class="flex items-start space-x-4">
          <div class="text-indigo-600 text-3xl mt-1">
            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
          </div>
          <div>
            <h3 class="font-semibold text-lg text-gray-800">Alamat</h3>
            <p class="text-gray-600">Jl. Merdeka No. 123, Jakarta</p>
          </div>
        </div>
      </section>

      <!-- Form Kontak -->
      <form class="md:w-2/3 space-y-6" action="#" method="POST" novalidate>
        <div>
          <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
          <input
            id="name"
            name="name"
            type="text"
            required
            placeholder="Masukkan nama Anda"
            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
          />
        </div>
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
          <input
            id="email"
            name="email"
            type="email"
            required
            placeholder="contoh@email.com"
            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
          />
        </div>
        <div>
          <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
          <textarea
            id="message"
            name="message"
            rows="5"
            required
            placeholder="Tulis pesan Anda di sini..."
            class="w-full px-5 py-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
          ></textarea>
        </div>
        <button
          type="submit"
          class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-500/50"
        >
          Kirim Pesan
        </button>
      </form>
    </div>
  </main>

  <!-- Script untuk mobile toggle -->
  <script>
    const menuToggle = document.getElementById("menuToggle");
    const mobileMenu = document.getElementById("mobileMenu");

    menuToggle.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  </script>
  
</body>
</html>

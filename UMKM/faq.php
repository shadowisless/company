<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>FAQ dan Bantuan - YourClothes</title>
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

  <!-- Konten FAQ -->
  <main class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-10 mt-12 mb-20">
    <h1 class="text-4xl font-extrabold text-indigo-700 mb-8 text-center drop-shadow">FAQ & Bantuan</h1>

    <!-- Accordion Section -->
    <div class="space-y-6">

      <!-- Item 1 -->
      <div class="accordion border-b pb-4">
        <button aria-expanded="false" aria-controls="faq1" class="flex justify-between w-full text-left text-lg font-semibold text-gray-800 hover:text-indigo-600 transition items-center" onclick="toggleAccordion(this)">
          <span><i class="fas fa-box mr-2 text-indigo-500"></i> Bagaimana cara memesan produk?</span>
          <i class="fas fa-chevron-down transition-transform"></i>
        </button>
        <div id="faq1" class="accordion-content text-gray-600 mt-2" role="region" aria-labelledby="faq1">
          <p class="pt-2">Untuk memesan produk, pilih item yang Anda inginkan, klik tombol "Beli", lalu ikuti petunjuk di halaman checkout. Pastikan data pengiriman Anda sudah benar sebelum konfirmasi.</p>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="accordion border-b pb-4">
        <button aria-expanded="false" aria-controls="faq2" class="flex justify-between w-full text-left text-lg font-semibold text-gray-800 hover:text-indigo-600 transition items-center" onclick="toggleAccordion(this)">
          <span><i class="fas fa-headset mr-2 text-indigo-500"></i> Bagaimana cara menghubungi layanan pelanggan?</span>
          <i class="fas fa-chevron-down transition-transform"></i>
        </button>
        <div id="faq2" class="accordion-content text-gray-600 mt-2" role="region" aria-labelledby="faq2">
          <p class="pt-2">Anda dapat menghubungi kami melalui halaman Kontak, atau langsung melalui email di support@domainmu.com dan WhatsApp di +62 812 3456 7890.</p>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="accordion border-b pb-4">
        <button aria-expanded="false" aria-controls="faq3" class="flex justify-between w-full text-left text-lg font-semibold text-gray-800 hover:text-indigo-600 transition items-center" onclick="toggleAccordion(this)">
          <span><i class="fas fa-undo-alt mr-2 text-indigo-500"></i> Bagaimana cara melakukan pengembalian produk?</span>
          <i class="fas fa-chevron-down transition-transform"></i>
        </button>
        <div id="faq3" class="accordion-content text-gray-600 mt-2" role="region" aria-labelledby="faq3">
          <p class="pt-2">Silakan ajukan pengembalian melalui akun Anda dalam 7 hari setelah menerima produk. Tim kami akan meninjau dan memberikan instruksi selanjutnya.</p>
        </div>
      </div>
    </div>

    <!-- Bantuan -->
    <section class="mt-12">
      <h2 class="text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-question-circle mr-2 text-indigo-500"></i>Bantuan</h2>
      <p class="text-gray-600 leading-relaxed">
        Jika Anda membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi tim kami melalui email atau media sosial. Kami siap membantu setiap hari kerja pukul 09.00–17.00 WIB. Terima kasih telah menggunakan layanan kami!
      </p>
    </section>
  </main>

  <script>
    // Toggle mobile menu
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Toggle accordion with accessibility update
    function toggleAccordion(button) {
      const item = button.parentElement;
      const content = item.querySelector('.accordion-content');
      const icon = button.querySelector('i.fas.fa-chevron-down');

      const isOpen = item.classList.contains('open');

      if (isOpen) {
        item.classList.remove('open');
        icon.classList.remove('rotate-180');
        button.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('open');
        icon.classList.add('rotate-180');
        button.setAttribute('aria-expanded', 'true');
      }
    }
  </script>

</body>
</html>

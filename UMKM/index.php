<?php
session_start();
include "db.php";
$produk = $conn->query("SELECT * FROM produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>YourClothes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* Navbar underline hover */
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
    /* Product card */
    .product-card {
      transition: transform 0.3s, box-shadow 0.3s;
      position: relative;
      overflow: hidden;
      background: white;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                  0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .product-card img {
      transition: transform 0.3s ease;
    }
    .product-card:hover img {
      transform: scale(1.05);
    }
    /* Add to cart button */
    .detail-btn {
      position: absolute;
      bottom: 0.75rem;
      left: 50%;
      transform: translateX(-50%);
      background: #3B82F6;
      color: white;
      padding: 0.4rem 1rem;
      border-radius: 9999px;
      font-weight: 600;
      font-size: 0.875rem;
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: pointer;
      user-select: none;
    }
    .product-card:hover .detail-btn {
      opacity: 1;
    }
    /* Badge */
    .product-badge {
      position: absolute;
      top: 0.75rem;
      left: 0.75rem;
      background-color: #2563EB;
      color: white;
      padding: 0.15rem 0.5rem;
      font-size: 0.75rem;
      font-weight: 700;
      border-radius: 0.375rem;
      text-transform: uppercase;
      z-index: 10;
    }
    /* Testimonial slider */
    .testimonial-slide {
      display: none;
      transition: opacity 0.5s ease;
    }
    .testimonial-slide.active {
      display: block;
    }
    /* Footer social hover */
    footer a.social-icon:hover {
      color: #93C5FD; /* lighter blue */
    }
  </style>
<?php
session_start();
include "db.php";
$produk = $conn->query("SELECT * FROM produk");
?>
</head>
<body class="font-sans text-gray-800 bg-white">
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
  <!-- Banner -->
  <section class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
  <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-center md:items-start gap-10">
    <!-- Kiri: Teks -->
    <div class="md:w-1/2 text-white">
      <p class="uppercase font-semibold tracking-wide mb-2 opacity-80">YourClothes</p>
      <h1 class="text-5xl font-extrabold mb-4 leading-tight drop-shadow-lg">
        Pilih Semua<br />
        yang Kamu Suka
      </h1>
      <p class="mb-8 text-lg opacity-90 max-w-md">
        Tersedia berbagai pilihan pakaian menarik hanya di sini. Temukan koleksi terbaru dan terbaik untuk kebutuhanmu.
      </p>
      <button id="shopNowBtn" class="bg-white text-blue-700 font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-blue-50 transition">
        BELANJA SEKARANG
      </button>
    </div>
    <!-- Kanan: Gambar -->
    <div class="md:w-1/2">
      <img
        src="assets/images/banner.jpg"
        alt="banner"
        class="rounded-xl shadow-2xl hover:scale-105 transition-transform duration-500"
      />
    </div>
  </div>
</section>
  <!-- Produk Populer -->
  <section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4 flex-wrap">
        <h2 class="text-2xl font-bold text-blue-600">TREND COLLECTION</h2>
        <div class="flex flex-wrap items-center gap-2">
         <!-- Filter Kategori -->
<span class="font-semibold mr-2">Filter Kategori:</span>
<button onclick="filterKategori('all')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Semua</button>
<button onclick="filterKategori('pakaian')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Pakaian</button>
<button onclick="filterKategori('aksesoris')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Aksesoris</button>
<button onclick="filterKategori('lainlain')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Lain-lain</button>

<!-- Filter Gender -->
<span class="font-semibold mr-2 ml-6">Filter Gender:</span>
<button onclick="filterGender('all')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Semua</button>
<button onclick="filterGender('pria')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Pria</button>
<button onclick="filterGender('wanita')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition">Wanita</button>

<button onclick="resetFilters()" class="ml-4 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Reset Filter</button>

        </div>
      </div>
      <div class="flex flex-wrap justify-center gap-6" id="produkContainer">
        <?php
        // buat badge "New" acak untuk produk (contoh)
        $i = 0;
    while ($row = $produk->fetch_assoc()) {
  $badge = ($i % 3 == 0) ? "<div class='product-badge'>New</div>" : "";
  $kategori = strtolower(trim($row['kategori']));
  $gender = strtolower(trim($row['gender'])); // Ubah di sini
  echo "
 <div class='product-card w-52 relative group' data-kategori='{$kategori}' data-gender='{$gender}'> 
    $badge
    <a href='detail_produk.php?id={$row['id']}'>
      <img src='assets/images/{$row['gambar']}' alt='{$row['nama']}' class='w-full h-56 object-cover rounded-t' />
    </a>
    <div class='p-4 text-center'>
      <a href='detail_produk.php?id={$row['id']}' class='font-semibold text-gray-800 hover:text-blue-600'>{$row['nama']}</a>
      <p class='mt-1 text-sm text-gray-600'>Rp {$row['harga']}</p>
    </div>
    <a href='detail_produk.php?id={$row['id']}'>
      <button class='detail-btn'>Lihat Detail</button>
    </a>
  </div>";
  $i++;
}

        ?>
      </div>
    </div>
  </section>
  <!-- Testimonial -->
  <section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-xl text-center">
      <h2 class="text-2xl font-bold text-blue-600 mb-6">Apa Kata Mereka</h2>
      <div id="testimonialSlides" class="relative">
        <div class="testimonial-slide active">
          <p class="italic text-gray-700">"Barang berkualitas dan pelayanan cepat! Recomended banget."</p>
          <p class="mt-4 font-semibold text-gray-900">- Diah Putri</p>
        </div>
        <div class="testimonial-slide">
          <p class="italic text-gray-700">"Pengiriman tepat waktu dan produk sesuai ekspektasi."</p>
          <p class="mt-4 font-semibold text-gray-900">- Rian Saputra</p>
        </div>
        <div class="testimonial-slide">
          <p class="italic text-gray-700">"Pilihan produk lengkap dan harga bersaing."</p>
          <p class="mt-4 font-semibold text-gray-900">- Sari Melati</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 py-6">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <div class="mb-4 md:mb-0">&copy; 2025 YourClothes. All rights reserved.</div>
      <div class="flex space-x-6 text-xl">
        <a href="#" aria-label="Facebook" class="social-icon hover:text-blue-500"><i class="fab fa-facebook"></i></a>
        <a href="#" aria-label="Instagram" class="social-icon hover:text-pink-500"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="Twitter" class="social-icon hover:text-sky-400"><i class="fab fa-twitter"></i></a>
        <a href="#" aria-label="WhatsApp" class="social-icon hover:text-green-500"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
  </footer>
  <script>
    // Navbar mobile toggle
    document.getElementById('menuToggle').addEventListener('click', () => {
  const menu = document.getElementById('mobileMenu');
  // Toggle kelas 'hidden'
  menu.classList.toggle('hidden');
    });
    // Search toggle mobile
    document.getElementById('searchToggle').addEventListener('click', () => {
      const inputMobile = document.getElementById('searchInputMobile');
      inputMobile.classList.toggle('hidden');
      if (!inputMobile.classList.contains('hidden')) inputMobile.focus();
    });

    // Scroll to product section from banner button
    document.getElementById('shopNowBtn').addEventListener('click', () => {
      document.getElementById('produkContainer').scrollIntoView({ behavior: 'smooth' });
    });

    // Testimonial slider
    let currentTestimonial = 0;
    const slides = document.querySelectorAll('.testimonial-slide');
    setInterval(() => {
      slides[currentTestimonial].classList.remove('active');
      currentTestimonial = (currentTestimonial + 1) % slides.length;
      slides[currentTestimonial].classList.add('active');
    }, 5000);

    const filterKategoriButtons = document.querySelectorAll("button[onclick^='filterKategori']");
const filterGenderButtons = document.querySelectorAll("button[onclick^='filterGender']");

 let currentKategori = 'all';
let currentGender = 'all';

function applyFilters() {
  const cards = document.querySelectorAll('.product-card');
  const searchKeyword = document.getElementById('searchInput').value.toLowerCase();
  cards.forEach(card => {
    const kategori = card.getAttribute('data-kategori');
    const gender = card.getAttribute('data-gender');
    const namaProduk = card.querySelector('a.font-semibold').textContent.toLowerCase();

    const matchKategori = (currentKategori === 'all' || kategori === currentKategori);
    const matchGender = (currentGender === 'all' || gender === currentGender);
    const matchSearch = (namaProduk.includes(searchKeyword));

    card.style.display = (matchKategori && matchGender && matchSearch) ? 'block' : 'none';
  });
}

function setActiveButton(buttons, activeValue) {
  buttons.forEach(btn => {
    const val = btn.getAttribute('onclick').match(/'(.*?)'/)[1];
    if (val === activeValue) {
      btn.classList.add('bg-blue-600', 'text-white');
      btn.classList.remove('bg-blue-100', 'text-blue-600');
    } else {
      btn.classList.remove('bg-blue-600', 'text-white');
      btn.classList.add('bg-blue-100', 'text-blue-600');
    }
  });
}

function filterKategori(kategori) {
  currentKategori = kategori;
  setActiveButton(filterKategoriButtons, kategori);
  applyFilters();
}

function filterGender(gender) {
  currentGender = gender;
  setActiveButton(filterGenderButtons, gender);
  applyFilters();
}

function resetFilters() {
  currentKategori = 'all';
  currentGender = 'all';
  document.getElementById('searchInput').value = '';
  document.getElementById('searchInputMobile').value = '';
  applyFilters();
}

// Search input events
document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('searchInputMobile').addEventListener('input', applyFilters);

  </script>
</body>
</html>

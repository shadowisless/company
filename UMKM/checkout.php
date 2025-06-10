<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$cartItems = [];
$total = 0;

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    if ($product) {
        $subtotal = $product['harga'] * $quantity;
        $cartItems[] = [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
        $total += $subtotal;
    }
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = 'checkout.php';
    header("Location: loginuser.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Checkout</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Validasi form sederhana
    function validateForm() {
      const form = document.getElementById('checkoutForm');
      const inputs = form.querySelectorAll('input[required]');
      let valid = true;
      inputs.forEach(input => {
        if (!input.value.trim()) valid = false;
      });

      // Pastikan metode pembayaran dipilih
      const payment = form.querySelector('input[name="payment"]:checked');
      if (!payment) valid = false;

      document.getElementById('submitBtn').disabled = !valid;
    }

    window.addEventListener('DOMContentLoaded', () => {
      validateForm();
      const form = document.getElementById('checkoutForm');
      form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', validateForm);
        input.addEventListener('change', validateForm);
      });
    });
  </script>
</head>
<body class="bg-gray-50">
  <div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Checkout</h1>

    <form id="checkoutForm" method="POST" action="prosesorder.php" class="bg-white p-8 rounded shadow space-y-8">
      
      <section>
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Alamat Pengiriman</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name" class="block text-gray-700 mb-1 font-medium">Nama Lengkap</label>
            <input type="text" id="name" name="name" required placeholder="Nama penerima" 
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label for="city" class="block text-gray-700 mb-1 font-medium">Kota</label>
            <input type="text" id="city" name="city" required placeholder="Kota tujuan" 
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div class="md:col-span-2">
            <label for="address" class="block text-gray-700 mb-1 font-medium">Alamat Lengkap</label>
            <input type="text" id="address" name="address" required placeholder="Alamat lengkap, jalan, nomor rumah" 
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label for="zipcode" class="block text-gray-700 mb-1 font-medium">Kode Pos</label>
            <input type="text" id="zipcode" name="zipcode" required placeholder="Kode pos" 
              class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Metode Pembayaran</h2>
        <div class="flex flex-col space-y-3">
          <label class="inline-flex items-center cursor-pointer">
            <input type="radio" name="payment" value="cod" checked class="form-radio text-blue-600" />
            <span class="ml-2 text-gray-700">Cash on Delivery (COD)</span>
          </label>
          <label class="inline-flex items-center cursor-pointer">
            <input type="radio" name="payment" value="transfer" class="form-radio text-blue-600" />
            <span class="ml-2 text-gray-700">Bank Transfer</span>
          </label>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Ringkasan Pesanan</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-left border border-gray-200 rounded-md">
            <thead class="bg-gray-100">
              <tr>
                <th class="py-3 px-4 font-medium text-gray-700 border-b border-gray-300">Produk</th>
                <th class="py-3 px-4 font-medium text-gray-700 border-b border-gray-300">Harga</th>
                <th class="py-3 px-4 font-medium text-gray-700 border-b border-gray-300">Jumlah</th>
                <th class="py-3 px-4 font-medium text-gray-700 border-b border-gray-300">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cartItems as $item): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                  <td class="py-3 px-4"><?= htmlspecialchars($item['product']['nama']) ?></td>
                  <td class="py-3 px-4">Rp<?= number_format($item['product']['harga'], 0, ',', '.') ?></td>
                  <td class="py-3 px-4"><?= $item['quantity'] ?></td>
                  <td class="py-3 px-4 font-semibold">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="bg-gray-100">
                <td colspan="3" class="text-right py-3 px-4 font-bold text-lg">Total:</td>
                <td class="py-3 px-4 font-bold text-lg">Rp<?= number_format($total, 0, ',', '.') ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </section>

      <div class="text-right">
        <button 
          id="submitBtn"
          type="submit" 
          disabled
          class="bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-3 rounded hover:bg-blue-700 transition"
        >
          Place Order
        </button>
      </div>
    </form>
  </div>
</body>
</html>

<?php
session_start();
require 'db.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = [];
$total = 0;

// Ambil detail produk berdasarkan ID di keranjang
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    if ($product) {
        $subtotal = $product['harga'] * $quantity;
        $cartItems[$productId] = [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
        $total += $subtotal;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Keranjang Belanja</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        <?= htmlspecialchars($_SESSION['message']) ?>
      </div>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="bg-white p-8 rounded shadow-md">
      <?php if (empty($cartItems)): ?>
        <p class="text-gray-600">Keranjang belanja Anda kosong.</p>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="text-left py-3 px-4 text-gray-700 font-semibold">Produk</th>
                <th class="text-left py-3 px-4 text-gray-700 font-semibold">Harga</th>
                <th class="text-left py-3 px-4 text-gray-700 font-semibold">Jumlah</th>
                <th class="text-left py-3 px-4 text-gray-700 font-semibold">Subtotal</th>
                <th class="py-3 px-4"></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($cartItems as $productId => $item): ?>
                <tr class="hover:bg-gray-50">
                  <td class="py-4 px-4"><?= htmlspecialchars($item['product']['nama']) ?></td>
                  <td class="py-4 px-4">Rp<?= number_format($item['product']['harga'], 0, ',', '.') ?></td>
                  <td class="py-4 px-4">
                    <form method="POST" action="updatecart.php" class="flex items-center space-x-2">
                      <input type="hidden" name="product_id" value="<?= $productId ?>">
                      <input type="number" name="quantity" min="1" value="<?= $item['quantity'] ?>" class="w-20 border rounded px-2 py-1" onchange="this.form.submit()">
                    </form>
                  </td>
                  <td class="py-4 px-4 font-semibold">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                  <td class="py-4 px-4">
                    <form method="POST" action="removecart.php">
                      <input type="hidden" name="product_id" value="<?= $productId ?>">
                      <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="bg-gray-50">
                <td colspan="3" class="text-right py-4 px-4 font-bold text-lg">Total:</td>
                <td class="py-4 px-4 font-bold text-lg">Rp<?= number_format($total, 0, ',', '.') ?></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="mt-6">
          <a href="checkout.php" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Checkout</a>
          <a href="index.php" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-white-700 transition">Lanjut Belanja</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>

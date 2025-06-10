<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: checkout.php');
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Keranjang kosong.";
    exit;
}

// Ambil data dari form
$name = $_POST['name'] ?? '';
$city = $_POST['city'] ?? '';
$address = $_POST['address'] ?? '';
$zipcode = $_POST['zipcode'] ?? '';
$payment = $_POST['payment'] ?? '';

// Validasi sederhana
if (!$name || !$city || !$address || !$zipcode || !$payment) {
    echo "Semua kolom harus diisi.";
    exit;
}

$total = 0;
$cartItems = [];

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    if ($product) {
        $subtotal = $product['harga'] * $quantity;
        $cartItems[] = [
            'id' => $productId,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
        $total += $subtotal;
    }
}

// Simpan ke tabel pesanan
$stmt = $conn->prepare("INSERT INTO pesanan (nama, kota, alamat, kode_pos, metode_bayar, total, tanggal) VALUES (?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssssi", $name, $city, $address, $zipcode, $payment, $total);

if ($stmt->execute()) {
    $orderId = $stmt->insert_id;

    // Simpan detail pesanan
    $detailStmt = $conn->prepare("INSERT INTO pesanan_detail (pesanan_id, produk_id, jumlah, subtotal) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $detailStmt->bind_param("iiii", $orderId, $item['id'], $item['quantity'], $item['subtotal']);
        $detailStmt->execute();
    }

    // Bersihkan keranjang
    unset($_SESSION['cart']);

    echo "<script>
        alert('Pesanan berhasil dibuat!');
        window.location.href = 'thank.php?id=$orderId';
    </script>";
} else {
    echo "Terjadi kesalahan saat memproses pesanan.";
}
?>

<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if (!$productId || !is_numeric($productId) || $quantity < 1) {
        header('Location: cart.php?error=invalid_input');
        exit;
    }

    // Pastikan cart array sudah ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Jika produk sudah ada di keranjang, tambahkan jumlah
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    header('Location: cart.php');
    exit;
}
?>

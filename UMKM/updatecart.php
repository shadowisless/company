<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        // Jika jumlah 0 atau kurang, hapus item
        unset($_SESSION['cart'][$productId]);
    }
}

header('Location: cart.php');
exit;

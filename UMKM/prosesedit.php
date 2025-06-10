<?php
session_start();
include "db.php";

$id      = $_POST['id'];
$nama    = $_POST['nama'];
$harga   = $_POST['harga'];
$stok    = $_POST['stok'];
$gender  = $_POST['gender'];
$kategori = $_POST['kategori'];

// Ambil data produk lama untuk hapus gambar jika diganti
$lama = $conn->query("SELECT gambar FROM produk WHERE id = $id")->fetch_assoc();
$gambarLama = $lama['gambar'];

if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
    $namaFile = time() . '_' . $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "assets/images/" . $namaFile);

    // Hapus gambar lama
    if (file_exists("assets/images/" . $gambarLama)) {
        unlink("assets/images/" . $gambarLama);
    }

    // Update dengan gambar baru
    $sql = "UPDATE produk SET nama='$nama', harga='$harga', stok='$stok', gender='$gender', kategori='$kategori', gambar='$namaFile' WHERE id=$id";
} else {
    // Update tanpa ubah gambar
    $sql = "UPDATE produk SET nama='$nama', harga='$harga', stok='$stok', gender='$gender', kategori='$kategori' WHERE id=$id";
}

if ($conn->query($sql)) {
    $_SESSION['msg'] = "Produk berhasil diperbarui!";
} else {
    $_SESSION['error'] = "Gagal memperbarui produk!";
}

header("Location: dashboard.php");
exit();

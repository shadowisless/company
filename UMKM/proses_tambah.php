<?php
include "db.php";

$nama = $_POST['nama'];
$harga = $_POST['harga'];
$kategori = $_POST['kategori'];
$gender = $_POST['gender'];
$gambar = $_FILES['gambar']['name'];
$stok = $_POST['stok'];
$tmp = $_FILES['gambar']['tmp_name'];
$deskripsi = $conn->real_escape_string($_POST['deskripsi']);

move_uploaded_file($tmp, "assets/images/" . $gambar);

$conn->query("INSERT INTO produk (nama, harga, kategori, gender, gambar, stok, deskripsi) VALUES ('$nama', '$harga', '$kategori', '$gender', '$gambar','$stok','$deskripsi')");

header("Location: dashboard.php");
?>

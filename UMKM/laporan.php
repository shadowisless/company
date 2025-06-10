<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "db.php";

// Ambil data semua pesanan
$pesanan = $conn->query("
    SELECT p.*, 
           GROUP_CONCAT(pr.nama, ' (', pd.jumlah, 'x)') AS daftar_produk,
           GROUP_CONCAT(pd.subtotal) AS subtotals
    FROM pesanan p
    JOIN pesanan_detail pd ON p.id = pd.pesanan_id
    JOIN produk pr ON pr.id = pd.produk_id
    GROUP BY p.id
    ORDER BY p.tanggal DESC
");

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=laporan_pesanan.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, ['No', 'Nama', 'Kota', 'Alamat', 'Kode Pos', 'Produk', 'Total', 'Metode Bayar', 'Tanggal']);

    $i = 1;
    while ($row = $pesanan->fetch_assoc()) {
        fputcsv($output, [
            $i++,
            $row['nama'],
            $row['kota'],
            $row['alamat'],
            $row['kode_pos'],
            $row['daftar_produk'],
            'Rp' . number_format($row['total'], 0, ',', '.'),
            $row['metode_bayar'],
            $row['tanggal']
        ]);
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-gray-100 text-gray-800 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-list-check text-blue-600 text-2xl"></i>
                <h1 class="text-3xl font-bold text-blue-800">Laporan Pesanan</h1>
            </div>
            <div class="flex items-center gap-2">
            <a href="?export=csv" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" >Export ke CSV</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm text-left table-auto">
                <thead class="bg-blue-100 sticky top-0 z-10">
                    <tr class="text-gray-700 uppercase text-xs">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kota</th>
                        <th class="px-4 py-3">Alamat</th>
                        <th class="px-4 py-3">Kode Pos</th>
                        <th class="px-4 py-3">Produk (Qty)</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Metode</th>
                        <th class="px-4 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $no = 1; while ($row = $pesanan->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-semibold"><?= $no++ ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($row['kota']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($row['alamat']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($row['kode_pos']) ?></td>
                        <td class="px-4 py-2 text-sm text-gray-700"><?= nl2br($row['daftar_produk']) ?></td>
                        <td class="px-4 py-2 text-blue-700 font-semibold">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white text-xs 
                                <?= $row['metode_bayar'] == 'COD' ? 'bg-yellow-600' : 'bg-green-700' ?>">
                                <?= $row['metode_bayar'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600"><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

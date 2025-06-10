<?php
session_start();
include "db.php";

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username         = trim($_POST['username'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong.";
    }
    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong.";
    }
    if (empty($confirm_password)) {
        $errors[] = "Konfirmasi password tidak boleh kosong.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak cocok.";
    }

    if (!empty($username) && strlen($username) < 4) {
        $errors[] = "Username minimal 4 karakter.";
    }
    if (!empty($password) && strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM `user` WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Username '$username' sudah terdaftar. Silakan gunakan username lain.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO `user` (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Registrasi berhasil! Silakan login.";
            header("Location: loginuser.php");
            exit();
        } else {
            $errors[] = "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - YourClothes</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
      <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">Buat Akun Baru</h1>

      <!-- Tampilkan error jika ada -->
      <?php if (!empty($errors)): ?>
        <div class="mb-4">
          <ul class="list-disc list-inside text-red-600">
            <?php foreach ($errors as $err): ?>
              <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Form Registrasi -->
      <form action="register.php" method="post" class="space-y-4">
        <div>
          <label for="username" class="block text-sm font-medium mb-1">Username</label>
          <input
            type="text"
            name="username"
            id="username"
            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
            required
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Masukkan username"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium mb-1">Password</label>
          <input
            type="password"
            name="password"
            id="password"
            required
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Masukkan password"
          />
        </div>

        <div>
          <label for="confirm_password" class="block text-sm font-medium mb-1">Konfirmasi Password</label>
          <input
            type="password"
            name="confirm_password"
            id="confirm_password"
            required
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Ulangi password"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Daftar
        </button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="loginuser.php" class="text-blue-600 hover:underline font-medium">Login di sini</a>
      </p>
    </div>
  </div>
</body>
</html>

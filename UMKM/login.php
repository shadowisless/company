<?php
session_start();
require 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh sederhana, sebaiknya pakai password_hash() untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $_SESSION['admin'] = $username; // Simpan session
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .form-input {
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    .form-input:focus {
      border-color: #3B82F6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
    .btn-login {
      transition: background-color 0.3s, transform 0.3s;
    }
    .btn-login:hover {
      background-color: #2563EB;
      transform: translateY(-2px);
    }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
    <div class="text-center mb-6">
      <i class="fas fa-user-shield text-blue-600 text-5xl mb-4"></i>
      <h2 class="text-2xl font-bold text-blue-600">Login Admin</h2>
    </div>
    <?php if ($error): ?>
      <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-4">
        <label class="block mb-1 text-gray-700">Username</label>
        <div class="relative">
          <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
          <input type="text" name="username" required class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 form-input">
        </div>
      </div>
      <div class="mb-6">
        <label class="block mb-1 text-gray-700">Password</label>
        <div class="relative">
          <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
          <input type="password" name="password" required class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 form-input">
        </div>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition btn-login">Login</button>
    </form>
    <div class="mt-4 text-center text-sm text-gray-600">
      <a href="index.php" class="text-blue-600 hover:underline">kembali ke beranda</a>
    </div>
  </div>
</body>
</html>
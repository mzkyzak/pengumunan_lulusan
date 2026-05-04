<?php
require 'koneksi.php';
$error = '';

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    // 1. Cek di tabel Admin
    $qAdmin = $db->prepare("SELECT * FROM admin WHERE username = ?");
    $qAdmin->execute([$u]);
    $resAdmin = $qAdmin->fetch(PDO::FETCH_ASSOC);

    if ($resAdmin && password_verify($p, $resAdmin['password'])) {
        $_SESSION['role'] = 'admin'; 
        $_SESSION['nama'] = $resAdmin['nama'];
        header("Location: admin_dashboard.php"); 
        exit;
    }

    // 2. Cek di tabel Siswa (Bisa pakai NISN atau Nama Tanpa Spasi)
    $qSiswa = $db->prepare("SELECT * FROM siswa WHERE nisn = ? OR username = ?");
    $qSiswa->execute([$u, strtoupper(str_replace(' ', '', $u))]);
    $resSiswa = $qSiswa->fetch(PDO::FETCH_ASSOC);

    if ($resSiswa && password_verify($p, $resSiswa['password'])) {
        $_SESSION['role'] = 'siswa'; 
        $_SESSION['nama'] = $resSiswa['nama']; 
        $_SESSION['status'] = $resSiswa['status'];
        header("Location: pengumuman.php"); 
        exit;
    }

    $error = "Username/NISN atau Password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;900&display=swap" rel="stylesheet">
    <?php include 'style_sultan.php'; ?>
</head>
<body class="h-screen flex items-center justify-center">
    <div class="bg-orb-1"></div><div class="bg-orb-2"></div><div class="bg-orb-3"></div>

    <div class="glass-panel glass-hover p-8 w-96 z-10">
        <h2 class="text-3xl font-bold text-center text-white mb-6 tracking-widest">LOGIN</h2>
        <h1 class="text-2xl font-bold text-center text-white mb-6 tracking-widest">Admin/Siswa</h1>
        
        <?php if($error): ?>
            <p class='text-red-400 text-sm text-center mb-4 border border-red-500 bg-red-500/10 p-2 rounded'>
                <?= $error ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-cyan-400 text-sm font-bold mb-2">Username / NISN</label>
                <input type="text" name="username" required class="w-full px-3 py-2 bg-slate-800/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition">
            </div>
            <div class="mb-6">
                <label class="block text-cyan-400 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 bg-slate-800/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition">
            </div>
            <button type="submit" name="login" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-bold py-3 px-4 rounded-lg shadow-[0_0_15px_rgba(6,182,212,0.4)] hover:shadow-[0_0_25px_rgba(6,182,212,0.6)] transition tracking-wider">
                MASUK
            </button>
        </form>
    </div>
</body>
</html>
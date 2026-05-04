<?php
session_start();

// Proteksi Halaman: Pastikan yang masuk benar-benar sudah login sebagai siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

// Ambil data nama dari session (yang diset saat login)
$namaSiswa = $_SESSION['nama'] ?? 'Siswa';
// Buat display username (huruf kecil, tanpa spasi)
$usernameSiswa = strtolower(str_replace(' ', '', $namaSiswa));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa Dashboard - Sultan Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .bg-orb { position: absolute; border-radius: 50%; filter: blur(100px); z-index: -1; animation: float 10s infinite alternate; }
        @keyframes float { from { transform: translate(0, 0); } to { transform: translate(20px, 40px); } }
    </style>
</head>
<body class="bg-slate-950 text-white min-h-screen overflow-x-hidden relative flex flex-col items-center p-6">

    <div class="bg-orb w-80 h-80 bg-indigo-600/30 top-0 left-0"></div>
    <div class="bg-orb w-72 h-72 bg-purple-600/20 bottom-0 right-0" style="animation-delay: -5s;"></div>

    <div class="max-w-4xl w-full mt-10 z-10">
        
        <div class="glass rounded-3xl p-6 flex flex-col md:flex-row items-center gap-6 mb-8 shadow-2xl">
            <div class="relative">
                <div class="w-24 h-24 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-full flex items-center justify-center border-4 border-white/10 shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-slate-950 rounded-full"></div>
            </div>
            <div class="text-center md:text-left flex-1">
                <p class="text-indigo-400 font-bold tracking-widest text-xs uppercase mb-1">Selamat Datang,</p>
                <h1 class="text-3xl font-black tracking-tight"><?= htmlspecialchars($namaSiswa) ?></h1>
                <p class="text-gray-400 text-sm">Username: @<span class="italic"><?= htmlspecialchars($usernameSiswa) ?></span></p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="logout.php" class="bg-red-500/10 text-red-500 border border-red-500/50 px-6 py-2 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition uppercase tracking-widest">Logout</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <div class="glass p-5 rounded-2xl text-center md:text-left">
                <p class="text-gray-400 text-xs font-bold mb-2 uppercase">Status Web</p>
                <h3 class="text-xl font-bold text-green-400">Online</h3>
            </div>
            <div class="glass p-5 rounded-2xl text-center md:text-left">
                <p class="text-gray-400 text-xs font-bold mb-2 uppercase">Tahun Ajaran</p>
                <h3 class="text-xl font-bold text-cyan-400">2026/2027</h3>
            </div>
            <div class="glass p-5 rounded-2xl text-center md:text-left">
                <p class="text-gray-400 text-xs font-bold mb-2 uppercase">Pengumuman</p>
                <h3 class="text-xl font-bold text-indigo-400">Resmi banget</h3>
            </div>
        </div>

        <div class="glass rounded-[2rem] p-10 text-center relative overflow-hidden border-2 border-indigo-500/30 shadow-[0_0_30px_rgba(99,102,241,0.1)]">
            <div class="relative z-10">
                <h2 class="text-2xl font-black mb-4 tracking-wider">SISTEM VALIDASI KELULUSAN</h2>
                <p class="text-gray-400 mb-8 max-w-md mx-auto text-sm">Untuk keamanan data, silakan masukkan NISN Anda untuk membuka hasil pengumuman resmi.</p>

                <?php if(isset($_GET['error'])): ?>
                    <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded-xl mb-6 text-sm font-bold animate-bounce">
                        ⚠️ <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="hasil.php" method="POST" class="max-w-xs mx-auto space-y-4">
                    <input type="text" name="nisn" required autocomplete="off"
                        placeholder="Masukkan NISN Anda"
                        class="w-full bg-white/5 border border-white/20 rounded-xl py-4 px-6 text-center text-xl font-mono focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all text-white placeholder-gray-600">

                    <button type="submit" name="cek_hasil" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-black py-4 rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 uppercase tracking-widest mt-2">
                        Buka Pengumuman 🚀
                    </button>
                </form>
            </div>
        </div>

        <footer class="mt-20 mb-8 text-center text-gray-600 text-xs uppercase tracking-widest font-bold">
            &copy; 2026 • Kelompok 1 mzkyzak
        </footer>
    </div>

</body>
</html>
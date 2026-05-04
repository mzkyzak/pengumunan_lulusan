<?php
// Panggil koneksi (Otomatis menyalakan session dengan aman)
require 'koneksi.php';

// Jika sudah login, langsung tendang ke dashboard masing-masing
if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: pengumuman.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Kelulusan - MzMkyzak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #020617; /* Deep Slate / Dark Theme */
            overflow: hidden;
        }
        
        /* Animasi Orbs Melayang di Background */
        .bg-orb { 
            position: absolute; 
            border-radius: 50%; 
            filter: blur(120px); 
            z-index: -1; 
            animation: float 12s infinite alternate ease-in-out; 
            opacity: 0.15;
        }
        @keyframes float { 
            0% { transform: translate(0, 0) scale(1); } 
            100% { transform: translate(30px, 60px) scale(1.1); } 
        }

        /* Glassmorphism Panel */
        .glass-panel { 
            background: rgba(15, 23, 42, 0.6); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Animasi Masuk (Fade In Up) */
        .fade-in-up { animation: fadeInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(30px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        /* Animasi Logo Melayang */
        .floating-logo { animation: floatLogo 4s infinite ease-in-out; }
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Efek Teks Gradient */
        .text-gradient {
            background: linear-gradient(to right, #22d3ee, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center relative text-white">

    <div class="bg-orb w-[30rem] h-[30rem] bg-cyan-600 top-[-10%] left-[-10%]"></div>
    <div class="bg-orb w-[25rem] h-[25rem] bg-purple-600 bottom-[-10%] right-[-10%]" style="animation-delay: -5s;"></div>

    <div class="w-full max-w-lg px-6 relative z-10 fade-in-up">
        <div class="glass-panel rounded-[2.5rem] p-10 md:p-12 text-center relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600"></div>

            <div class="floating-logo mb-8 flex justify-center">
                <div class="w-28 h-28 bg-gradient-to-tr from-cyan-500/20 to-purple-500/20 rounded-full flex items-center justify-center border border-white/10 shadow-[0_0_30px_rgba(6,182,212,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-[10px] font-bold text-gray-400 tracking-[0.4em] uppercase mb-3">Selamat Datang di</h2>
            <h1 class="text-4xl md:text-5xl font-black mb-4 tracking-tight text-gradient">
                PORTAL KELULUSAN
            </h1>
            <p class="text-sm text-gray-400 mb-10 leading-relaxed px-2">
                Sistem Informasi Validasi Kelulusan Resmi Siswa SMK Negeri 2 Jakarta Tahun Ajaran 2026/2027.
            </p>

            <a href="login.php" class="group relative inline-flex items-center justify-center w-full sm:w-auto bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-black py-4 px-10 rounded-2xl transition-all duration-300 hover:scale-[1.03] active:scale-95 shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_40px_rgba(6,182,212,0.6)] uppercase tracking-widest text-xs">
                <span>Masuk ke Sistem</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-3 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
            
        </div>

        <div class="mt-8 text-center">
            <p class="text-gray-600 text-[10px] font-bold uppercase tracking-widest">
                &copy; 2026 Kelompok 1 • MZKYZAK
            </p>
        </div>
    </div>

</body>
</html>
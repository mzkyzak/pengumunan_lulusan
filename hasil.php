<?php

require 'koneksi.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}


if (!isset($_POST['nisn'])) {
    header("Location: pengumuman.php");
    exit;
}

$nisn_input = trim($_POST['nisn']);


$stmt = $db->prepare("SELECT * FROM siswa WHERE nisn = ?");
$stmt->execute([$nisn_input]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$siswa) {
    header("Location: pengumuman.php?error=NISN tidak ditemukan! Silakan cek kembali.");
    exit;
}


$status = strtoupper($siswa['status']);
if ($status === 'LULUS') {
    $theme = ['color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'note' => 'Selamat! Anda dinyatakan LULUS. Pertahankan prestasimu di jenjang berikutnya!'];
} elseif ($status === 'TIDAK LULUS') {
    $theme = ['color' => 'red', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'note' => 'Mohon maaf, Anda dinyatakan TIDAK LULUS. Jangan menyerah, tetap semangat!'];
} else {
    $theme = ['color' => 'yellow', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'note' => 'Hasil kelulusan Anda DITUNDA. Silakan segera hubungi pihak sekolah.'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pengumuman - <?= htmlspecialchars($siswa['nama']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">
    <?php include 'style_sultan.php'; ?>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-result { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0; }
            .glass-result { background: white !important; border: 2px solid black !important; color: black !important; box-shadow: none !important; }
            .text-white, .text-cyan-400, .text-gray-400 { color: black !important; }
        }
    </style>
</head>
<body class="bg-slate-950 text-white min-h-screen flex items-center justify-center p-4">

    <div class="bg-orb orb-1 opacity-20"></div>
    <div class="bg-orb orb-2 opacity-20"></div>

    <div class="max-w-2xl w-full z-10">
        <div class="glass-result rounded-[2.5rem] p-8 md:p-12 shadow-2xl relative overflow-hidden">
            
            <div class="text-center mb-10 border-b border-white/10 pb-6">
                <h1 class="text-2xl md:text-3xl font-black tracking-widest text-cyan-400 uppercase">
                    SURAT KETERANGAN LULUS
                </h1>
                <p class="text-gray-400 text-[10px] font-bold tracking-[0.3em] uppercase mt-2">
                    SMK NEGERI 2 JAKARTA • TAHUN AJARAN 2026/2027
                </p>
            </div>

            <div class="space-y-6">
                <p class="text-sm text-gray-300 leading-relaxed text-center italic">
                    "Berdasarkan hasil keputusan rapat Dewan Guru tentang kriteria kelulusan siswa, maka dengan ini menerangkan bahwa:"
                </p>

                <div class="bg-slate-900/50 rounded-2xl p-6 border border-white/5 space-y-4">
                    <div class="flex justify-between items-center border-b border-white/5 pb-3">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nama Lengkap</span>
                        <span class="text-sm font-black uppercase tracking-tight"><?= htmlspecialchars($siswa['nama']) ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/5 pb-3">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nomor Induk (NISN)</span>
                        <span class="text-sm font-mono text-cyan-400 font-bold"><?= htmlspecialchars($siswa['nisn']) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Jenis Kelamin</span>
                        <span class="text-sm font-bold"><?= $siswa['jk'] == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' ?></span>
                    </div>
                </div>

                <div class="text-center py-6">
                    <p class="text-[10px] font-bold text-gray-400 mb-4 uppercase tracking-[0.2em]">Dinyatakan :</p>
                    <div class="inline-block px-10 py-4 rounded-2xl border-2 border-<?= $theme['color'] ?>-500/50 bg-<?= $theme['color'] ?>-500/10 mb-4">
                        <h2 class="text-4xl md:text-5xl font-black text-<?= $theme['color'] ?>-400 tracking-tighter uppercase">
                            <?= $status ?>
                        </h2>
                    </div>
                    <p class="text-xs text-gray-400 italic px-4 mt-2">
                        <?= $theme['note'] ?>
                    </p>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-white/10 text-center">
                <p class="text-[9px] text-gray-500 uppercase tracking-widest mb-6">
                    Dicetak secara otomatis oleh Sistem kelulusan pada <?= date('d/m/Y H:i') ?>
                </p>

                <div class="flex flex-col md:flex-row gap-3 no-print">
                    <button onclick="window.print()" class="flex-1 bg-cyan-600 hover:bg-cyan-500 text-white font-black py-4 rounded-xl text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-cyan-900/20">
                        Cetak Bukti Kelulusan
                    </button>
                    <a href="pengumuman.php" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-black py-4 rounded-xl text-[10px] uppercase tracking-widest transition-all text-center">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

        </div>

        <footer class="mt-8 text-center text-gray-600 text-[10px] uppercase tracking-widest no-print">
            &copy; 2026 Kelompok 1 • yang kerja TAUFIQ IKHSAN MUZAKY
        </footer>
    </div>

</body>
</html>
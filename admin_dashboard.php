<?php
require 'koneksi.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: login.php"); exit; }

// --- CRUD MANUAL ---
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?: null;
    $nisn = trim($_POST['nisn']); 
    $nama = trim($_POST['nama']); 
    $stat = $_POST['status'];
    $jk = $_POST['jk'];
    $tgl = $_POST['tgl_lahir'];
    $pass = trim($_POST['password']);
    
    $user = strtoupper(str_replace(' ', '', $nama)); // Buat auto-username jika nambah manual
    $hash = password_hash($pass ?: '12345678', PASSWORD_DEFAULT);

    if ($id) {
        if (empty($pass)) {
            $sql = "UPDATE siswa SET nisn=?, nama=?, status=?, jk=?, tgl_lahir=? WHERE id=?";
            $db->prepare($sql)->execute([$nisn, $nama, $stat, $jk, $tgl, $id]);
        } else {
            $sql = "UPDATE siswa SET nisn=?, nama=?, password=?, status=?, jk=?, tgl_lahir=? WHERE id=?";
            $db->prepare($sql)->execute([$nisn, $nama, $hash, $stat, $jk, $tgl, $id]);
        }
    } else {
        $sql = "INSERT INTO siswa (nisn, nama, username, password, status, jk, tgl_lahir) VALUES (?,?,?,?,?,?,?)";
        $db->prepare($sql)->execute([$nisn, $nama, $user, $hash, $stat, $jk, $tgl]);
    }
    header("Location: admin_dashboard.php?msg=Data Berhasil Disimpan"); exit;
}

if (isset($_GET['del'])) { 
    $db->prepare("DELETE FROM siswa WHERE id=?")->execute([$_GET['del']]); 
    header("Location: admin_dashboard.php?msg=Data Dihapus"); exit;
}

if (isset($_POST['reset_db'])) { 
    $db->exec("DELETE FROM siswa"); 
    $db->exec("DELETE FROM sqlite_sequence WHERE name='siswa'"); 
    header("Location: admin_dashboard.php?msg=Database Bersih Kembali"); exit;
}

$total = $db->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
$lulus = $db->query("SELECT COUNT(*) FROM siswa WHERE status='LULUS'")->fetchColumn();
$tidak = $db->query("SELECT COUNT(*) FROM siswa WHERE status='TIDAK LULUS'")->fetchColumn();
$tunda = $db->query("SELECT COUNT(*) FROM siswa WHERE status='TUNDA'")->fetchColumn();

$edit = null;
if (isset($_GET['edit'])) {
    $st = $db->prepare("SELECT * FROM siswa WHERE id=?"); $st->execute([$_GET['edit']]);
    $edit = $st->fetch(PDO::FETCH_ASSOC);
}
$siswas = $db->query("SELECT * FROM siswa ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <?php include 'style_sultan.php'; ?>
</head>
<body class="p-6">
    <div class="bg-orb orb-1"></div><div class="bg-orb orb-2"></div>
    <div class="max-w-[1450px] mx-auto space-y-6">
        
        <header class="glass-panel p-6 flex justify-between items-center shadow-lg">
            <div>
                <h1 class="text-3xl fi-logo uppercase">KELOMPOK 1 MZKYZAK</h1>
                <p class="text-[13px] text-cyan-400 tracking-[0.4em] font-bold uppercase mt-1">DASHBOARD ADMIN</p>
            </div>
            <a href="logout.php" class="bg-red-500/10 text-red-500 border border-red-500/20 px-5 py-2 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition uppercase">Logout</a>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="magic-border h-24"><div class="magic-inner flex flex-col justify-center"><p class="text-[10px] text-slate-400 font-bold uppercase">Total</p><p class="text-2xl font-black text-white"><?= $total ?></p></div></div>
            <div class="glass-panel p-4 border-l-4 border-green-500"><p class="text-green-500 text-[10px] font-bold uppercase">LULUS</p><p class="text-2xl font-black text-white"><?= $lulus ?></p></div>
            <div class="glass-panel p-4 border-l-4 border-red-500"><p class="text-red-500 text-[10px] font-bold uppercase">TIDAK LULUS</p><p class="text-2xl font-black text-white"><?= $tidak ?></p></div>
            <div class="glass-panel p-4 border-l-4 border-yellow-500"><p class="text-yellow-500 text-[10px] font-bold uppercase">TUNDA</p><p class="text-2xl font-black text-white"><?= $tunda ?></p></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-3 space-y-4">
                <div class="glass-panel p-6">
                    <h2 class="text-white text-xs font-bold mb-4 uppercase tracking-widest border-b border-white/10 pb-2"><?= $edit ? 'Edit Data' : 'Tambah Data' ?></h2>
                    <form method="POST" class="space-y-3">
                        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
                        <input type="text" name="nisn" placeholder="NISN" value="<?= $edit['nisn'] ?? '' ?>" required class="w-full bg-slate-900 border border-white/10 p-2.5 rounded-xl text-white text-sm outline-none focus:border-cyan-500">
                        <input type="text" name="nama" placeholder="Nama Lengkap" value="<?= $edit['nama'] ?? '' ?>" required class="w-full bg-slate-900 border border-white/10 p-2.5 rounded-xl text-white text-sm outline-none focus:border-cyan-500 uppercase">
                        <input type="text" name="password" placeholder="Password (Default: 12345678)" class="w-full bg-slate-900 border border-white/10 p-2.5 rounded-xl text-white text-sm outline-none focus:border-cyan-500">
                        <div class="grid grid-cols-2 gap-2">
                            <select name="jk" class="bg-slate-900 border border-white/10 p-2.5 rounded-xl text-white text-sm">
                                <option value="L" <?= ($edit['jk'] ?? '') == 'L' ? 'selected' : '' ?>>L</option>
                                <option value="P" <?= ($edit['jk'] ?? '') == 'P' ? 'selected' : '' ?>>P</option>
                            </select>
                            <select name="status" class="bg-slate-900 border border-white/10 p-2.5 rounded-xl text-white text-sm">
                                <option value="LULUS" <?= ($edit['status'] ?? '') == 'LULUS' ? 'selected' : '' ?>>LULUS</option>
                                <option value="TIDAK LULUS" <?= ($edit['status'] ?? '') == 'TIDAK LULUS' ? 'selected' : '' ?>>TIDAK LULUS</option>
                                <option value="TUNDA" <?= ($edit['status'] ?? '') == 'TUNDA' ? 'selected' : '' ?>>TUNDA</option>
                            </select>
                        </div>
                        <input type="date" name="tgl_lahir" value="<?= $edit['tgl_lahir'] ?? '' ?>" required class="w-full bg-slate-900 border border-white/10 p-2.5 rounded-xl text-white text-sm">
                        <button name="save" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-3 rounded-xl transition uppercase text-[10px] tracking-widest shadow-lg">Simpan</button>
                        <?php if($edit): ?> <a href="admin_dashboard.php" class="block text-center text-slate-400 text-[10px] uppercase font-bold hover:text-white mt-2">Batal Edit</a> <?php endif; ?>
                    </form>
                </div>

                <div class="glass-panel p-5">
                    <p class="text-white text-[10px] font-bold mb-3 uppercase tracking-widest">Import CSV</p>
                    <form action="impor.php" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                        <input type="file" name="file_csv" required class="text-[10px] bg-white/5 p-2 rounded-lg border border-white/10 text-slate-400">
                        <button name="import" class="bg-blue-600 py-2 rounded-lg text-[10px] font-bold hover:bg-blue-500 uppercase">Proses Import</button>
                    </form>
                    <hr class="border-white/10 my-3">
                    <form method="POST" onsubmit="return confirm('Hapus Semua Data?')">
                        <button name="reset_db" class="w-full bg-red-600/10 text-red-500 border border-red-500/20 py-2 rounded-lg text-[9px] font-bold hover:bg-red-600 hover:text-white transition uppercase">Kosongkan Database</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-9">
                <div class="glass-panel overflow-hidden">
                    <div class="p-4 bg-slate-900/50 text-center border-b border-white/5">
                        <h2 class="text-sm font-bold text-white tracking-widest uppercase">DATA NAMA SISWA</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead class="bg-slate-950/80 text-[10px] text-cyan-400 font-bold uppercase tracking-widest">
                                <tr>
                                    <th class="p-4 text-center">#</th>
                                    <th class="p-4">NISN</th>
                                    <th class="p-4">NAMA LENGKAP</th>
                                    <th class="p-4">USERNAME</th>
                                    <th class="p-4">PASSWORD</th>
                                    <th class="p-4 text-center">L/P</th>
                                    <th class="p-4">TGL LAHIR</th>
                                    <th class="p-4 text-center">STATUS</th>
                                    <th class="p-4 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <?php $no=1; foreach($siswas as $s): ?>
                                <tr class="hover:bg-cyan-500/10 transition text-xs">
                                    <td class="p-4 text-center text-slate-500 font-mono"><?= $no++ ?></td>
                                    <td class="p-4 text-slate-300 font-mono"><?= $s['nisn'] ?></td>
                                    <td class="p-4 font-bold text-white uppercase"><?= $s['nama'] ?></td>
                                    <td class="p-4 text-cyan-400/80 font-bold"><?= $s['username'] ?></td>
                                    <td class="p-4 text-slate-500 font-mono text-[10px] tracking-widest">********</td>
                                    <td class="p-4 text-center font-black text-slate-300"><?= $s['jk'] ?></td>
                                    <td class="p-4 font-mono text-slate-400"><?= $s['tgl_lahir'] ?></td>
                                    <td class="p-4 text-center">
                                        <?php 
                                            $badge = "border-yellow-500/50 text-yellow-400 bg-yellow-500/10";
                                            if($s['status'] == 'LULUS') $badge = "border-green-500/50 text-green-400 bg-green-500/10";
                                            if($s['status'] == 'TIDAK LULUS') $badge = "border-red-500/50 text-red-400 bg-red-500/10";
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-[9px] font-bold border <?= $badge ?> uppercase"><?= $s['status'] ?></span>
                                    </td>
                                    <td class="p-4 text-center space-x-2">
                                        <a href="?edit=<?= $s['id'] ?>" class="text-yellow-500 hover:text-white font-bold uppercase text-[9px]">Edit</a>
                                        <span class="text-slate-600">|</span>
                                        <a href="?del=<?= $s['id'] ?>" onclick="return confirm('Hapus?')" class="text-red-500 hover:text-white font-bold uppercase text-[9px]">Del</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($_GET['msg'])): ?><script>alert("<?= htmlspecialchars($_GET['msg']) ?>");</script><?php endif; ?>
</body>
</html>
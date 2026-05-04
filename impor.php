<?php
require 'koneksi.php';

if (isset($_POST['import'])) {
    $file = $_FILES['file_csv']['tmp_name'];
    $handle = fopen($file, "r");
    
    // Lewati baris pertama (Judul Kolom CSV)
    fgetcsv($handle, 1000, ";");
    
    $ok = 0;
    $db->beginTransaction();
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if (empty($data[0])) continue;
        
        // URUTAN INI SUDAH DISESUAIKAN DENGAN FILE CSV ASLI KAMU!
        $nisn = trim($data[0]);
        $nama = trim($data[1]);
        $user = trim($data[2]); // Username ngambil langsung dari CSV
        $jk   = strtoupper(trim($data[3])); // L atau P
        $tgl  = trim($data[4]); // Tanggal Lahir (cth: 2007-12-08)
        $stat = strtoupper(trim($data[5])); // LULUS / TIDAK LULUS / TUNDA
        $pass_csv = isset($data[6]) ? trim($data[6]) : '12345678';
        
        // Bersihkan tulisan status
        if ($stat == 'TDK LULUS' || $stat == 'TIDAK LULUS') $stat = 'TIDAK LULUS';
        
        $hash = password_hash($pass_csv, PASSWORD_DEFAULT);

        // Masukkan ke database
        $sql = "INSERT OR REPLACE INTO siswa (nisn, nama, username, password, status, jk, tgl_lahir) VALUES (?,?,?,?,?,?,?)";
        $db->prepare($sql)->execute([$nisn, $nama, $user, $hash, $stat, $jk, $tgl]);
        $ok++;
    }
    $db->commit();
    fclose($handle);
    header("Location: admin_dashboard.php?msg=MANTAP! Import $ok Siswa Sempurna!"); exit;
}
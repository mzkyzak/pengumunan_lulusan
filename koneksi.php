<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tabel Admin
    $db->exec("CREATE TABLE IF NOT EXISTS admin (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT,
        username TEXT UNIQUE,
        password TEXT
    )");

    // Tabel Siswa
    $db->exec("CREATE TABLE IF NOT EXISTS siswa (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nisn TEXT UNIQUE,
        nama TEXT,
        username TEXT UNIQUE,
        password TEXT,
        status TEXT,
        jk TEXT,
        tgl_lahir TEXT
    )");

    // Akun Admin Default
    $cekAdmin = $db->query("SELECT COUNT(*) FROM admin")->fetchColumn();
    if ($cekAdmin == 0) {
        $pwAdmin = password_hash('admin123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO admin (nama, username, password) VALUES ('Admin MzMkyzak', 'admin', '$pwAdmin')");
    }
} catch (PDOException $e) {
    die("Koneksi Gagal: " . $e->getMessage());
}
?>
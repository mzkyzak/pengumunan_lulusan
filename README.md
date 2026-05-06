# 🎓 Sistem Validasi Kelulusan Siswa TUGAS KELOMPOK by:mzkyzak

Aplikasi Web Sistem Informasi Pengumuman dan Validasi Kelulusan Siswa berbasis **PHP Native** dan **SQLite**. Dibangun dengan antarmuka (UI/UX) *Premium Dark Glassmorphism* menggunakan **Tailwind CSS**. Sistem ini dirancang sangat portabel, aman, dan siap digunakan untuk instansi sekolah tanpa konfigurasi database yang rumit.

![Tampilan Dashboard](https://img.shields.io/badge/UI-Kelompok1-cyan?style=for-the-badge)
![PHP Native](https://img.shields.io/badge/PHP-Native-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

---

## ✨ Fitur Unggulan

### 🧑‍🎓 Akses Siswa (Portal Kelulusan)
* **Smart Login (Auto-Toleransi):** Siswa dapat login menggunakan Nama/Username dengan mengabaikan huruf besar/kecil maupun spasi. Sangat *user-friendly*!
* **Dashboard Estetik:** Tampilan profil siswa dengan animasi *glowing orbs* dan *glassmorphism*.
* **Surat Kelulusan Dinamis:** Warna dan ikon surat menyesuaikan status secara otomatis:
    * 🟩 **LULUS** (Tema Hijau)
    * 🟥 **TIDAK LULUS** (Tema Merah)
    * 🟨 **TUNDA** (Tema Kuning)
* **Cetak PDF Full Color:** Mendukung pencetakan bukti kelulusan (*Print to PDF*) dengan format yang presisi, rapi, dan tetap mempertahankan warna (*full color*).

### 👨‍💻 Akses Admin (Manajemen Data)
* **Dashboard Statistik:** Menampilkan total siswa dan persentase status kelulusan secara *real-time*.
* **CRUD Data Siswa:** Tambah, Edit, dan Hapus data siswa secara manual. Termasuk edit *password* siswa.
* **Import EXEL Bentuk .CSV :** Fitur *upload* data siswa massal via file `.csv`. Sistem akan otomatis membaca kolom dengan tepat (Anti-Terbalik).
* **Reset Database:** Tombol sekali klik untuk mengosongkan seluruh data siswa dengan aman.
* **Portable Database:** Menggunakan **SQLite**, tidak perlu repot *export/import* di `phpMyAdmin`. Tinggal *copy-paste* folder, aplikasi langsung jalan!

---
## WAJIB DELETE JIKA INGIN CREATE DATA SISWA BARU ADA DI FOLDER/database.sqlite
*  Karena fungsi db.sqlite itu untuk membuat ALL Database data siswa, secara otomatis melalui Mengimpor CSV dari sebuah excel 
---

## 🚀 Cara Instalasi & Penggunaan

Karena menggunakan **SQLite**, instalasi aplikasi ini sangat mudah:

1. **Clone/Download** repositori ini.
2. Ekstrak dan pindahkan folder *project* ke dalam direktori *server* lokal Anda (contoh: `C:/xampp/htdocs/pengumuman_kelulusan`).
3. Nyalakan **Apache** pada XAMPP/Laragon.
4. Buka browser dan akses: `http://localhost/pengumuman_kelulusan/index.php`

### Akun Default Admin:
* **Username:** `admin`
* **Password:** `admin123`

---

## 📄 Format Import CSV

Jika ingin menggunakan fitur **Import CSV**, pastikan file Excel/CSV Anda menggunakan pemisah titik koma (`;`) dengan urutan 7 kolom tepat seperti berikut (termasuk baris pertama untuk judul header):

```csv
NISN ; Nama Lengkap ; Username Login ; L/P ; Tanggal Lahir ; Status ; Password
12345678 ; TAUFIQ IKHSAN MUZAKY ; mzkyzak ; L ; 2008-06-18 ; LULUS ; 12345678

# Sistem Informasi Perpustakaan Digital (PHP Native)

Aplikasi manajemen perpustakaan multi-user (Admin & Siswa) berbasis **PHP Native**, **MySQL**, dan **CSS3/JS Native** yang responsif untuk perangkat mobile maupun desktop.

## Struktur Folder
```text
perpus_digital_php/
├── index.php               # Halaman Login & Registrasi Multi-User
├── databaseperpus.sql      # Skema Database MySQL + Data Awal
├── config/
│   └── koneksi.php         # Konfigurasi Koneksi MySQL & Session
├── auth/
│   ├── proses_login.php    # Validasi Login Multi-Role
│   ├── proses_register.php # Pendaftaran Anggota Siswa Baru
│   └── logout.php          # Hapus Session
├── admin/
│   ├── dashboard.php       # Dashboard Admin (Buku, Anggota, Transaksi)
│   └── proses_admin.php    # Logika CRUD Buku, Anggota & Pengembalian
├── siswa/
│   ├── dashboard.php       # Dashboard Siswa (Katalog & Riwayat Pinjam)
│   └── proses_siswa.php    # Logika Peminjaman & Pengembalian Mandiri
└── assets/
    ├── css/style.css       # Styling Mobile-First Responsive
    ├── js/script.js        # Interaktivitas UI, Modal & Sidebar Mobile
    └── img/logo.svg        # Logo Vektor Aplikasi
```

## Cara Instalasi
1. Ekstrak folder `perpus_digital_php` ke dalam direktori `htdocs/` (XAMPP) atau `www/` (Laragon).
2. Buka **phpMyAdmin**, buat database baru bernama `db_perpus_digital` (atau langsung import file `databaseperpus.sql`).
3. Sesuaikan pengaturan database di `config/koneksi.php` jika diperlukan.
4. Akses aplikasi melalui browser: `http://localhost/apps_perpustakaan/`

## Akun Demo
- **Admin**: Username `admin` | Password `admin123`
- **Siswa**: NIS `siswa` | Password `siswa123`

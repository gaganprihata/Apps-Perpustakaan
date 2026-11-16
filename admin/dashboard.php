<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'buku';

// Statistik
$jml_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM buku"))['total'];
$jml_anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota"))['total'];
$jml_pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE status='Dipinjam'"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PerpusDigital</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="app-layout">
        <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

        <!-- SIDEBAR ADMIN -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-brand">
                <img src="../assets/img/logo.svg" alt="Logo" width="34" height="34">
                <div>
                    <h2>PerpusDigital</h2>
                    <span class="badge badge-admin">Administrator</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="?tab=buku" class="nav-item <?= $tab === 'buku' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Kelola Data Buku
                </a>
                <a href="?tab=anggota" class="nav-item <?= $tab === 'anggota' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Kelola Anggota
                </a>
                <a href="?tab=transaksi" class="nav-item <?= $tab === 'transaksi' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    Transaksi Peminjaman
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="../auth/logout.php" class="btn btn-danger btn-block">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-wrapper">
            <header class="topbar">
                <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h3>Dashboard Admin</h3>
                <div class="user-profile">
                    <div class="avatar"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
                    <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
                </div>
            </header>

            <main class="content-area">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
                <?php endif; ?>

                <!-- STATS CARDS -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon badge-admin">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                        <div><small>Total Koleksi</small><h3><?= $jml_buku ?> Judul</h3></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon badge-siswa">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <div><small>Total Siswa</small><h3><?= $jml_anggota ?> Anggota</h3></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon badge-warning">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div><small>Sedang Dipinjam</small><h3><?= $jml_pinjam ?> Buku</h3></div>
                    </div>
                </div>

                <?php if ($tab === 'buku'): ?>
                    <!-- TABEL BUKU -->
                    <div class="card-box">
                        <div class="section-header">
                            <h4>Manajemen Koleksi Buku</h4>
                            <button class="btn btn-primary btn-sm" onclick="openModal('modalTambahBuku')">+ Tambah Buku</button>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr><th>Judul Buku</th><th>Penulis</th><th>Kategori</th><th>Stok</th><th>Aksi</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_buku = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");
                                    while ($b = mysqli_fetch_assoc($q_buku)):
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($b['judul']) ?></strong></td>
                                        <td><?= htmlspecialchars($b['penulis']) ?></td>
                                        <td><span class="badge badge-admin"><?= htmlspecialchars($b['kategori']) ?></span></td>
                                        <td><strong><?= $b['stok'] ?></strong></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editBookModal(<?= $b['id'] ?>, '<?= htmlspecialchars(addslashes($b['judul'])) ?>', '<?= htmlspecialchars(addslashes($b['penulis'])) ?>', '<?= htmlspecialchars(addslashes($b['kategori'])) ?>', <?= $b['stok'] ?>)">Edit</button>
                                            <a href="proses_admin.php?aksi=hapus_buku&id=<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus buku ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($tab === 'anggota'): ?>
                    <!-- TABEL ANGGOTA -->
                    <div class="card-box">
                        <div class="section-header">
                            <h4>Manajemen Anggota Siswa</h4>
                            <button class="btn btn-primary btn-sm" onclick="openModal('modalTambahAnggota')">+ Tambah Anggota</button>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr><th>Nama Lengkap</th><th>NIS / Username</th><th>Terdaftar</th><th>Aksi</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_ang = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id DESC");
                                    while ($a = mysqli_fetch_assoc($q_ang)):
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($a['nama_lengkap']) ?></strong></td>
                                        <td><?= htmlspecialchars($a['nis']) ?></td>
                                        <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                                        <td>
                                            <a href="proses_admin.php?aksi=hapus_anggota&id=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus anggota ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($tab === 'transaksi'): ?>
                    <!-- TABEL TRANSAKSI -->
                    <div class="card-box">
                        <div class="section-header">
                            <h4>Kontrol Peminjaman & Pengembalian</h4>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr><th>Peminjam</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Aksi</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_tx = mysqli_query($conn, "SELECT t.*, a.nama_lengkap, b.judul FROM transaksi t JOIN anggota a ON t.anggota_id = a.id JOIN buku b ON t.buku_id = b.id ORDER BY t.id DESC");
                                    while ($t = mysqli_fetch_assoc($q_tx)):
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($t['nama_lengkap']) ?></strong></td>
                                        <td><?= htmlspecialchars($t['judul']) ?></td>
                                        <td><?= $t['tanggal_pinjam'] ?></td>
                                        <td><?= $t['tanggal_jatuh_tempo'] ?></td>
                                        <td>
                                            <span class="badge <?= $t['status'] === 'Dipinjam' ? 'badge-warning' : 'badge-siswa' ?>">
                                                <?= $t['status'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($t['status'] === 'Dipinjam'): ?>
                                                <a href="proses_admin.php?aksi=kembali_buku&id=<?= $t['id'] ?>" class="btn btn-emerald btn-sm">Proses Kembali</a>
                                            <?php else: ?>
                                                <small>Dikembalikan (<?= $t['tanggal_kembali'] ?>)</small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- MODAL TAMBAH BUKU -->
    <div id="modalTambahBuku" class="modal-backdrop hidden">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Tambah Buku Baru</h3>
                <button class="modal-close" onclick="closeModal('modalTambahBuku')">&times;</button>
            </div>
            <form action="proses_admin.php?aksi=tambah_buku" method="POST">
                <div class="input-group"><label>Judul Buku</label><input type="text" name="judul" required></div>
                <div class="input-group"><label>Penulis</label><input type="text" name="penulis" required></div>
                <div class="input-group"><label>Kategori</label><input type="text" name="kategori" required></div>
                <div class="input-group"><label>Stok</label><input type="number" name="stok" min="0" value="1" required></div>
                <button type="submit" class="btn btn-primary btn-block">Simpan Buku</button>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT BUKU -->
    <div id="modalEditBuku" class="modal-backdrop hidden">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Edit Data Buku</h3>
                <button class="modal-close" onclick="closeModal('modalEditBuku')">&times;</button>
            </div>
            <form action="proses_admin.php?aksi=edit_buku" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="input-group"><label>Judul Buku</label><input type="text" name="judul" id="edit_judul" required></div>
                <div class="input-group"><label>Penulis</label><input type="text" name="penulis" id="edit_penulis" required></div>
                <div class="input-group"><label>Kategori</label><input type="text" name="kategori" id="edit_kategori" required></div>
                <div class="input-group"><label>Stok</label><input type="number" name="stok" id="edit_stok" min="0" required></div>
                <button type="submit" class="btn btn-primary btn-block">Perbarui Buku</button>
            </form>
        </div>
    </div>

    <!-- MODAL TAMBAH ANGGOTA -->
    <div id="modalTambahAnggota" class="modal-backdrop hidden">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Tambah Anggota Siswa</h3>
                <button class="modal-close" onclick="closeModal('modalTambahAnggota')">&times;</button>
            </div>
            <form action="proses_admin.php?aksi=tambah_anggota" method="POST">
                <div class="input-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" required></div>
                <div class="input-group"><label>NIS / Username</label><input type="text" name="nis" required></div>
                <div class="input-group"><label>Password</label><input type="password" name="password" required></div>
                <button type="submit" class="btn btn-primary btn-block">Simpan Anggota</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>

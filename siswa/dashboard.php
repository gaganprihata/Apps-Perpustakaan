<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../index.php");
    exit;
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'katalog';
$anggota_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa - PerpusDigital</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="app-layout">
        <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

        <!-- SIDEBAR SISWA -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-brand">
                <img src="../assets/img/logo.svg" alt="Logo" width="34" height="34">
                <div>
                    <h2>PerpusDigital</h2>
                    <span class="badge badge-siswa">Anggota Siswa</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="?tab=katalog" class="nav-item <?= $tab === 'katalog' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Katalog Buku
                </a>
                <a href="?tab=riwayat" class="nav-item <?= $tab === 'riwayat' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Peminjaman Saya
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
                <h3>Portal Anggota</h3>
                <div class="user-profile">
                    <div class="avatar" style="background: var(--emerald);"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
                    <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
                </div>
            </header>

            <main class="content-area">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['err'])): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($_GET['err']) ?></div>
                <?php endif; ?>

                <?php if ($tab === 'katalog'): ?>
                    <div class="section-header">
                        <h4>Katalog Buku Tersedia</h4>
                    </div>
                    <div class="books-grid">
                        <?php
                        $q_buku = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul ASC");
                        while ($b = mysqli_fetch_assoc($q_buku)):
                        ?>
                        <div class="book-card">
                            <div>
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <span class="badge badge-admin"><?= htmlspecialchars($b['kategori']) ?></span>
                                    <small><strong>Stok: <?= $b['stok'] ?></strong></small>
                                </div>
                                <h4><?= htmlspecialchars($b['judul']) ?></h4>
                                <p>Penulis: <?= htmlspecialchars($b['penulis']) ?></p>
                            </div>
                            <?php if ($b['stok'] > 0): ?>
                                <a href="proses_siswa.php?aksi=pinjam&buku_id=<?= $b['id'] ?>" class="btn btn-emerald btn-block" onclick="return confirm('Pinjam buku ini selama 7 hari?')">Pinjam Buku</a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-block" disabled>Stok Habis</button>
                            <?php endif; ?>
                        </div>
                        <?php endwhile; ?>
                    </div>

                <?php elseif ($tab === 'riwayat'): ?>
                    <div class="card-box">
                        <div class="section-header">
                            <h4>Status & Riwayat Peminjaman Anda</h4>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr><th>Judul Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Aksi Mandiri</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_tx = mysqli_query($conn, "SELECT t.*, b.judul FROM transaksi t JOIN buku b ON t.buku_id = b.id WHERE t.anggota_id = $anggota_id ORDER BY t.id DESC");
                                    if (mysqli_num_rows($q_tx) === 0):
                                    ?>
                                        <tr><td colspan="5">Anda belum memiliki riwayat peminjaman buku.</td></tr>
                                    <?php endif;
                                    while ($t = mysqli_fetch_assoc($q_tx)):
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($t['judul']) ?></strong></td>
                                        <td><?= $t['tanggal_pinjam'] ?></td>
                                        <td><?= $t['tanggal_jatuh_tempo'] ?></td>
                                        <td>
                                            <span class="badge <?= $t['status'] === 'Dipinjam' ? 'badge-warning' : 'badge-siswa' ?>">
                                                <?= $t['status'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($t['status'] === 'Dipinjam'): ?>
                                                <a href="proses_siswa.php?aksi=kembalikan&tx_id=<?= $t['id'] ?>" class="btn btn-emerald btn-sm" onclick="return confirm('Kembalikan buku ini sekarang?')">Kembalikan Buku</a>
                                            <?php else: ?>
                                                <small>Selesai (<?= $t['tanggal_kembali'] ?>)</small>
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
    <script src="../assets/js/script.js"></script>
</body>
</html>

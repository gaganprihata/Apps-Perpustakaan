<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../index.php");
    exit;
}

$aksi = $_GET['aksi'] ?? '';
$anggota_id = $_SESSION['user_id'];

if ($aksi === 'pinjam' && isset($_GET['buku_id'])) {
    $buku_id = (int)$_GET['buku_id'];
    $buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM buku WHERE id=$buku_id"));

    if ($buku && $buku['stok'] > 0) {
        $tgl_pinjam = date('Y-m-d');
        $tgl_tempo  = date('Y-m-d', strtotime('+7 days'));

        mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id=$buku_id");
        mysqli_query($conn, "INSERT INTO transaksi (anggota_id, buku_id, tanggal_pinjam, tanggal_jatuh_tempo, status) VALUES ($anggota_id, $buku_id, '$tgl_pinjam', '$tgl_tempo', 'Dipinjam')");
        header("Location: dashboard.php?tab=katalog&msg=" . urlencode("Berhasil meminjam buku! Harap dikembalikan sebelum $tgl_tempo."));
    } else {
        header("Location: dashboard.php?tab=katalog&err=" . urlencode("Maaf, stok buku sudah habis."));
    }
} elseif ($aksi === 'kembalikan' && isset($_GET['tx_id'])) {
    $tx_id = (int)$_GET['tx_id'];
    $tx = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$tx_id AND anggota_id=$anggota_id AND status='Dipinjam'"));

    if ($tx) {
        $tgl_kembali = date('Y-m-d');
        mysqli_query($conn, "UPDATE transaksi SET status='Dikembalikan', tanggal_kembali='$tgl_kembali' WHERE id=$tx_id");
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id=" . $tx['buku_id']);
        header("Location: dashboard.php?tab=riwayat&msg=" . urlencode("Buku berhasil dikembalikan!"));
    } else {
        header("Location: dashboard.php?tab=riwayat&err=" . urlencode("Transaksi tidak valid."));
    }
}
exit;
?>

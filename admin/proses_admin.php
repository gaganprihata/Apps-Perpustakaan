<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$aksi = $_GET['aksi'] ?? '';

if ($aksi === 'tambah_buku' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $stok     = (int)$_POST['stok'];

    mysqli_query($conn, "INSERT INTO buku (judul, penulis, kategori, stok) VALUES ('$judul', '$penulis', '$kategori', $stok)");
    header("Location: dashboard.php?tab=buku&msg=" . urlencode("Buku baru berhasil ditambahkan!"));
} elseif ($aksi === 'edit_buku' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int)$_POST['id'];
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $stok     = (int)$_POST['stok'];

    mysqli_query($conn, "UPDATE buku SET judul='$judul', penulis='$penulis', kategori='$kategori', stok=$stok WHERE id=$id");
    header("Location: dashboard.php?tab=buku&msg=" . urlencode("Data buku berhasil diperbarui!"));
} elseif ($aksi === 'hapus_buku' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM buku WHERE id=$id");
    header("Location: dashboard.php?tab=buku&msg=" . urlencode("Buku berhasil dihapus!"));
} elseif ($aksi === 'tambah_anggota' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nis  = mysqli_real_escape_string($conn, $_POST['nis']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO anggota (nis, nama_lengkap, password) VALUES ('$nis', '$nama', '$pass')");
    header("Location: dashboard.php?tab=anggota&msg=" . urlencode("Anggota baru berhasil ditambahkan!"));
} elseif ($aksi === 'hapus_anggota' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM anggota WHERE id=$id");
    header("Location: dashboard.php?tab=anggota&msg=" . urlencode("Anggota berhasil dihapus!"));
} elseif ($aksi === 'kembali_buku' && isset($_GET['id'])) {
    $tx_id = (int)$_GET['id'];
    $tx = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$tx_id AND status='Dipinjam'"));
    if ($tx) {
        $tgl_kembali = date('Y-m-d');
        mysqli_query($conn, "UPDATE transaksi SET status='Dikembalikan', tanggal_kembali='$tgl_kembali' WHERE id=$tx_id");
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id=" . $tx['buku_id']);
    }
    header("Location: dashboard.php?tab=transaksi&msg=" . urlencode("Pengembalian buku berhasil diproses!"));
}
exit;
?>

<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama_lengkap']));
    $nis  = mysqli_real_escape_string($conn, trim($_POST['nis']));
    $pass = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT id FROM anggota WHERE nis = '$nis'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: ../index.php?error=" . urlencode("NIS / Username sudah terdaftar!"));
        exit;
    }

    $insert = mysqli_query($conn, "INSERT INTO anggota (nis, nama_lengkap, password) VALUES ('$nis', '$nama', '$pass')");
    if ($insert) {
        header("Location: ../index.php?success=" . urlencode("Pendaftaran berhasil! Silakan login sebagai Siswa."));
    } else {
        header("Location: ../index.php?error=" . urlencode("Gagal mendaftar. Coba lagi."));
    }
    exit;
}
?>

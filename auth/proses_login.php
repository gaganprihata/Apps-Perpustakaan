<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = $_POST['role'];
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    if ($role === 'admin') {
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
        if ($row = mysqli_fetch_assoc($query)) {
            if ($password === $row['password'] || password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nama']    = $row['nama_lengkap'];
                $_SESSION['role']    = 'admin';
                header("Location: ../admin/dashboard.php");
                exit;
            }
        }
        header("Location: ../index.php?error=" . urlencode("Username atau Password Admin salah!"));
        exit;
    } else {
        $query = mysqli_query($conn, "SELECT * FROM anggota WHERE nis = '$username'");
        if ($row = mysqli_fetch_assoc($query)) {
            if ($password === $row['password'] || password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nis']     = $row['nis'];
                $_SESSION['nama']    = $row['nama_lengkap'];
                $_SESSION['role']    = 'siswa';
                header("Location: ../siswa/dashboard.php");
                exit;
            }
        }
        header("Location: ../index.php?error=" . urlencode("NIS tidak ditemukan atau kata sandi salah!"));
        exit;
    }
}
?>

<?php
require_once 'config/koneksi.php';

// Redirect jika sudah login
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] === 'siswa') {
        header("Location: siswa/dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Perpustakaan Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <img src="assets/img/logo.svg" alt="Logo PerpusDigital" class="brand-logo">
                <h1>PerpusDigital</h1>
                <p>Sistem Informasi Perpustakaan Native PHP</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <!-- Role Switcher -->
            <div id="roleSwitcher" class="role-tabs">
                <button type="button" class="role-tab active" data-role="admin" onclick="switchRole('admin')">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Admin
                </button>
                <button type="button" class="role-tab" data-role="siswa" onclick="switchRole('siswa')">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Siswa
                </button>
            </div>

            <!-- FORM LOGIN -->
            <form id="loginForm" action="auth/proses_login.php" method="POST">
                <input type="hidden" name="role" id="roleInput" value="admin">
                <div class="input-group">
                    <label>Username / NIS</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" name="username" placeholder="Masukkan username atau NIS" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Kata Sandi</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" name="password" id="loginPassword" placeholder="Masukkan kata sandi" required>
                        <button type="button" class="toggle-pass" onclick="togglePassword('loginPassword')">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <span>Masuk Dashboard</span>
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>

                <div id="registerLinkBox" class="auth-footer-link hidden">
                    Belum punya akun anggota? <a href="javascript:void(0)" onclick="toggleAuthMode('register')">Daftar Siswa</a>
                </div>

                <div class="demo-box">
                    <strong>Akun Demo Default:</strong>
                    <div>• Admin: <code>admin</code> / <code>admin123</code></div>
                    <div>• Siswa: <code>budi</code> / <code>siswa123</code></div>
                </div>
            </form>

            <!-- FORM REGISTER SISWA -->
            <form id="registerForm" class="hidden" action="auth/proses_register.php" method="POST">
                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Contoh: Ahmad Fauzi" required>
                </div>
                <div class="input-group">
                    <label>NIS / Username</label>
                    <input type="text" name="nis" placeholder="Contoh: 2026005" required>
                </div>
                <div class="input-group">
                    <label>Buat Kata Sandi</label>
                    <input type="password" name="password" placeholder="Masukkan kata sandi" required>
                </div>
                <div class="btn-row">
                    <button type="button" class="btn btn-secondary" onclick="toggleAuthMode('login')">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </section>

    <script src="assets/js/script.js"></script>
</body>
</html>

function switchRole(role) {
    document.getElementById('roleInput').value = role;
    document.querySelectorAll('.role-tab').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.role === role);
    });
    const regBox = document.getElementById('registerLinkBox');
    if (regBox) {
        regBox.classList.toggle('hidden', role === 'admin');
    }
}

function toggleAuthMode(mode) {
    document.getElementById('loginForm').classList.toggle('hidden', mode === 'register');
    document.getElementById('roleSwitcher').classList.toggle('hidden', mode === 'register');
    document.getElementById('registerForm').classList.toggle('hidden', mode === 'login');
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}

function toggleMobileSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('active');
}

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function editBookModal(id, judul, penulis, kategori, stok) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_judul').value = judul;
    document.getElementById('edit_penulis').value = penulis;
    document.getElementById('edit_kategori').value = kategori;
    document.getElementById('edit_stok').value = stok;
    openModal('modalEditBuku');
}

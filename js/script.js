// StudentMS — script.js

document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar Toggle (mobile) ──
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    // ── Auto-dismiss alerts ──
    const alerts = document.querySelectorAll('.alert-dismissible, .alert.auto-dismiss');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });

    // ── Delete confirmation ──
    const deleteLinks = document.querySelectorAll('.btn-delete-confirm');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            if (!confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // ── Password strength indicator ──
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrength');
    if (passwordInput && strengthBar) {
        passwordInput.addEventListener('input', function () {
            const val = this.value;
            let strength = 0;
            if (val.length >= 6) strength++;
            if (val.length >= 10) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const colors = ['#f85149','#f5a623','#f5a623','#3fb950','#3fb950'];
            const widths = ['20%','40%','60%','80%','100%'];
            strengthBar.style.width = strength > 0 ? widths[strength-1] : '0';
            strengthBar.style.background = strength > 0 ? colors[strength-1] : '';
        });
    }

    // ── Confirm password match ──
    const confirmPwd = document.getElementById('confirm_password');
    if (confirmPwd && passwordInput) {
        confirmPwd.addEventListener('input', function () {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Passwords do not match');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
    }

    // ── Search: highlight matching text ──
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.focus();
    }

    // ── Phone number: allow only digits and + ──
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
        });
    }
});

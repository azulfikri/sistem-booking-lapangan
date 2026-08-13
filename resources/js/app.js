import axios from 'axios';

// ============================================================
// AXIOS SETUP
// ============================================================
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF Token
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
}

// ============================================================
// FLASH MESSAGE AUTO-DISMISS
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
    // Auto dismiss flash messages after 5 seconds
    const alerts = document.querySelectorAll('[data-auto-dismiss]');
    alerts.forEach(alert => {
        const delay = parseInt(alert.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(20px)';
            setTimeout(() => alert.remove(), 400);
        }, delay);
    });

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay?.classList.toggle('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    }

    // Confirm delete dialogs
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm(el.dataset.confirm || 'Apakah Anda yakin?')) {
                e.preventDefault();
            }
        });
    });
});

// ============================================================
// HELPER: Format Rupiah
// ============================================================
window.formatRupiah = function(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
};

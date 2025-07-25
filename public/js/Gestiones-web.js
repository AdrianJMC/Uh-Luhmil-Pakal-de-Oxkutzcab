// -----------------------------
// Tabs (index.blade.php)
// -----------------------------
document.addEventListener('DOMContentLoaded', () => {
    const tabLinks = document.querySelectorAll('#sectionTabs a[data-bs-toggle="tab"]');
    tabLinks.forEach(tabEl => {
        const tab = new bootstrap.Tab(tabEl);
        tabEl.addEventListener('click', e => {
            e.preventDefault();
            tab.show();
            history.replaceState(null, null, tabEl.getAttribute('href'));
        });
    });

    // Mostrar tab desde hash de URL
    const hash = window.location.hash;
    if (hash) {
        const targetLink = document.querySelector(`#sectionTabs a[href="${hash}"]`);
        if (targetLink) {
            new bootstrap.Tab(targetLink).show();
        }
    }

    // -----------------------------
    // Alerta de éxito (edit.blade.php)
    // -----------------------------
    const alertEl = document.getElementById('success-alert');
    if (alertEl) {
        setTimeout(() => {
            alertEl.classList.remove('show');
            setTimeout(() => alertEl.remove(), 300);
        }, 3000);
    }
});

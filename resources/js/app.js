// APC public site + admin interactions
import * as bootstrap from 'bootstrap';

// Auto-dismiss flash messages after 5s
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.alert-dismissible.fade.show').forEach((el) => {
        setTimeout(() => {
            try { bootstrap.Alert.getOrCreateInstance(el).close(); } catch (e) {}
        }, 5000);
    });

    // Confirm destructive forms
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
    });
});

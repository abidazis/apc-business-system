// APC public site + admin interactions
import * as bootstrap from 'bootstrap';
import Swal from 'sweetalert2';

// SweetAlert2 config - APC theme centered
const swalConfig = {
    customClass: {
        popup: 'apc-swal-popup',
        title: 'apc-swal-title',
        htmlContainer: 'apc-swal-text',
        confirmButton: 'apc-btn apc-btn-dark apc-btn-sm',
        cancelButton: 'apc-btn apc-btn-outline apc-btn-sm',
        actions: 'apc-swal-actions',
        icon: 'apc-swal-icon',
    },
    buttonsStyling: false,
    reverseButtons: true,
    showClass: {
        popup: 'swal2-show apc-swal-animate-in',
        backdrop: 'swal2-backdrop-show',
    },
    hideClass: {
        popup: 'swal2-hide',
        backdrop: 'swal2-backdrop-hide',
    },
};

// SweetAlert2 config for delete actions
const swalDeleteConfig = {
    customClass: {
        popup: 'apc-swal-popup',
        title: 'apc-swal-title',
        htmlContainer: 'apc-swal-text',
        confirmButton: 'apc-btn apc-btn-danger-confirm apc-btn-sm',
        cancelButton: 'apc-btn apc-btn-outline apc-btn-sm',
        actions: 'apc-swal-actions',
        icon: 'apc-swal-icon',
    },
    buttonsStyling: false,
    reverseButtons: true,
    showClass: {
        popup: 'swal2-show apc-swal-animate-in',
        backdrop: 'swal2-backdrop-show',
    },
    hideClass: {
        popup: 'swal2-hide',
        backdrop: 'swal2-backdrop-hide',
    },
};

// Inline confirm buttons (onclick="return confirm(...)")
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.alert-dismissible.fade.show').forEach((el) => {
        setTimeout(() => {
            try { bootstrap.Alert.getOrCreateInstance(el).close(); } catch (e) {}
        }, 5000);
    });

    // Confirm destructive forms with SweetAlert2
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = form.dataset.confirm || 'Apakah Anda yakin?';
            const isDelete = form.id === 'delete-order-form' || form.querySelector('.apc-btn-danger');

            Swal.fire({
                ...(isDelete ? swalDeleteConfig : swalConfig),
                title: isDelete ? 'Hapus Order?' : 'Konfirmasi',
                text: message,
                icon: isDelete ? 'error' : 'warning',
                showCancelButton: true,
                confirmButtonText: isDelete ? 'Ya, Hapus' : 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Inline confirm buttons
    document.querySelectorAll('[onclick*="confirm"]').forEach((el) => {
        const onclick = el.getAttribute('onclick') || '';
        const match = onclick.match(/confirm\s*\(\s*['"]([^'"]+)['"]\s*\)/);
        if (match) {
            el.removeAttribute('onclick');
            el.addEventListener('click', (e) => {
                e.preventDefault();
                Swal.fire({
                    ...swalConfig,
                    title: 'Konfirmasi',
                    text: match[1],
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = el.closest('form');
                        if (form) {
                            form.submit();
                        } else {
                            const href = el.getAttribute('href');
                            if (href) window.location.href = href;
                        }
                    }
                });
            });
        }
    });
});

// Helper function for inline usage
window.apcConfirm = (message, callback) => {
    Swal.fire({
        ...swalConfig,
        title: 'Konfirmasi',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
};

// Confirm Delete Order
window.confirmDeleteOrder = () => {
    const form = document.getElementById('delete-order-form');
    Swal.fire({
        ...swalConfig,
        title: 'Hapus Order?',
        text: 'Data order akan dihapus permanen. Pastikan Anda yakin dengan tindakan ini.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            ...swalConfig.customClass,
            confirmButton: 'apc-btn apc-btn-danger-confirm apc-btn-sm',
        },
    }).then((result) => {
        if (result.isConfirmed && form) {
            form.submit();
        }
    });
};

// Auto show flash toasts centered
window.showFlashToast = (type, message) => {
    Swal.fire({
        toast: true,
        position: 'center',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'apc-swal-popup apc-swal-toast-center',
            title: 'apc-swal-title apc-swal-title-sm',
        },
        buttonsStyling: false,
        showClass: {
            popup: 'swal2-show apc-swal-animate-in',
        },
        hideClass: {
            popup: 'swal2-hide',
        },
    });
};

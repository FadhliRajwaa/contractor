<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-500 opacity-0" style="display: none;">
    <!-- Background overlay -->
    <div class="confirmation-backdrop" id="modalOverlay"></div>
    
    <!-- Modal container -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal content -->
        <div class="relative inline-block align-bottom bg-white rounded-3xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all duration-500 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" id="modalContent">
            <!-- Decorative element -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-red-200 to-pink-200 rounded-full opacity-20 -mr-10 -mt-10"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-blue-200 to-purple-200 rounded-full opacity-20 -ml-8 -mb-8"></div>
            
            <div class="sm:flex sm:items-start relative z-10">
                <!-- Icon -->
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full sm:mx-0 sm:h-12 sm:w-12 mb-4 sm:mb-0" id="modalIcon">
                    <!-- Icon will be set dynamically -->
                </div>
                
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                    <!-- Title -->
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2" id="modalTitle">
                        Konfirmasi Aksi
                    </h3>
                    
                    <!-- Message -->
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 leading-relaxed" id="modalMessage">
                            Apakah Anda yakin ingin melanjutkan aksi ini?
                        </p>
                    </div>
                    
                    <!-- Additional info -->
                    <div class="mt-4 p-3 bg-gray-50 rounded-xl" id="modalInfo" style="display: none;">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs text-gray-500" id="modalInfoText"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="mt-6 sm:mt-6 sm:flex sm:flex-row-reverse space-y-2 sm:space-y-0 sm:space-x-2 sm:space-x-reverse">
                <!-- Confirm button -->
                <button type="button" 
                        id="confirmButton"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg px-6 py-3 text-base font-semibold text-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Ya, Lanjutkan
                </button>
                
                <!-- Cancel button -->
                <button type="button" 
                        id="cancelButton"
                        onclick="closeConfirmationModal()"
                        class="w-full inline-flex justify-center rounded-xl border-2 border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300 transform hover:scale-105 sm:mt-0 sm:w-auto sm:text-sm">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(-10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

@keyframes modalFadeOut {
    from {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
    to {
        opacity: 0;
        transform: scale(0.95) translateY(-10px);
    }
}

@keyframes iconBounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0, 0, 0);
    }
    40%, 43% {
        transform: translate3d(0, -8px, 0);
    }
    70% {
        transform: translate3d(0, -4px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

.modal-animate-in {
    animation: modalFadeIn 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.modal-animate-out {
    animation: modalFadeOut 0.3s ease-in;
}

.icon-bounce {
    animation: iconBounce 1s ease infinite;
}
</style>

<script>
class ConfirmationModal {
    constructor() {
        this.modal = document.getElementById('confirmationModal');
        this.modalContent = document.getElementById('modalContent');
        this.modalOverlay = document.getElementById('modalOverlay');
        this.isOpen = false;
        this.currentCallback = null;
        
        // Close modal when clicking outside
        this.modalOverlay.addEventListener('click', () => this.close());
        
        // Close modal with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }

    show(options = {}) {
        const {
            type = 'warning',
            title = 'Konfirmasi Aksi',
            message = 'Apakah Anda yakin ingin melanjutkan?',
            info = '',
            confirmText = 'Ya, Lanjutkan',
            cancelText = 'Batal',
            onConfirm = null,
            onCancel = null,
            dangerous = false
        } = options;

        // Set content
        this.setIcon(type);
        this.setTitle(title);
        this.setMessage(message);
        this.setInfo(info);
        this.setButtons(confirmText, cancelText, dangerous);
        
        // Set callbacks
        this.currentCallback = onConfirm;
        this.cancelCallback = onCancel;
        
        // Show modal
        this.open();
    }

    setIcon(type) {
        const iconContainer = document.getElementById('modalIcon');
        const icons = {
            warning: {
                bg: 'bg-gradient-to-br from-yellow-100 to-orange-100',
                icon: 'text-yellow-600',
                svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />`
            },
            danger: {
                bg: 'bg-gradient-to-br from-red-100 to-pink-100',
                icon: 'text-red-600',
                svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />`
            },
            info: {
                bg: 'bg-gradient-to-br from-blue-100 to-cyan-100',
                icon: 'text-blue-600',
                svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`
            },
            success: {
                bg: 'bg-gradient-to-br from-green-100 to-emerald-100',
                icon: 'text-green-600',
                svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`
            }
        };

        const config = icons[type] || icons.warning;
        
        iconContainer.className = `mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full sm:mx-0 sm:h-12 sm:w-12 mb-4 sm:mb-0 ${config.bg} icon-bounce`;
        iconContainer.innerHTML = `
            <svg class="h-8 w-8 ${config.icon}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                ${config.svg}
            </svg>
        `;
    }

    setTitle(title) {
        document.getElementById('modalTitle').textContent = title;
    }

    setMessage(message) {
        document.getElementById('modalMessage').textContent = message;
    }

    setInfo(info) {
        const infoElement = document.getElementById('modalInfo');
        const infoTextElement = document.getElementById('modalInfoText');
        
        if (info) {
            infoTextElement.textContent = info;
            infoElement.style.display = 'block';
        } else {
            infoElement.style.display = 'none';
        }
    }

    setButtons(confirmText, cancelText, dangerous = false) {
        const confirmButton = document.getElementById('confirmButton');
        const cancelButton = document.getElementById('cancelButton');
        
        confirmButton.textContent = confirmText;
        cancelButton.textContent = cancelText;
        
        // Set button styles based on danger level
        if (dangerous) {
            confirmButton.className = confirmButton.className.replace(/bg-\w+-\d+/g, '').replace(/hover:bg-\w+-\d+/g, '').replace(/focus:ring-\w+-\d+/g, '');
            confirmButton.className += ' bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:ring-red-500';
        } else {
            confirmButton.className = confirmButton.className.replace(/bg-\w+-\d+/g, '').replace(/hover:bg-\w+-\d+/g, '').replace(/focus:ring-\w+-\d+/g, '');
            confirmButton.className += ' bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 focus:ring-brand-500';
        }
        
        // Set up confirm button click handler
        confirmButton.onclick = () => {
            if (this.currentCallback) {
                this.currentCallback();
            }
            this.close();
        };
    }

    open() {
        this.isOpen = true;
        this.modal.style.display = 'block';
        
        // Trigger reflow to ensure display is applied
        this.modal.offsetHeight;
        
        // Trigger animations
        requestAnimationFrame(() => {
            this.modal.classList.remove('opacity-0');
            this.modal.classList.add('opacity-100');
            this.modalContent.classList.add('modal-animate-in');
        });
        
        // Focus management
        this.modal.focus();
    }

    close() {
        this.isOpen = false;
        
        // Trigger exit animations
        this.modal.classList.remove('opacity-100');
        this.modal.classList.add('opacity-0');
        this.modalContent.classList.add('modal-animate-out');
        
        setTimeout(() => {
            this.modal.style.display = 'none';
            this.modalContent.classList.remove('modal-animate-in', 'modal-animate-out');
            
            // Call cancel callback if provided
            if (this.cancelCallback) {
                this.cancelCallback();
                this.cancelCallback = null;
            }
            
            this.currentCallback = null;
        }, 300);
    }
}

// Global confirmation modal instance
let confirmationModal;

document.addEventListener('DOMContentLoaded', function() {
    confirmationModal = new ConfirmationModal();
    
    // Global functions
    window.showConfirmation = (options) => confirmationModal.show(options);
    window.closeConfirmationModal = () => confirmationModal.close();
});

// Helper functions for common confirmations
function confirmDelete(itemName, onConfirm) {
    showConfirmation({
        type: 'danger',
        title: 'Hapus Data',
        message: `Apakah Anda yakin ingin menghapus "${itemName}"?`,
        info: 'Data yang dihapus tidak dapat dikembalikan.',
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: onConfirm,
        dangerous: true
    });
}

function confirmDisable(itemName, onConfirm) {
    showConfirmation({
        type: 'warning',
        title: 'Nonaktifkan Data',
        message: `Apakah Anda yakin ingin menonaktifkan "${itemName}"?`,
        info: 'Data yang dinonaktifkan dapat diaktifkan kembali.',
        confirmText: 'Ya, Nonaktifkan',
        cancelText: 'Batal',
        onConfirm: onConfirm,
        dangerous: false
    });
}

function confirmEnable(itemName, onConfirm) {
    showConfirmation({
        type: 'info',
        title: 'Aktifkan Data',
        message: `Apakah Anda yakin ingin mengaktifkan "${itemName}"?`,
        confirmText: 'Ya, Aktifkan',
        cancelText: 'Batal',
        onConfirm: onConfirm
    });
}
</script>

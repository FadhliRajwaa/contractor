<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3">
    <!-- Toasts will be dynamically inserted here -->
</div>

<!-- Center Toast Container for Important Messages -->
<div id="center-toast-container" class="fixed inset-0 flex items-center justify-center z-60 pointer-events-none">
    <!-- Center toasts will be dynamically inserted here -->
</div>

<style>
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.toast-slide-in {
    animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.toast-slide-out {
    animation: slideOutRight 0.3s ease-in-out;
}

.toast-pulse {
    animation: pulse 0.6s ease-in-out;
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
// Toast Notification System
class ToastManager {
    constructor() {
        this.container = document.getElementById('toast-container');
        this.toasts = [];
        this.toastId = 0;
    }

    show(type = 'success', title = '', message = '', duration = 5000, center = false) {
        const toast = this.createToast(type, title, message, duration);
        
        // Choose container based on center parameter
        const targetContainer = center ? document.getElementById('center-toast-container') : this.container;
        targetContainer.appendChild(toast);
        
        // Trigger animation
        requestAnimationFrame(() => {
            if (center) {
                toast.classList.add('animate-fadeIn');
            } else {
                toast.classList.add('toast-slide-in');
            }
        });

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.remove(toast);
            }, duration);
        }

        return toast;
    }

    createToast(type, title, message, duration) {
        const toastId = ++this.toastId;
        const toast = document.createElement('div');
        
        // Define colors and icons based on type
        const types = {
            success: {
                bg: 'bg-gradient-to-r from-green-50 to-emerald-50',
                border: 'border-green-200',
                icon: 'text-green-500',
                iconSvg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`,
                titleColor: 'text-green-800',
                messageColor: 'text-green-600'
            },
            error: {
                bg: 'bg-gradient-to-r from-red-50 to-rose-50',
                border: 'border-red-200',
                icon: 'text-red-500',
                iconSvg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />`,
                titleColor: 'text-red-800',
                messageColor: 'text-red-600'
            },
            warning: {
                bg: 'bg-gradient-to-r from-yellow-50 to-amber-50',
                border: 'border-yellow-200',
                icon: 'text-yellow-500',
                iconSvg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />`,
                titleColor: 'text-yellow-800',
                messageColor: 'text-yellow-600'
            },
            info: {
                bg: 'bg-gradient-to-r from-blue-50 to-cyan-50',
                border: 'border-blue-200',
                icon: 'text-blue-500',
                iconSvg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`,
                titleColor: 'text-blue-800',
                messageColor: 'text-blue-600'
            }
        };

        const config = types[type] || types.info;

        toast.className = `toast max-w-md w-full ${config.bg} ${config.border} border-2 rounded-2xl shadow-2xl p-4 transform transition-all duration-300 hover:scale-105 backdrop-blur-sm pointer-events-auto`;
        toast.id = `toast-${toastId}`;
        
        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="${config.icon} bg-white rounded-full p-2 shadow-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            ${config.iconSvg}
                        </svg>
                    </div>
                </div>
                <div class="ml-3 flex-1 pt-0.5">
                    <h4 class="${config.titleColor} text-sm font-bold leading-5">${title}</h4>
                    <p class="${config.messageColor} text-sm mt-1 leading-4">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200" onclick="toastManager.remove(this.closest('.toast'))">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            ${duration > 0 ? `
                <div class="mt-2">
                    <div class="w-full bg-white bg-opacity-50 rounded-full h-1">
                        <div class="bg-gradient-to-r from-gray-600 to-gray-800 h-1 rounded-full toast-progress" style="animation: shrink ${duration}ms linear"></div>
                    </div>
                </div>
            ` : ''}
        `;

        // Add progress bar animation
        if (duration > 0) {
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shrink {
                    from { width: 100%; }
                    to { width: 0%; }
                }
            `;
            document.head.appendChild(style);
        }

        return toast;
    }

    remove(toast) {
        if (toast && toast.parentNode) {
            toast.classList.add('toast-slide-out');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }
    }

    success(title, message, duration = 5000, center = false) {
        return this.show('success', title, message, duration, center);
    }

    error(title, message, duration = 7000, center = false) {
        return this.show('error', title, message, duration, center);
    }

    warning(title, message, duration = 6000, center = false) {
        return this.show('warning', title, message, duration, center);
    }

    info(title, message, duration = 5000, center = false) {
        return this.show('info', title, message, duration, center);
    }

    clear() {
        const toasts = this.container.querySelectorAll('.toast');
        toasts.forEach(toast => this.remove(toast));
    }
}

// Global toast instance
let toastManager;

document.addEventListener('DOMContentLoaded', function() {
    toastManager = new ToastManager();
    
    // Global functions for easy use
    window.showToast = (type, title, message, duration, center = false) => toastManager.show(type, title, message, duration, center);
    window.showSuccess = (title, message, duration, center = false) => toastManager.success(title, message, duration);
    window.showError = (title, message, duration, center = false) => toastManager.error(title, message, duration);
    window.showWarning = (title, message, duration, center = false) => toastManager.warning(title, message, duration);
    window.showInfo = (title, message, duration, center = false) => toastManager.info(title, message, duration);
    window.showCenterToast = (type, title, message, duration = 3000) => toastManager.show(type, title, message, duration, true);
});
</script>

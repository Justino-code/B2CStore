import { getThemeConfig } from '../config/theme';
import { notyfConfig, swalConfig } from '../config/notifications';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import Swal from 'sweetalert2';

class NotificationService {
    constructor() {
        this.notyf = null;
        this.swal = null;
        this.initialize();
    }

    initialize() {
        this.initializeNotyf();
        this.initializeSwal();
        this.makeGlobal();
    }

    initializeNotyf() {
        const theme = getThemeConfig();
        const config = notyfConfig(theme);
        
        this.notyf = new Notyf(config);
    }

    initializeSwal() {
        const theme = getThemeConfig();
        const config = swalConfig(theme);
        
        this.swal = Swal.mixin(config);
    }

    makeGlobal() {
        window.Notyf = this.notyf;
        window.notyf = this.notyf;
        window.Swal = this.swal;
    }

    updateTheme() {
        console.log('Atualizando tema das notificações...');

        // Fechar todas as notificações existentes
        if (this.notyf) {
            this.notyf.dismissAll();
        }

        // Recriar as instâncias com novo tema
        this.initializeNotyf();
        this.initializeSwal();
        this.makeGlobal();

        console.log('Tema atualizado para:', getThemeConfig().isDark ? 'dark' : 'light');
    }

    showNotification(type, message, options = {}) {
        if (!this.notyf) {
            this.initializeNotyf();
        }

        const config = {
            message,
            duration: options.duration || 5000,
            dismissible: options.dismissible !== false,
            ripple: options.ripple !== false
        };

        switch(type) {
            case 'success':
                this.notyf.success(config);
                break;
            case 'error':
                this.notyf.error(config);
                break;
            case 'warning':
                this.notyf.error({ ...config, type: 'warning' });
                break;
            case 'info':
                this.notyf.error({ ...config, type: 'info' });
                break;
        }
    }

    showConfirmation(options = {}) {
        if (!this.swal) {
            this.initializeSwal();
        }

        const theme = getThemeConfig();

        const config = {
            title: options.title || 'Tem certeza?',
            text: options.message || 'Esta ação não pode ser desfeita.',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonText: options.confirmText || 'Sim, continuar',
            cancelButtonText: options.cancelText || 'Cancelar',
            confirmButtonColor: theme.colors.primary,
            cancelButtonColor: theme.colors.secondary,
            customClass: {
                popup: 'rounded-xl shadow-xl',
                htmlContainer: theme.isDark ? 'text-gray-300' : 'text-gray-700',
                confirmButton: theme.isDark
                    ? 'bg-blue-600 hover:bg-blue-700 text-white'
                    : 'bg-blue-500 hover:bg-blue-600 text-white',
                cancelButton: theme.isDark
                    ? 'bg-gray-700 hover:bg-gray-600 text-gray-300'
                    : 'bg-gray-200 hover:bg-gray-300 text-gray-700'
            },
            ...options
        };

        return this.swal.fire(config);
    }
}

// Criar instância global
const notificationService = new NotificationService();

// Exportar instância e classe
export default notificationService;
export { NotificationService };

// Funções globais para compatibilidade
window.showNotification = (type, message, options = {}) => {
    notificationService.showNotification(type, message, options);
};

window.showConfirmation = (options = {}) => {
    return notificationService.showConfirmation(options);
};

window.updateNotificationTheme = () => {
    notificationService.updateTheme();
};
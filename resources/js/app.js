// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import 'notyf/notyf.min.css';
import Swal from 'sweetalert2';
import { Notyf } from 'notyf';

// Configurar Alpine
Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Função para verificar se está em modo escuro
const isDarkMode = () => {
    return document.documentElement.classList.contains('dark');
};

// Configurações de tema
const getThemeConfig = () => {
    const dark = isDarkMode();

    return {
        isDark: dark,
        colors: {
            background: dark ? '#1f2937' : '#ffffff',
            text: dark ? '#e5e7eb' : '#374151',
            primary: dark ? '#3b82f6' : '#2563eb',
            secondary: dark ? '#6b7280' : '#9ca3af'
        }
    };
};

// Inicializar Notyf com tema dinâmico
let notyfInstance = null;
const initializeNotyf = () => {
    const theme = getThemeConfig();

    notyfInstance = new Notyf({
        duration: 5000,
        position: { x: 'right', y: 'top' },
        ripple: true,
        dismissible: true,
        background: theme.isDark ? '#374151' : undefined,
        types: [
            {
                type: 'success',
                background: theme.isDark ? '#059669' : '#10b981',
                icon: false
            },
            {
                type: 'error',
                background: theme.isDark ? '#dc2626' : '#ef4444',
                icon: false
            },
            {
                type: 'warning',
                background: theme.isDark ? '#d97706' : '#f59e0b',
                icon: false
            },
            {
                type: 'info',
                background: theme.isDark ? '#2563eb' : '#3b82f6',
                icon: false
            }
        ]
    });

    return notyfInstance;
};

// Inicializar SweetAlert2 com tema dinâmico
let swalInstance = null;
const initializeSwal = () => {
    const theme = getThemeConfig();

    swalInstance = Swal.mixin({
        theme: theme.isDark ? 'dark' : 'light',
        color: theme.colors.text,
        background: theme.colors.background,
        confirmButtonColor: theme.colors.primary,
        cancelButtonColor: theme.colors.secondary,
        buttonsStyling: true,
        customClass: {
            container: 'swal-container',
            popup: 'rounded-xl shadow-xl',
            title: 'text-xl font-semibold',
            htmlContainer: theme.isDark ? 'text-gray-300' : 'text-gray-700',
            confirmButton: 'px-4 py-2 rounded-lg font-medium transition-colors',
            cancelButton: 'px-4 py-2 rounded-lg font-medium transition-colors'
        }
    });

    return swalInstance;
};

// Inicializar as bibliotecas
notyfInstance = initializeNotyf();
swalInstance = initializeSwal();

// Disponibilizar globalmente
window.Notyf = notyfInstance;
window.notyf = notyfInstance; // alias
window.Swal = swalInstance;

// Função para atualizar temas
window.updateNotificationTheme = () => {
    console.log('Atualizando tema das notificações...');

    // Fechar todas as notificações existentes
    if (window.Notyf) {
        window.Notyf.dismissAll();
    }

    // Recriar as instâncias com novo tema
    notyfInstance = initializeNotyf();
    swalInstance = initializeSwal();

    window.Notyf = notyfInstance;
    window.notyf = notyfInstance;
    window.Swal = swalInstance;

    console.log('Tema atualizado para:', getThemeConfig().isDark ? 'dark' : 'light');
};

// Ouvir mudanças de tema
document.addEventListener('themeChanged', () => {
    console.log('Tema alterado detectado');
    if (typeof window.updateNotificationTheme === 'function') {
        // Pequeno delay para garantir que o DOM foi atualizado
        setTimeout(() => {
            window.updateNotificationTheme();
        }, 100);
    }
});

// Também observar mudanças diretas na classe dark
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.attributeName === 'class' &&
            mutation.target === document.documentElement) {
            console.log('Classe dark alterada');
            if (typeof window.updateNotificationTheme === 'function') {
                setTimeout(() => {
                    window.updateNotificationTheme();
                }, 100);
            }
        }
    });
});

// Iniciar observação
observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class']
});

// Funções globais para uso em templates
window.showNotification = (type, message, options = {}) => {
    if (!window.Notyf) {
        initializeNotyf();
    }

    const config = {
        message,
        duration: options.duration || 5000,
        dismissible: options.dismissible !== false,
        ripple: options.ripple !== false
    };

    switch(type) {
        case 'success':
            window.Notyf.success(config);
            break;
        case 'error':
            window.Notyf.error(config);
            break;
        case 'warning':
            window.Notyf.error({ ...config, type: 'warning' });
            break;
        case 'info':
            window.Notyf.error({ ...config, type: 'info' });
            break;
    }
};

window.showConfirmation = (options = {}) => {
    if (!window.Swal) {
        initializeSwal();
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

    return window.Swal.fire(config);
};

// Integração com Livewire
window.addEventListener('livewire:init', () => {
    Livewire.on('showNotification', (data) => {
        if (Array.isArray(data)) {
            showNotification(data[0], data[1], data[2] || {});
        } else if (typeof data === 'object') {
            showNotification(data.type, data.message, data.options || {});
        }
    });

    Livewire.on('showConfirmation', (data) => {
        const options = typeof data === 'object' ? data : { message: data };
        showConfirmation(options).then((result) => {
            if (result.isConfirmed && options.method) {
                Livewire.dispatch(options.method, options.params || []);
            }
        });
    });
});

// Debug
console.log('App.js carregado');
console.log('Modo escuro:', isDarkMode());

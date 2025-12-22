// Configurações padrão de notificações

export const notyfConfig = (theme) => ({
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

export const swalConfig = (theme) => ({
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
import notificationService from './notificationService';

// Gerenciador de eventos de tema
export const initThemeEventListeners = () => {
    document.addEventListener('themeChanged', () => {
        console.log('Tema alterado detectado no EventService');
        
        // Pequeno delay para garantir que o DOM foi atualizado
        setTimeout(() => {
            if (typeof window.updateNotificationTheme === 'function') {
                window.updateNotificationTheme();
            }
        }, 100);
    });
};

// Inicializar ouvintes de eventos
initThemeEventListeners();
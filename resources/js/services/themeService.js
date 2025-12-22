import { getThemeConfig } from '../config/theme';

// Observador de mudanças de tema (fallback se Alpine não estiver funcionando)
export const initThemeObserver = () => {
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class' &&
                mutation.target === document.documentElement) {
                console.log('Classe dark alterada - Observer');
                
                // Disparar evento personalizado
                document.dispatchEvent(new CustomEvent('themeChanged', {
                    detail: { isDark: getThemeConfig().isDark }
                }));
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });

    return observer;
};

// Inicializar serviço de tema apenas se necessário
let themeObserver = null;

export const initThemeService = () => {
    // Verificar se o Alpine já carregou o themeManager
    if (window.Alpine && document.querySelector('[x-data*="themeManager"]')) {
        //console.log('Alpine themeManager detectado, usando observador Alpine');
        // Alpine já está gerenciando o tema, não precisamos do observer pesado
        return null;
    } else {
        //console.log('Alpine não detectado, inicializando observer manual');
        themeObserver = initThemeObserver();
        return themeObserver;
    }
};

// Inicializar quando o DOM estiver pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(initThemeService, 100); // Pequeno delay para Alpine carregar
    });
} else {
    setTimeout(initThemeService, 100);
}
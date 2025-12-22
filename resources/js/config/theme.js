// Configurações de tema

// Função para verificar se está em modo escuro
export const isDarkMode = () => {
    return document.documentElement.classList.contains('dark');
};

// Obter configuração do tema atual
export const getThemeConfig = () => {
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

export default {
    isDarkMode,
    getThemeConfig
};
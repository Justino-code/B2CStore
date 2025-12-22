document.addEventListener('alpine:init', () => {
    Alpine.data('themeManager', () => ({
        theme: Alpine.$persist('system').as('theme').using(sessionStorage),

        init() {
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // Inicializa o tema com base no sistema ou no valor persistido
            if (this.theme === 'system') {
                document.documentElement.classList.toggle('dark', systemDark);
            } else {
                document.documentElement.classList.toggle('dark', this.theme === 'dark');
            }

            // Observar mudanças no sistema
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (this.theme === 'system') {
                    document.documentElement.classList.toggle('dark', e.matches);
                    document.dispatchEvent(new CustomEvent('themeChanged', {
                        detail: { theme: e.matches ? 'dark' : 'light' }
                    }));
                }
            });

            // Disparar evento inicial
            this.$watch('theme', (value) => {
                const isDark = value === 'dark' || 
                    (value === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                document.documentElement.classList.toggle('dark', isDark);
                document.dispatchEvent(new CustomEvent('themeChanged', {
                    detail: { theme: value }
                }));
            });
        }
    }));
});
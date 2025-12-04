{{-- components/theme-manager.blade.php --}}
<div x-data="themeManager()" x-init="init()" style="display: none;">
    <!-- Este componente só gerencia estado, não renderiza nada visível -->
</div>

<script>
function themeManager() {
    return {
        darkMode: false,

        init() {
            // Verificar preferência salva ou do sistema
            const savedTheme = localStorage.getItem('darkMode');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            this.darkMode = savedTheme === 'true' || (savedTheme === null && systemPrefersDark);

            // Aplicar tema inicial
            this.applyTheme();

            // Observar mudanças no modo escuro
            this.$watch('darkMode', value => {
                this.applyTheme();
            });

            // Observar preferência do sistema
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (localStorage.getItem('darkMode') === null) {
                    this.darkMode = e.matches;
                    this.applyTheme();
                }
            });
        },

        applyTheme() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
            }

            // Disparar evento personalizado para notificar outras partes do sistema
            document.dispatchEvent(new CustomEvent('themeChanged', {
                detail: { darkMode: this.darkMode }
            }));

            // Atualizar temas das notificações se a função existir
            if (typeof window.updateNotificationThemes === 'function') {
                setTimeout(() => window.updateNotificationThemes(), 50);
            }
        },

        toggleTheme() {
            this.darkMode = !this.darkMode;
        },

        isDarkMode() {
            return this.darkMode;
        }
    }
}
</script>

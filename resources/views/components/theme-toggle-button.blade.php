{{-- components/theme-toggle-button.blade.php --}}
<button
    x-data="{
        theme: $persist('system').as('theme').using(sessionStorage),
        getThemeIcon() {
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (this.theme === 'dark') return 'sun';
            if (this.theme === 'light') return 'moon';
            return systemDark ? 'sun' : 'moon';
        },
        getThemeLabel() {
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (this.theme === 'dark') return 'Ativar modo claro';
            if (this.theme === 'light') return 'Ativar modo escuro';
            return systemDark ? 'Modo claro (sistema)' : 'Modo escuro (sistema)';
        },
        toggleTheme() {
            if (this.theme === 'system') {
                this.theme = 'light';
            } else if (this.theme === 'light') {
                this.theme = 'dark';
            } else {
                this.theme = 'system';
            }

            // Atualizar a classe no documento
            this.applyTheme();

            // Disparar evento para atualizar notificações
            document.dispatchEvent(new CustomEvent('themeChanged'));
        },
        applyTheme() {
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldBeDark = this.theme === 'dark' || (this.theme === 'system' && systemDark);

            if (shouldBeDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    x-init="applyTheme()"
    @click="toggleTheme()"
    :aria-label="getThemeLabel()"
    :title="getThemeLabel()"
    class="p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
>
    <!-- Ícone Sol (modo escuro ativo) -->
    <svg x-show="getThemeIcon() === 'sun'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>

    <!-- Ícone Lua (modo claro ativo) -->
    <svg x-show="getThemeIcon() === 'moon'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
    </svg>
</button>

// resources/js/ajax-navigation.js

document.addEventListener('DOMContentLoaded', function() {
    // 1. Interceptar cliques nos links do sidebar
    document.querySelectorAll('.sidebar a[href^="/cliente"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            
            // Usar Livewire para navegação AJAX
            if (typeof Livewire !== 'undefined') {
                Livewire.navigate(url, {
                    preserveScroll: true,
                    preserveState: true
                });
            } else {
                // Fallback para navegação normal
                window.location.href = url;
            }
        });
    });

    // 2. Interceptar cliques nos links do navbar
    document.querySelectorAll('.navbar a[href^="/cliente"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            
            if (typeof Livewire !== 'undefined') {
                Livewire.navigate(url);
            } else {
                window.location.href = url;
            }
        });
    });

    // 3. Configurar Livewire (se estiver usando)
    if (typeof Livewire !== 'undefined') {
        // Atualizar classe ativa no sidebar quando a rota muda
        Livewire.hook('navigate', (data) => {
            updateActiveSidebarLink(data.url);
        });

        // Função para atualizar link ativo
        function updateActiveSidebarLink(url) {
            document.querySelectorAll('.sidebar a').forEach(link => {
                const linkHref = link.getAttribute('href');
                if (linkHref === url || window.location.pathname === url) {
                    link.classList.add('active');
                    link.classList.remove('hover:bg-gray-50', 'dark:hover:bg-gray-700');
                } else {
                    link.classList.remove('active');
                    link.classList.add('hover:bg-gray-50', 'dark:hover:bg-gray-700');
                }
            });
        }
    }

    // 4. Função global para navegação programática
    window.ajaxNavigate = function(url, options = {}) {
        if (typeof Livewire !== 'undefined') {
            Livewire.navigate(url, {
                preserveScroll: options.preserveScroll || true,
                preserveState: options.preserveState || true,
                ...options
            });
        } else {
            window.location.href = url;
        }
    };
});

// 5. Alpine.js plugin para navegação AJAX
document.addEventListener('alpine:init', () => {
    Alpine.store('navigation', {
        currentRoute: window.location.pathname,
        
        navigateTo(url) {
            if (typeof Livewire !== 'undefined') {
                Livewire.navigate(url);
            } else {
                window.location.href = url;
            }
        },
        
        isActive(route) {
            return this.currentRoute === route || 
                   window.location.pathname.startsWith(route);
        }
    });
    
    // Adicionar diretiva Alpine para navegação
    Alpine.directive('navigate', (el, { expression }, { evaluate }) => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            const url = evaluate(expression);
            
            if (typeof Livewire !== 'undefined') {
                Livewire.navigate(url);
            } else {
                window.location.href = url;
            }
        });
    });
});
{{-- components/sidebar/cliente.blade.php --}}
<div x-data="sidebarState()" x-init="init()">
    <!-- Sidebar Overlay (Mobile) -->
    <div class="lg:hidden fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity duration-300"
         x-show="isOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()"
         x-cloak>
    </div>

    <!-- Sidebar Content -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:w-full h-full"
           :class="{
               'translate-x-0': isOpen,
               '-translate-x-full': !isOpen
           }"
           x-cloak
           @keydown.escape.window="close()">
        
        <!-- Sidebar Container - Ocupa altura total no desktop -->
        <div class="flex flex-col h-full bg-white dark:bg-gray-800 shadow-xl lg:shadow-none transition-colors duration-300 sidebar-scroll">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200 dark:border-gray-700">
                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <img class="h-10 w-10 rounded-full border-2 border-gray-300 dark:border-gray-600"
                         src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1D4ED8&color=fff&size=256' }}"
                         alt="{{ Auth::user()->name }}"
                         loading="lazy">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate max-w-[140px]">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[140px]">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
                
                <!-- Close Button (Mobile) -->
                <button @click="close()" 
                        class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="sr-only">Fechar menu</span>
                </button>
            </div>

            <!-- Navigation - Ocupa espaço disponível -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('cliente.dashboard') }}"
                   class="{{ request()->routeIs('cliente.dashboard') ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('cliente.dashboard') }}')"
                   onclick="closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Dashboard</span>
                </a>

                <!-- Meu Perfil -->
                <a href="{{ route('cliente.conta') }}"
                   class="{{ request()->routeIs('cliente.conta') ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('cliente.conta') }}')"
                   onclick="closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Meu Perfil</span>
                </a>

                <!-- Meus Pedidos -->
                @php
                    $pedidosCount = \App\Models\Pedido::where('id_usuario', Auth::id())->whereIn('status', ['pendente', 'processando', 'enviado'])->count();
                @endphp
                <a href="{{ route('cliente.pedidos') }}"
                   class="{{ request()->routeIs('cliente.pedidos') ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('cliente.pedidos') }}')"
                   onclick="closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Meus Pedidos</span>
                    @if($pedidosCount > 0)
                        <span class="ml-2 inline-flex items-center justify-center py-0.5 px-2 text-xs font-medium bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-full transition-colors duration-300 min-w-[1.5rem]">
                            {{ $pedidosCount }}
                        </span>
                    @endif
                </a>

                <!-- Favoritos -->
                @php
                    $favoritosCount = \App\Models\Favorito::where('id_usuario', Auth::id())->count();
                @endphp
                <a href="{{ route('cliente.favoritos') }}"
                   class="{{ request()->routeIs('cliente.favoritos') ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('cliente.favoritos') }}')"
                   onclick="closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Favoritos</span>
                    @if($favoritosCount > 0)
                        <span class="ml-2 inline-flex items-center justify-center py-0.5 px-2 text-xs font-medium bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 rounded-full transition-colors duration-300 min-w-[1.5rem]">
                            {{ $favoritosCount > 99 ? '99+' : $favoritosCount }}
                        </span>
                    @endif
                </a>

                <!-- Carrinho -->
                @php
                    $carrinhoCount = \App\Models\Carrinho::where('id_usuario', Auth::id())->first()?->itens()->count() ?? 0;
                @endphp
                <a href="{{ route('cliente.carrinho') }}"
                   class="{{ request()->routeIs('cliente.carrinho') ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('cliente.carrinho') }}')"
                   onclick="closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Carrinho</span>
                    @if($carrinhoCount > 0)
                        <span class="ml-2 inline-flex items-center justify-center py-0.5 px-2 text-xs font-medium bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 rounded-full transition-colors duration-300 min-w-[1.5rem]">
                            {{ $carrinhoCount > 99 ? '99+' : $carrinhoCount }}
                        </span>
                    @endif
                </a>

                <!-- Cupons -->
                <a href="{{ route('cliente.cupons') }}"
                   class="{{ request()->routeIs('cliente.cupons') ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('cliente.cupons') }}')"
                   onclick="closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Meus Cupons</span>
                </a>

                <!-- Sair -->
                <form method="POST" action="{{ route('logout') }}" class="w-full mt-auto">
                    @csrf
                    <button type="submit"
                            class="w-full group flex items-center px-3 py-3 text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-700 dark:hover:text-red-300 rounded-lg transition-colors duration-200"
                            onclick="closeMobile()">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-sm font-medium flex-1 text-left">Sair</span>
                    </button>
                </form>
            </nav>

            <!-- Sidebar Footer -->
            <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    <p>B2CStore © {{ date('Y') }}</p>
                    <p class="mt-1">Área do Cliente</p>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    // Scripts globais para controle do sidebar
    window.sidebarState = function() {
        return {
            isOpen: false,
            
            init() {
                // Estado inicial baseado no tamanho da tela
                // Em telas lg ou maiores, sidebar aberto por padrão
                this.isOpen = window.innerWidth >= 1024;
                
                // Sincronizar com estado global
                this.syncWithGlobal();
                
                // Listener para resize
                window.addEventListener('resize', () => {
                    // Em telas lg+, sidebar sempre visível
                    if (window.innerWidth >= 1024) {
                        this.isOpen = true;
                    } else {
                        this.isOpen = false;
                    }
                    this.syncBodyOverflow();
                });
                
                // Fechar com ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isOpen && window.innerWidth < 1024) {
                        this.close();
                    }
                });
            },
            
            syncWithGlobal() {
                // Sincronizar com funções globais
                window.openSidebar = () => this.open();
                window.closeSidebar = () => this.close();
                window.toggleSidebar = () => this.toggle();
            },
            
            open() {
                this.isOpen = true;
                this.syncBodyOverflow();
            },
            
            close() {
                // Em telas lg+, não fecha completamente, apenas em mobile
                if (window.innerWidth >= 1024) {
                    return;
                }
                this.isOpen = false;
                this.syncBodyOverflow();
            },
            
            closeMobile() {
                // Fecha apenas em mobile/tablet
                if (window.innerWidth < 1024) {
                    this.close();
                }
            },
            
            toggle() {
                if (this.isOpen) {
                    this.close();
                } else {
                    this.open();
                }
            },
            
            syncBodyOverflow() {
                // Bloquear scroll do body quando sidebar aberto em mobile
                if (window.innerWidth < 1024 && this.isOpen) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            },
            
            // Função para navegação AJAX
            ajaxNavigate(url) {
                // Fechar sidebar mobile
                if (window.innerWidth < 1024) {
                    this.close();
                }
                
                // Verificar se Livewire está disponível
                if (typeof Livewire !== 'undefined' && typeof Livewire.navigate === 'function') {
                    // Navegação via Livewire (AJAX)
                    Livewire.navigate(url, {
                        preserveScroll: true,
                        preserveState: true
                    });
                } else {
                    // Fallback para navegação normal
                    window.location.href = url;
                }
            }
        };
    };
    
    // Inicializar funções globais imediatamente para o navbar acessar
    window.openSidebar = function() {
        // Esta função será sobrescrita quando Alpine inicializar
        console.log('Sidebar functions loading...');
    };
    
    window.closeSidebar = function() {
        console.log('Sidebar functions loading...');
    };
</script>
@endpush

@push('styles')
<style>
    [x-cloak] { 
        display: none !important; 
    }
    
    /* Scrollbar personalizada para sidebar */
    .sidebar-scroll {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 transparent;
    }
    
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 3px;
    }
    
    .dark .sidebar-scroll::-webkit-scrollbar-thumb {
        background-color: #4b5563;
    }
    
    /* Touch-friendly links */
    @media (max-width: 640px) {
        nav a, nav button {
            min-height: 44px;
        }
    }
</style>
@endpush
{{-- components/navbar/admin.blade.php --}}
<nav class="bg-white dark:bg-gray-800 shadow" x-data="navbarState()" x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Mobile Sidebar Button -->
                <button @click="window.openSidebar()" 
                        class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('home') }}" 
                   class="flex items-center ml-2 lg:ml-0 cursor-pointer"
                   @click.prevent="ajaxNavigate('{{ route('home') }}')">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="ml-2 text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">
                        B2CStore
                    </span>
                </a>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <x-theme-toggle-button />

                <!-- Notifications -->
                <div class="relative" x-data="{ openNotifications: false }" @click.outside="openNotifications = false">
                    <button @click="openNotifications = !openNotifications" 
                            class="relative p-2 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @php
                            use App\Enum\Role;
                            $user = auth()->user();
                            $userRole = $user->role ?? null;
                            
                            $pedidosCount = 0;
                            if (in_array($userRole, [Role::ADMIN->value, Role::GERENTE->value, Role::OPERADOR->value, Role::SUPORTE->value])) {
                                $pedidosCount = \App\Models\Pedido::whereIn('status', ['pendente'])->count();
                            }
                        @endphp
                        @if($pedidosCount > 0)
                            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                        @endif
                    </button>

                    <!-- Notifications Dropdown -->
                    <div x-show="openNotifications" 
                         x-transition
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Notificações</h3>
                            <div class="space-y-3 max-h-60 overflow-y-auto" id="notifications-list">
                                @if($pedidosCount > 0)
                                <div class="flex items-start space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded cursor-pointer"
                                     @click.prevent="openNotifications = false; ajaxNavigate('{{ route('admin.pedidos.index') }}')">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Novo pedido recebido</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Há 5 minutos</p>
                                    </div>
                                </div>
                                @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                                    Nenhuma notificação
                                </p>
                                @endif
                            </div>
                            <a href="{{ route('admin.pedidos.index') }}" 
                               class="block text-center text-sm text-blue-600 dark:text-blue-400 hover:underline mt-3 cursor-pointer"
                               @click.prevent="openNotifications = false; ajaxNavigate('{{ route('admin.pedidos.index') }}')">
                                Ver todos os pedidos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ openUserMenu: false }" @click.outside="openUserMenu = false">
                    <button @click="openUserMenu = !openUserMenu" 
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ substr(Auth::user()->nome, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ explode(' ',Auth::user()->nome)[0] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-500" :class="{ 'rotate-180': openUserMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="openUserMenu" 
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->nome }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                            
                            
                            <a href="{{ route('admin.perfil') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                               @click.prevent="openUserMenu = false; ajaxNavigate('{{ route('admin.perfil') }}')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Meu Perfil
                            </a>
                          

                            <div class="border-t border-gray-200 dark:border-gray-700"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 cursor-pointer">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    window.navbarState = function() {
        return {
            init() {
                this.syncWithGlobal();
            },
            
            syncWithGlobal() {
                if (!window.ajaxNavigate) {
                    window.ajaxNavigate = this.ajaxNavigate.bind(this);
                }
            },
            
            ajaxNavigate(url) {
                // Fechar todos os dropdowns abertos
                this.closeAllDropdowns();
                
                // Usar a mesma função de navegação da sidebar se disponível
                if (typeof window.sidebarState !== 'undefined' && typeof window.sidebarState().ajaxNavigate === 'function') {
                    window.sidebarState().ajaxNavigate(url);
                } else if (typeof Livewire !== 'undefined' && typeof Livewire.navigate === 'function') {
                    Livewire.navigate(url, {
                        preserveScroll: true,
                        preserveState: true
                    });
                } else {
                    // Fallback para navegação normal
                    window.location.href = url;
                }
            },
            
            closeAllDropdowns() {
                // Fechar dropdowns do Alpine
                const dropdowns = document.querySelectorAll('[x-data*="open"]');
                dropdowns.forEach(dropdown => {
                    if (dropdown.__x && dropdown.__x.$data && dropdown.__x.$data.open !== undefined) {
                        dropdown.__x.$data.open = false;
                    }
                });
            }
        };
    };
</script>

@push('styles')
<style>
    .cursor-pointer {
        cursor: pointer;
    }
    
    /* Estilo para links com navegação AJAX */
    [@click*="ajaxNavigate"] {
        transition: all 0.2s ease;
    }
    
    [@click*="ajaxNavigate"]:hover {
        opacity: 0.9;
    }
</style>
@endpush
@endpush
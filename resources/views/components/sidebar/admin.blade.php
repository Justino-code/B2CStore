{{-- components/sidebar/admin.blade.php --}}
<div x-data="sidebarState()" x-init="init()" x-cloak>
    <!-- Overlay Mobile -->
    <div class="lg:hidden fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity duration-300"
         x-show="isOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()">
    </div>

    <!-- Sidebar - Ajustado para altura dinâmica -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out lg:sticky lg:top-6 lg:w-full lg:h-auto lg:translate-x-0"
           :class="{
               'translate-x-0': isOpen,
               '-translate-x-full': !isOpen
           }"
           @keydown.escape.window="close()">
        
        <div class="flex flex-col h-full lg:h-auto bg-white dark:bg-gray-800 shadow-xl lg:shadow-md lg:rounded-lg border-r lg:border border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        @php
                            $user = auth()->user();
                            $initials = strtoupper(substr($user->nome ?? 'A', 0, 1));
                        @endphp
                        <span class="text-white font-bold">{{ $initials }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->nome ?? 'Usuário' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ $user->role ?? 'admin' }}</p>
                    </div>
                </div>
                
                <button @click="close()" 
                        class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation - Altura ajustada -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto lg:max-h-[calc(100vh-20rem)]">
                @php
                    use App\Enum\Role;
                    $currentRoute = request()->route()->getName();
                    $user = auth()->user();
                    $userRole = $user->role ?? null;
                    
                    // Contadores (somente para roles com permissão)
                    $pedidosCount = 0;
                    if (in_array($userRole, [Role::ADMIN->value, Role::GERENTE->value, Role::OPERADOR->value, Role::SUPORTE->value])) {
                        $pedidosCount = \App\Models\Pedido::whereIn('status', ['pendente'])->count();
                    }
                    
                    $funcionariosCount = 0;
                    if (in_array($userRole, [Role::ADMIN->value])) {
                        $funcionariosCount = \App\Models\Usuario::whereNot('role', 'cliente')->count();
                    }
                    
                    // Funções auxiliares para verificar rotas ativas
                    $isDashboardActive = $currentRoute === 'admin.dashboard';
                    $isProdutosActive = str_starts_with($currentRoute, 'admin.produtos');
                    $isCategoriasActive = str_starts_with($currentRoute, 'admin.categorias');
                    $isPedidosActive = str_starts_with($currentRoute, 'admin.pedidos');
                    $isClientesActive = str_starts_with($currentRoute, 'admin.clientes');
                    $isFuncionariosActive = str_starts_with($currentRoute, 'admin.funcionarios');
                    $isPromocoesActive = str_starts_with($currentRoute, 'admin.promocoes');
                    $isRelatorioActive = str_starts_with($currentRoute, 'admin.relatorio');
                    
                    // Definir permissões baseadas na role
                    $canAccessDashboard = in_array($userRole, [
                        Role::ADMIN->value, 
                        Role::GERENTE->value
                    ]);
                    
                    $canAccessProdutos = in_array($userRole, [
                        Role::ADMIN->value, 
                        Role::GERENTE->value
                    ]);
                    
                    $canAccessCategorias = in_array($userRole, [
                        Role::ADMIN->value, 
                        Role::GERENTE->value
                    ]);
                    
                    $canAccessPedidos = in_array($userRole, [
                        Role::ADMIN->value, 
                        Role::GERENTE->value, 
                        Role::OPERADOR->value, 
                        Role::SUPORTE->value
                    ]);
                    
                    $canAccessClientes = in_array($userRole, [
                        Role::ADMIN->value, 
                        Role::GERENTE->value, 
                        Role::OPERADOR->value, 
                        Role::SUPORTE->value
                    ]);
                    
                    $canAccessFuncionarios = in_array($userRole, [
                        Role::ADMIN->value
                    ]);
                    
                    $canAccessCupons = in_array($userRole, [
                        Role::ADMIN->value
                    ]);
                    
                    $canAccessRelatorios = in_array($userRole, [
                        Role::ADMIN->value, 
                        Role::GERENTE->value
                    ]);
                @endphp
                
                <!-- Dashboard - Apenas Admin e Gerente -->
                @if($canAccessDashboard)
                <a href="{{ route('admin.dashboard') }}"
                   @class([
                       'group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer',
                       'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isDashboardActive,
                       'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isDashboardActive
                   ])
                   @click.prevent="ajaxNavigate('{{ route('admin.dashboard') }}'); closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Dashboard</span>
                </a>
                @endif

                <!-- Produtos - Apenas Admin e Gerente -->
                @if($canAccessProdutos)
                <div x-data="{ open: {{ $isProdutosActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            @class([
                                'w-full flex items-center justify-between px-3 py-3 rounded-lg transition-colors duration-200',
                                'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isProdutosActive,
                                'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isProdutosActive
                            ])>
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="text-sm font-medium">Produtos</span>
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('admin.produtos.index') }}"
                           @class([
                               'flex items-center px-3 py-2 text-sm rounded transition-colors duration-200 cursor-pointer',
                               'text-blue-600 dark:text-blue-400' => $currentRoute === 'admin.produtos.index',
                               'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' => $currentRoute !== 'admin.produtos.index'
                           ])
                           @click.prevent="ajaxNavigate('{{ route('admin.produtos.index') }}'); closeMobile()">
                            Todos os Produtos
                        </a>
                        @if($userRole === Role::ADMIN->value || $userRole === Role::GERENTE->value)
                        <a href="{{ route('admin.produtos.create') }}"
                           @class([
                               'flex items-center px-3 py-2 text-sm rounded transition-colors duration-200 cursor-pointer',
                               'text-blue-600 dark:text-blue-400' => $currentRoute === 'admin.produtos.create',
                               'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' => $currentRoute !== 'admin.produtos.create'
                           ])
                           @click.prevent="ajaxNavigate('{{ route('admin.produtos.create') }}'); closeMobile()">
                            Novo Produto
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Categorias - Apenas Admin e Gerente -->
                @if($canAccessCategorias)
                <a href="{{ route('admin.categorias.index') }}"
                   @class([
                       'group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer',
                       'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isCategoriasActive,
                       'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isCategoriasActive
                   ])
                   @click.prevent="ajaxNavigate('{{ route('admin.categorias.index') }}'); closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Categorias</span>
                </a>
                @endif

                <!-- Pedidos - Admin, Gerente, Operador, Suporte -->
                @if($canAccessPedidos)
                <a href="{{ route('admin.pedidos.index') }}"
                   @class([
                       'group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer',
                       'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isPedidosActive,
                       'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isPedidosActive
                   ])
                   @click.prevent="ajaxNavigate('{{ route('admin.pedidos.index') }}'); closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Pedidos</span>
                    @if($pedidosCount > 0)
                        <span class="ml-2 inline-flex items-center justify-center py-0.5 px-2 text-xs font-medium bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 rounded-full transition-colors duration-300 min-w-[1.5rem]">
                            {{ $pedidosCount }}
                        </span>
                    @endif
                </a>
                @endif

                <!-- Clientes - Admin, Gerente, Operador, Suporte -->
                @if($canAccessClientes)
                <a href="{{ route('admin.clientes.index') }}"
                   @class([
                       'group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer',
                       'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isClientesActive,
                       'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isClientesActive
                   ])
                   @click.prevent="ajaxNavigate('{{ route('admin.clientes.index') }}'); closeMobile()">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-6.5a6 6 0 01-6 6"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Clientes</span>
                </a>
                @endif

                <!-- Funcionários - Apenas Admin -->
                @if($canAccessFuncionarios)
                <div x-data="{ open: {{ $isFuncionariosActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            @class([
                                'w-full flex items-center justify-between px-3 py-3 rounded-lg transition-colors duration-200',
                                'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isFuncionariosActive,
                                'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isFuncionariosActive
                            ])>
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Funcionários</span>
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('admin.funcionarios.index') }}"
                           @class([
                               'flex items-center px-3 py-2 text-sm rounded transition-colors duration-200 cursor-pointer',
                               'text-blue-600 dark:text-blue-400' => $currentRoute === 'admin.funcionarios.index',
                               'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' => $currentRoute !== 'admin.funcionarios.index'
                           ])
                           @click.prevent="ajaxNavigate('{{ route('admin.funcionarios.index') }}'); closeMobile()">
                            Todos Funcionários
                            @if($funcionariosCount > 0)
                                <span class="ml-2 inline-flex items-center justify-center py-0.5 px-1.5 text-xs font-medium bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-full transition-colors duration-300 min-w-[1.25rem]">
                                    {{ $funcionariosCount }}
                                </span>
                            @endif
                        </a>
                        @if($userRole === Role::ADMIN->value)
                        <a href="{{ route('admin.funcionarios.create') }}"
                           @class([
                               'flex items-center px-3 py-2 text-sm rounded transition-colors duration-200 cursor-pointer',
                               'text-blue-600 dark:text-blue-400' => $currentRoute === 'admin.funcionarios.create',
                               'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' => $currentRoute !== 'admin.funcionarios.create'
                           ])
                           @click.prevent="ajaxNavigate('{{ route('admin.funcionarios.create') }}'); closeMobile()">
                            Novo Funcionário
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Cupons - Apenas Admin -->
                @if($canAccessCupons)
                <div x-data="{ open: {{ $isPromocoesActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            @class([
                                'w-full flex items-center justify-between px-3 py-3 rounded-lg transition-colors duration-200',
                                'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isPromocoesActive,
                                'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isPromocoesActive
                            ])>
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <span class="text-sm font-medium">Cupom</span>
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('admin.cupons.index') }}"
                           @class([
                               'flex items-center px-3 py-2 text-sm rounded transition-colors duration-200 cursor-pointer',
                               'text-blue-600 dark:text-blue-400' => $currentRoute === 'admin.cupons.index',
                               'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' => $currentRoute !== 'admin.cupons.index'
                           ])
                           @click.prevent="ajaxNavigate('{{ route('admin.cupons.index') }}'); closeMobile()">
                            Todos Cupons
                        </a>
                        @if($userRole === Role::ADMIN->value)
                        <a href="{{ route('admin.cupons.create') }}"
                           @class([
                               'flex items-center px-3 py-2 text-sm rounded transition-colors duration-200 cursor-pointer',
                               'text-blue-600 dark:text-blue-400' => $currentRoute === 'admin.cupons.create',
                               'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' => $currentRoute !== 'admin.cupons.create'
                           ])
                           @click.prevent="ajaxNavigate('{{ route('admin.cupons.create') }}'); closeMobile()">
                            Novo Cupom
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Relatório - Admin e Gerente -->
                @if($canAccessRelatorios)
                <a href="{{ route('admin.relatorios.index') }}"
                   @class([
                       'group flex items-center px-3 py-3 rounded-lg transition-colors duration-200 cursor-pointer',
                       'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300' => $isRelatorioActive,
                       'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => !$isRelatorioActive
                   ])
                   @click.prevent="ajaxNavigate('{{ route('admin.relatorios.index') }}'); closeMobile()">
                     <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18V3H3zm8 11V7m4 7V7m4 7V7"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">Relatórios</span>
                </a>
                @endif
            </nav>

            <!-- Footer -->
            <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full group flex items-center px-3 py-3 text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-700 dark:hover:text-red-300 rounded-lg transition-colors duration-200">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-sm font-medium flex-1 text-left">Sair</span>
                    </button>
                </form>
                
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400 text-center">
                    <p>B2CStore Admin © {{ date('Y') }}</p>
                    <p class="mt-1">v1.0.0</p>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    window.sidebarState = function() {
        return {
            isOpen: false,
            
            init() {
                this.isOpen = window.innerWidth >= 1024;
                this.syncWithGlobal();
                
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.isOpen = true;
                    } else {
                        this.isOpen = false;
                    }
                    this.syncBodyOverflow();
                });
                
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isOpen && window.innerWidth < 1024) {
                        this.close();
                    }
                });
            },
            
            syncWithGlobal() {
                window.openSidebar = () => this.open();
                window.closeSidebar = () => this.close();
                window.toggleSidebar = () => this.toggle();
            },
            
            open() {
                this.isOpen = true;
                this.syncBodyOverflow();
            },
            
            close() {
                if (window.innerWidth >= 1024) {
                    return;
                }
                this.isOpen = false;
                this.syncBodyOverflow();
            },
            
            closeMobile() {
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
                if (window.innerWidth < 1024 && this.isOpen) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            },
            
            ajaxNavigate(url) {
                if (window.innerWidth < 1024) {
                    this.close();
                }
                
                if (typeof Livewire !== 'undefined' && typeof Livewire.navigate === 'function') {
                    Livewire.navigate(url, {
                        preserveScroll: true,
                        preserveState: true
                    });
                } else {
                    window.location.href = url;
                }
            }
        };
    };
    
    window.openSidebar = function() {
        console.log('Sidebar functions loading...');
    };
</script>
@endpush

@push('styles')
<style>
    [x-cloak] { 
        display: none !important; 
    }
</style>
@endpush
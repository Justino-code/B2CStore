{{-- components/navbar/public.blade.php --}}
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 shadow-lg transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-white">
                        {{ config('app.name', 'Laravel') }}
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                    Início
                </a>
                <a href="{{ route('produtos') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                    Produtos
                </a>
                <a href="{{ route('categorias') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                    Categorias
                </a>
                <a href="{{ route('sobre') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                    Sobre
                </a>

                <!-- Botão Dark/Light Mode -->
                <x-theme-toggle-button />

                <!-- Auth Links / User Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Carrinho (apenas para clientes) -->
                        @if(auth()->user()->role === 'cliente')
                            <a href="{{ route('carrinho') }}" 
                               class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 group">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{-- Adicione aqui a contagem de itens do carrinho se tiver --}}
                                    0
                                </span>
                                <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-900 text-white 
                                            text-xs font-medium rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                    Carrinho
                                    <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                                </div>
                            </a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ openUserMenu: false }" @click.outside="openUserMenu = false">
                            <button @click="openUserMenu = !openUserMenu" 
                                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">
                                    {{ auth()->user()->name }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform duration-200" 
                                   :class="{ 'rotate-180': openUserMenu }"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="openUserMenu" 
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                                 style="display: none;">
                                <div class="py-1">
                                    <!-- Dashboard (para todos os usuários autenticados) -->
                                    <a href="{{ route('dashboard') }}" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-tachometer-alt mr-2 text-blue-500"></i>
                                        Dashboard
                                    </a>
                                    
                                    <!-- Carrinho (apenas para clientes) -->
                                    @if(auth()->user()->role === 'cliente')
                                        <a href="{{ route('carrinho') }}" 
                                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <i class="fas fa-shopping-cart mr-2 text-blue-500"></i>
                                            Carrinho
                                            <span class="ml-auto bg-blue-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                                0
                                            </span>
                                        </a>
                                    @endif

                                    <!-- Configurações (para admin e funcionários) -->
                                    @if(in_array(auth()->user()->role, ['admin', 'funcionario']))
                                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <i class="fas fa-cogs mr-2 text-purple-500"></i>
                                            Admin
                                        </a>
                                    @endif

                                    <!-- Logout -->
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Sair
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Links para não autenticados -->
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                            Registrar
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu + Dark Mode Toggle -->
            <div class="flex items-center md:hidden space-x-2">
                <!-- Carrinho Mobile (apenas para clientes autenticados) -->
                @auth
                    @if(auth()->user()->role === 'cliente')
                        <a href="{{ route('carrinho') }}" 
                           class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                0
                            </span>
                        </a>
                    @endif
                @endauth

                <!-- Botão Dark/Light Mode Mobile -->
                <x-theme-toggle-button />

                <!-- Mobile menu button -->
                <button @click="open = !open" 
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" @click.away="open = false" x-transition class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Início
                </a>
                <a href="{{ route('produtos') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Produtos
                </a>
                <a href="{{ route('categorias') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Categorias
                </a>
                <a href="{{ route('sobre') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Sobre
                </a>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    @auth
                        <!-- User Info Mobile -->
                        <div class="px-3 py-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Links Mobile -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-tachometer-alt mr-2 text-blue-500 w-5 text-center"></i>
                            Dashboard
                        </a>

                        @if(auth()->user()->role === 'cliente')
                            <a href="{{ route('carrinho') }}" 
                               class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-shopping-cart mr-2 text-blue-500 w-5 text-center"></i>
                                Carrinho
                                <span class="ml-auto bg-blue-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    0
                                </span>
                            </a>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'funcionario']))
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-cogs mr-2 text-purple-500 w-5 text-center"></i>
                                Admin
                            </a>
                        @endif

                        <!-- Logout Mobile -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left flex items-center px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2 w-5 text-center"></i>
                                Sair
                            </button>
                        </form>
                    @else
                        <!-- Links para não autenticados -->
                        <a href="{{ route('login') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors duration-200">
                            Registrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
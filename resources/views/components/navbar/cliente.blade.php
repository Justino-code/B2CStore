{{-- components/navbar/cliente.blade.php --}}
<nav class="bg-white dark:bg-gray-800 shadow-lg transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side: Logo and Mobile menu button -->
            <div class="flex items-center">
                <!-- Mobile sidebar toggle button - VISÍVEL ATÉ LG -->
                <button type="button" onclick="window.openSidebar()"
                        class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200">
                    <span class="sr-only">Abrir menu lateral</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center ml-2 lg:ml-0">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="ml-2 text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">
                        B2CStore
                    </span>
                </a>

                <!-- Desktop Navigation Links (apenas links principais) -->
                <div class="hidden lg:ml-8 lg:flex lg:space-x-6">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('loja')" class="text-base">
                        Loja
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side actions -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Dark Mode Toggle -->
                <x-theme-toggle-button />

                <!-- Carrinho -->
                <a href="{{ route('cliente.carrinho') }}" 
                   class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200"
                   title="Carrinho">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @auth
                        @php
                            $carrinhoCount = \App\Models\Carrinho::where('id_usuario', Auth::id())->first()?->itens()->count() ?? 0;
                        @endphp
                        @if($carrinhoCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ min($carrinhoCount, 9) }}
                                @if($carrinhoCount > 9)
                                    <span class="text-[8px]">+</span>
                                @endif
                            </span>
                        @endif
                    @endauth
                </a>

                <!-- Usuário - Ícone apenas -->
                <div class="flex items-center space-x-2">
                    <!-- Avatar pequeno -->
                    <img class="h-8 w-8 rounded-full border-2 border-gray-300 dark:border-gray-600"
                         src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1D4ED8&color=fff&size=256' }}"
                         alt="{{ Auth::user()->name }}"
                         loading="lazy">
                    
                    <!-- Nome em desktop (oculto em mobile) -->
                    <span class="hidden lg:block text-sm font-medium text-gray-700 dark:text-gray-300 truncate max-w-[120px]">
                        {{ Auth::user()->name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</nav>
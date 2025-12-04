<nav class="bg-white dark:bg-gray-800 shadow-lg transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Main Links -->
            <div class="flex items-center">
                <a href="" class="flex items-center">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-white">
                        B2CStore
                    </span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:ml-10 md:flex md:space-x-8">
                    <x-nav-link href="" :active="request()->routeIs('cliente.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link href="" :active="request()->routeIs('products.*')">
                        Produtos
                    </x-nav-link>
                    <x-nav-link href="" :active="request()->routeIs('cliente.orders.*')">
                        Meus Pedidos
                    </x-nav-link>
                    <x-nav-link href="" :active="request()->routeIs('cliente.favorites')">
                        Favoritos
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side actions -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <x-theme-toggle-button />

                <!-- Cart -->
                <a href="" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        0
                    </span>
                </a>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">Abrir menu do usuário</span>
                        <img class="h-8 w-8 rounded-full"
                             src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1D4ED8&color=fff' }}"
                             alt="{{ Auth::user()->name }}">
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 transition-colors duration-300">
                        <div class="px-4 py-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>
                        <a href="{{ route('cliente.profile') }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            Meu Perfil
                        </a>
                        <a href="{{ route('cliente.settings') }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            Configurações
                        </a>
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

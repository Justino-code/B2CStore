<nav class="flex-1 space-y-1 bg-white dark:bg-gray-800 px-2 pb-4 transition-colors duration-300" aria-label="Sidebar">
    <!-- Dashboard -->
    <a href=""
       class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>

    <!-- Produtos -->
    <div x-data="{ open: {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
        <button @click="open = !open" class="w-full text-left text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Catálogo
            <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" class="mt-1 space-y-1 pl-11">
            <a href=""
               class="{{ request()->routeIs('admin.products.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                Produtos
            </a>
            <a href=""
               class="{{ request()->routeIs('admin.categories.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                Categorias
            </a>
            <a href=""
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                Estoque
            </a>
        </div>
    </div>

    <!-- Pedidos -->
    <a href=""
       class="{{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        Pedidos
        <span class="ml-auto inline-block py-0.5 px-2 text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full transition-colors duration-300">
            12
        </span>
    </a>

    <!-- Clientes -->
    <a href=""
       class="{{ request()->routeIs('admin.customers.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-6.5a6 6 0 01-6 6"/>
        </svg>
        Clientes
    </a>

    <!-- Marketing -->
    <div x-data="{ open: false }">
        <button @click="open = !open" class="w-full text-left text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
            </svg>
            Marketing
            <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" class="mt-1 space-y-1 pl-11">
            <a href=""
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                Cupons
            </a>
            <a href=""
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                Campanhas
            </a>
        </div>
    </div>

    <!-- Relatórios -->
    <a href=""
       class="{{ request()->routeIs('admin.reports') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        Relatórios
    </a>

    <!-- Configurações -->
    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <a href=""
           class="{{ request()->routeIs('admin.settings') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Configurações
        </a>
    </div>
</nav>

{{-- components/footer/admin.blade.php --}}
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} B2CStore Admin v{{ config('app.version', '1.0.0') }}
            </div>
            <div class="flex items-center space-x-6">
                <!-- Stats -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Online: <span class="font-medium text-green-600 dark:text-green-400">5</span>
                        </span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Hoje: <span class="font-medium text-blue-600 dark:text-blue-400">12</span>
                        </span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Receita: <span class="font-medium text-purple-600 dark:text-purple-400">R$ 5.234</span>
                        </span>
                    </div>
                </div>

                <!-- Separator -->
                <div class="hidden md:block h-6 w-px bg-gray-300 dark:bg-gray-600"></div>

                <!-- System Info -->
                <div class="flex items-center space-x-4">
                    <!-- Botão de Tema -->
                    <x-theme-toggle-button />

                    <!-- System Status -->
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                        Status
                    </a>

                    <!-- Performance -->
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">100%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server Info -->
        <div class="mt-2 text-center text-xs text-gray-500 dark:text-gray-400">
            Servidor: {{ gethostname() }} • Memória: {{ number_format(memory_get_usage(true) / 1024 / 1024, 2) }} MB
        </div>
    </div>
</footer>

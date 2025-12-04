<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} B2CStore Admin. Sistema versão 1.0.0
            </div>
            <div class="mt-2 md:mt-0">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Usuários online: <span class="font-semibold text-green-600">5</span>
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Pedidos hoje: <span class="font-semibold text-blue-600">12</span>
                    </span>
                    <a href="{{ route('admin.status') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        Status do Sistema
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

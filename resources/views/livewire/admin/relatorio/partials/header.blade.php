<!-- Header -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                Relatórios Analíticos
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm md:text-base">
                Análise detalhada do desempenho da loja
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-2">
            <!-- Formato de Exportação -->
            <div class="relative">
                <select wire:model="formatoExportacao" 
                        class="pl-3 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm appearance-none">
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                    <option value="csv">CSV</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                    </svg>
                </div>
            </div>

            <!-- Botão Exportar -->
            <button wire:click="exportarRelatorio"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white rounded-lg font-medium text-sm transition-colors">
                <svg wire:loading.remove wire:target="exportarRelatorio" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <svg wire:loading wire:target="exportarRelatorio" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Exportar</span>
            </button>
        </div>
    </div>
</div>
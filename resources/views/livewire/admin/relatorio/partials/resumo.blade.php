<!-- Resumo do Relatório -->
<div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
        Resumo do Relatório
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Tipo de Relatório:</p>
            <p class="font-medium text-gray-900 dark:text-white capitalize">{{ $abaAtiva }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Período Analisado:</p>
            <p class="font-medium text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} 
                até {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
            </p>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Data de Geração:</p>
            <p class="font-medium text-gray-900 dark:text-white">{{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Formato de Exportação:</p>
            <p class="font-medium text-gray-900 dark:text-white uppercase">{{ $formatoExportacao }}</p>
        </div>
    </div>
</div>
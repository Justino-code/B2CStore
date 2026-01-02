<!-- Relatório de Categorias -->
<div class="space-y-6">
    <!-- Desempenho por Categoria -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                Desempenho por Categoria
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Categoria
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pedidos
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Produtos Vendidos
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Quantidade Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Valor Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Preço Médio
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($dadosCategorias['desempenhoCategorias'] ?? [] as $categoria)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $categoria->nome }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $categoria->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $categoria->ativo ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"/>
                                    </svg>
                                    {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-900 dark:text-white">
                                    {{ $categoria->pedidos }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-900 dark:text-white">
                                    {{ $categoria->produtos_vendidos }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $categoria->quantidade_total }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($categoria->valor_total) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ format_kwanza($categoria->preco_medio) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Nenhuma categoria com vendas no período.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Categorias sem Vendas -->
    @if(!empty($dadosCategorias['categoriasSemVendas']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Categorias sem Vendas (no período)
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Categoria
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total de Produtos
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosCategorias['categoriasSemVendas'] as $categoria)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $categoria->nome }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $categoria->produtos_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $categoria->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $categoria->ativo ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"/>
                                        </svg>
                                        {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Distribuição de Produtos por Categoria -->
    @if(!empty($dadosCategorias['distribuicaoProdutos']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Distribuição de Produtos por Categoria
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Categoria
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total de Produtos
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Produtos Ativos
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Com Estoque Baixo
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosCategorias['distribuicaoProdutos'] as $categoria)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $categoria->nome }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $categoria->total_produtos }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ $categoria->produtos_ativos }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $categoria->produtos_estoque_baixo > 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $categoria->produtos_estoque_baixo }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
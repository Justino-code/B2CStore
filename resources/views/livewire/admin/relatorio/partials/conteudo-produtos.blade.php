<!-- Relatório de Produtos -->
<div class="space-y-6">
    <!-- Produtos Mais Vendidos -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Produtos Mais Vendidos
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Ordenar por:</span>
                    <div class="flex space-x-1">
                        <button wire:click="alternarOrdenacao('quantidade_vendida')"
                                class="px-2 py-1 text-xs rounded {{ $ordenarPor === 'quantidade_vendida' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            Quantidade
                            @if($ordenarPor === 'quantidade_vendida')
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $direcaoOrdenacao === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                </svg>
                            @endif
                        </button>
                        <button wire:click="alternarOrdenacao('valor_total')"
                                class="px-2 py-1 text-xs rounded {{ $ordenarPor === 'valor_total' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            Valor
                            @if($ordenarPor === 'valor_total')
                                <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $direcaoOrdenacao === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                </svg>
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Produto
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            SKU
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Quantidade
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
                    @forelse($dadosProdutos['produtosMaisVendidos'] ?? [] as $produto)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $produto->nome }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $produto->sku }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $produto->quantidade_vendida }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($produto->valor_total) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ format_kwanza($produto->preco_medio_vendido) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Nenhum produto vendido no período selecionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Produtos com Estoque Baixo -->
    @if(!empty($dadosProdutos['estoqueBaixo']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Produtos com Estoque Baixo
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Produto
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estoque
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Preço
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Valor do Estoque
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosProdutos['estoqueBaixo'] as $produto)
                            @php
                                $nivelEstoque = match(true) {
                                    $produto->estoque < 3 => ['text' => 'text-red-600 dark:text-red-400', 'bg' => 'bg-red-100 dark:bg-red-900/30', 'label' => 'Crítico'],
                                    $produto->estoque < 5 => ['text' => 'text-orange-600 dark:text-orange-400', 'bg' => 'bg-orange-100 dark:bg-orange-900/30', 'label' => 'Baixo'],
                                    default => ['text' => 'text-yellow-600 dark:text-yellow-400', 'bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'label' => 'Atenção']
                                };
                            @endphp
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $produto->nome }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium {{ $nivelEstoque['text'] }}">
                                        {{ $produto->estoque }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ format_kwanza($produto->preco) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ format_kwanza($produto->preco * $produto->estoque) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $nivelEstoque['bg'] }} {{ $nivelEstoque['text'] }}">
                                        {{ $nivelEstoque['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Produtos Nunca Vendidos -->
    @if(!empty($dadosProdutos['produtosNuncaVendidos']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Produtos Nunca Vendidos (no período)
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Produto
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                SKU
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estoque
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Preço
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosProdutos['produtosNuncaVendidos'] as $produto)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $produto->nome }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $produto->sku }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $produto->estoque }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ format_kwanza($produto->preco) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Desempenho por Categoria -->
    @if(!empty($dadosProdutos['desempenhoCategorias']))
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
                                Pedidos
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Produtos Vendidos
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Valor Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosProdutos['desempenhoCategorias'] as $categoria)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $categoria->nome }}
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
                                        {{ format_kwanza($categoria->valor_total) }}
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
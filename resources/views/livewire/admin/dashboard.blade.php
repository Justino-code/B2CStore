<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Filtro de período -->
    <div class="mb-6 flex items-center justify-between">
        <div class="flex space-x-2">
            <button wire:click="alterarPeriodo('hoje')" 
                    class="px-4 py-2 rounded-md {{ $periodo === 'hoje' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Hoje
            </button>
            <button wire:click="alterarPeriodo('semana')" 
                    class="px-4 py-2 rounded-md {{ $periodo === 'semana' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Esta Semana
            </button>
            <button wire:click="alterarPeriodo('mes')" 
                    class="px-4 py-2 rounded-md {{ $periodo === 'mes' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Este Mês
            </button>
            <button wire:click="alterarPeriodo('ano')" 
                    class="px-4 py-2 rounded-md {{ $periodo === 'ano' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Este Ano
            </button>
        </div>
    </div>

    <!-- Cards de métricas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total de Vendas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total de Vendas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ format_kwanza($dadosDashboard['totalVendas'] ?? 0) }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Produtos Vendidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Produtos Vendidos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $dadosDashboard['totalProdutosVendidos'] ?? 0 }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total de Clientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total de Clientes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $dadosDashboard['totalClientes'] ?? 0 }}
                    </p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75l-4.5-2.48m0 0l-4.5 2.48m4.5-2.48v7.5"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Saldo Disponível -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Saldo Disponível</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ format_kwanza($dadosDashboard['saldo'] ?? 0) }}
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Status dos Pedidos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status dos Pedidos</h2>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach($dadosDashboard['pedidosStatus'] ?? [] as $status => $quantidade)
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $quantidade }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ $status }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Resumo Financeiro -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Resumo Financeiro</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Receita Total</span>
                    <span class="font-semibold text-green-600 dark:text-green-400">
                        {{ format_kwanza($dadosDashboard['receita'] ?? 0) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Pagamentos Pendentes</span>
                    <span class="font-semibold text-yellow-600 dark:text-yellow-400">
                        {{ format_kwanza($dadosDashboard['pagamentosPendentes'] ?? 0) }}
                    </span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900 dark:text-white">Saldo Disponível</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400">
                            {{ format_kwanza($dadosDashboard['saldo'] ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Pedidos e Estoque Baixo -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimos Pedidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Últimos Pedidos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pedido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($dadosDashboard['ultimosPedidos'] ?? [] as $pedido)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $pedido->codigo_pedido }}
                                    </span>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $pedido->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $pedido->usuario->nome }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full 
                                        {{ $pedido->status == 'entregue' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                        {{ $pedido->status == 'pendente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                        {{ $pedido->status == 'cancelado' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                        {{ $pedido->status == 'processando' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                        {{ $pedido->status == 'enviado' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : '' }}">
                                        {{ ucfirst($pedido->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ format_kwanza($pedido->total) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum pedido encontrado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Produtos com Estoque Baixo -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Estoque Baixo</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estoque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($dadosDashboard['estoqueBaixo'] ?? [] as $produto)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($produto->imagens->first())
                                                <img class="h-10 w-10 rounded-md object-cover" 
                                                     src="{{ image_url($produto->imagens->first()->url_imagem) }}" 
                                                     alt="{{ $produto->nome }}">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ \Illuminate\Support\Str::limit($produto->nome, 30) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ format_kwanza($produto->preco) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $produto->sku }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium 
                                        {{ $produto->estoque < 5 ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                        {{ $produto->estoque }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full 
                                        {{ $produto->estoque < 5 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                        {{ $produto->estoque < 5 ? 'Crítico' : 'Baixo' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum produto com estoque baixo
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
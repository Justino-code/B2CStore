<!-- Relatório de Vendas -->
<div class="space-y-6">
<!-- Cards de Resumo -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @php
        $cardsVendas = [
            [
                'titulo' => 'Total de Vendas', 
                'valor' => $dadosVendas['totais']['vendas'] ?? 0, 
                'formato' => 'currency', 
                'icone' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 
                'cor' => 'blue'
            ],
            [
                'titulo' => 'Total de Pedidos', 
                'valor' => $dadosVendas['totais']['pedidos'] ?? 0, 
                'formato' => 'number', 
                'icone' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 
                'cor' => 'green'
            ],
            [
                'titulo' => 'Pedidos Entregues', 
                'valor' => $dadosVendas['totais']['entregues'] ?? 0, 
                'formato' => 'number', 
                'icone' => 'M5 13l4 4L19 7', 
                'cor' => 'purple'
            ],
            [
                'titulo' => 'Ticket Médio', 
                'valor' => $dadosVendas['totais']['ticketMedio'] ?? 0, 
                'formato' => 'currency', 
                'icone' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 
                'cor' => 'yellow'
            ]
        ];
    @endphp
    
    @foreach($cardsVendas as $card)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ $card['titulo'] }}
                    </p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-2">
                        @php
                            $formato = $card['formato'] ?? 'number';
                        @endphp
                        
                        @if($formato === 'currency')
                            {{ format_kwanza($card['valor']) }}
                        @else
                            {{ number_format($card['valor']) }}
                        @endif
                    </p>
                </div>
                <div class="p-2 bg-{{ $card['cor'] }}-50 dark:bg-{{ $card['cor'] }}-900/30 rounded-full flex-shrink-0">
                    <svg class="w-5 h-5 text-{{ $card['cor'] }}-600 dark:text-{{ $card['cor'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icone'] }}"/>
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
</div>

    <!-- Gráfico de Vendas por Dia -->
    @if(!empty($dadosVendas['porDia']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Vendas por Dia
                </h2>
            </div>
            <div class="p-4 md:p-6">
                <canvas id="graficoVendasPorDia" height="250"></canvas>
            </div>
        </div>
    @endif

    <!-- Métodos de Pagamento -->
    @if(!empty($dadosVendas['metodosPagamento']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Métodos de Pagamento
                </h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($dadosVendas['metodosPagamento'] as $metodo)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white capitalize">
                                        {{ $metodo->metodo }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $metodo->total }} pedidos
                                    </p>
                                </div>
                                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    {{ $totalPedidos > 0 ? number_format(($metodo->total / $totalPedidos) * 100, 1) : 0 }}%
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Vendas por Status -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                Vendas por Status
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pedidos
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Valor Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Percentual
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @php
                        $totalPedidos = $dadosVendas['totais']['pedidos'] ?? 0;
                    @endphp
                    @forelse($dadosVendas['porStatus'] ?? [] as $status => $dados)
                        @php
                            $percentual = $totalPedidos > 0 ? ($dados['total'] / $totalPedidos * 100) : 0;
                            $statusClasses = [
                                'entregue' => ['bg' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300', 'icon' => 'M5 13l4 4L19 7'],
                                'pendente' => ['bg' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                'cancelado' => ['bg' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300', 'icon' => 'M6 18L18 6M6 6l12 12'],
                                'processando' => ['bg' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                                'enviado' => ['bg' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300', 'icon' => 'M5 10l7-7m0 0l7 7m-7-7v18']
                            ];
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$status]['bg'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusClasses[$status]['icon'] ?? 'M5 13l4 4L19 7' }}"/>
                                    </svg>
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $dados['total'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($dados['valor'] ?? 0) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentual }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 min-w-[50px]">
                                        {{ number_format($percentual, 1) }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Nenhuma venda encontrada no período.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
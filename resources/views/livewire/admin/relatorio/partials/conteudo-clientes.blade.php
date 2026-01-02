<!-- Relatório de Clientes -->
<div class="space-y-6">
    <!-- Cards de Resumo -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    @php
        $cardsClientes = [
            [
                'titulo' => 'Total de Clientes', 
                'valor' => $dadosClientes['totais']['totalClientes'] ?? 0, 
                'formato' => 'number',
                'icone' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75l-4.5-2.48m0 0l-4.5 2.48m4.5-2.48v7.5', 
                'cor' => 'blue'
            ],
            [
                'titulo' => 'Novos Clientes', 
                'valor' => $dadosClientes['totais']['novosClientes'] ?? 0, 
                'formato' => 'number',
                'icone' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1', 
                'cor' => 'green'
            ]
        ];
    @endphp
    
    @foreach($cardsClientes as $card)
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

    <!-- Clientes Mais Ativos -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                Clientes Mais Ativos
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pedidos
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Valor Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Ticket Médio
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Última Compra
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($dadosClientes['clientesMaisAtivos'] ?? [] as $cliente)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full border border-gray-200 dark:border-gray-600" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($cliente->nome) }}&background=random&color=fff"
                                             alt="{{ $cliente->nome }}">
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                                            {{ $cliente->nome }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px]">
                                            {{ $cliente->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $cliente->total_pedidos }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($cliente->valor_total) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ format_kwanza($cliente->total_pedidos > 0 ? $cliente->valor_total / $cliente->total_pedidos : 0) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($cliente->ultima_compra)
                                        {{ \Carbon\Carbon::parse($cliente->ultima_compra)->diffForHumans() }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Nenhum cliente ativo no período selecionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Clientes Inativos -->
    @if(!empty($dadosClientes['clientesInativos']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Clientes Inativos (últimos 90 dias)
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total de Pedidos
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Data de Cadastro
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosClientes['clientesInativos'] as $cliente)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex-shrink-0">
                                            <img class="h-8 w-8 rounded-full border border-gray-200 dark:border-gray-600" 
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($cliente->nome) }}&background=random&color=fff"
                                                 alt="{{ $cliente->nome }}">
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                                                {{ $cliente->nome }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px]">
                                                {{ $cliente->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $cliente->total_pedidos }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Distribuição Geográfica -->
    @if(!empty($dadosClientes['distribuicaoGeografica']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Distribuição Geográfica
                </h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-3">
                    @foreach($dadosClientes['distribuicaoGeografica'] as $cidade => $quantidade)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $cidade }}
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                                    @php
                                        $totalClientes = array_sum($dadosClientes['distribuicaoGeografica']->toArray());
                                        $percentual = $totalClientes > 0 ? ($quantidade / $totalClientes * 100) : 0;
                                    @endphp
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentual }}%"></div>
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $quantidade }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($percentual, 1) }}%
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
<!-- Relatório de Cupons -->
<div class="space-y-6">
    <!-- Estatísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cardsCupons = [
                [
                    'titulo' => 'Taxa de Utilização', 
                    'valor' => $dadosCupons['estatisticas']['taxaUtilizacao'] ?? 0, 
                    'sufixo' => '%', 
                    'formato' => 'percentual',
                    'icone' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z', 
                    'cor' => 'blue'
                ],
                [
                    'titulo' => 'Ticket Médio com Cupom', 
                    'valor' => $dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0, 
                    'formato' => 'currency', 
                    'icone' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 
                    'cor' => 'green'
                ],
                [
                    'titulo' => 'Ticket Médio sem Cupom', 
                    'valor' => $dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0, 
                    'formato' => 'currency', 
                    'icone' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 
                    'cor' => 'purple'
                ],
                [
                    'titulo' => 'Diferença', 
                    'valor' => ($dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0) - ($dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0), 
                    'formato' => 'currency_diferenca', 
                    'icone' => 'M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4', 
                    'cor' => ($dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0) >= ($dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0) ? 'green' : 'red'
                ]
            ];
        @endphp
        
        @foreach($cardsCupons as $card)
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
                            @elseif($formato === 'currency_diferenca')
                                <span class="{{ $card['valor'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $card['valor'] >= 0 ? '+' : '' }}{{ format_kwanza($card['valor']) }}
                                </span>
                            @elseif($formato === 'percentual')
                                {{ number_format($card['valor'], 1) }}{{ $card['sufixo'] ?? '' }}
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

    <!-- Cupons Mais Usados -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                Cupons Mais Usados
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Código
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Desconto
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Usos
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Total Descontado
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Valor Total Vendas
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($dadosCupons['cuponsMaisUsados'] ?? [] as $cupom)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $cupom->codigo }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Fixo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-900 dark:text-white">
                                    @if($cupom->tipo_desconto == 'percentual')
                                        {{ $cupom->valor_desconto }}%
                                    @else
                                        {{ format_kwanza($cupom->valor_desconto) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $cupom->usos }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-red-600 dark:text-red-400">
                                    -{{ format_kwanza($cupom->total_descontado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                    {{ format_kwanza($cupom->valor_total_vendas) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $cupom->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                    {{ $cupom->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Nenhum cupom utilizado no período.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cupons Expirados -->
    @if(!empty($dadosCupons['cuponsExpirados']))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Cupons Expirados (ainda ativos)
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Código
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Desconto
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Validade Fim
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dadosCupons['cuponsExpirados'] as $cupom)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $cupom->codigo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Fixo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        @if($cupom->tipo_desconto == 'percentual')
                                            {{ $cupom->valor_desconto }}%
                                        @else
                                            {{ format_kwanza($cupom->valor_desconto) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($cupom->validade_fim)->format('d/m/Y') }}
                                        <br>
                                        <small>({{ \Carbon\Carbon::parse($cupom->validade_fim)->diffForHumans() }})</small>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Expirado
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Estatísticas Detalhadas -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                Estatísticas Detalhadas
            </h2>
        </div>
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total de Pedidos:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $dadosCupons['estatisticas']['totalPedidos'] ?? 0 }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pedidos com Cupom:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $dadosCupons['estatisticas']['pedidosComCupom'] ?? 0 }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Taxa de Utilização:</span>
                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                            {{ number_format($dadosCupons['estatisticas']['taxaUtilizacao'] ?? 0, 1) }}%
                        </span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Ticket Médio com Cupom:</span>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">
                            {{ format_kwanza($dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Ticket Médio sem Cupom:</span>
                        <span class="text-sm font-medium text-purple-600 dark:text-purple-400">
                            {{ format_kwanza($dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Diferença:</span>
                        <span class="text-sm font-medium {{ ($dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0) >= ($dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ ($dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0) >= ($dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0) ? '+' : '' }}{{ format_kwanza(($dadosCupons['estatisticas']['valorMedioComCupom'] ?? 0) - ($dadosCupons['estatisticas']['valorMedioSemCupom'] ?? 0)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
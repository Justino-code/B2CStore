{{-- resources/views/livewire/admin/dashboard.blade.php --}}
<div class="space-y-6">
    <!-- Cabeçalho com Botão de Atualização -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Última atualização: {{ now()->format('d/m/Y H:i') }}
            </p>
        </div>
        <button wire:click="atualizarDados"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg wire:loading.remove wire:target="atualizarDados" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <svg wire:loading wire:target="atualizarDados" class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span wire:loading.remove wire:target="atualizarDados">Atualizar Dados</span>
            <span wire:loading wire:target="atualizarDados">Atualizando...</span>
        </button>
    </div>

    <!-- Visão Geral de Estatísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-admin.cards.stat-card
            title="Vendas Totais"
            :value="$stats['vendas_totais']['valor'] ?? 'R$ 0,00'"
            :change="$stats['vendas_totais']['variacao'] ?? '0%'"
            :trend="$stats['vendas_totais']['tendencia'] ?? 'neutral'"
            icon="dollar"
            color="blue"
        />

        <x-admin.cards.stat-card
            title="Pedidos"
            :value="$stats['total_pedidos']['valor'] ?? '0'"
            :change="$stats['total_pedidos']['variacao'] ?? '0%'"
            :trend="$stats['total_pedidos']['tendencia'] ?? 'neutral'"
            icon="shopping-cart"
            color="green"
        />

        <x-admin.cards.stat-card
            title="Clientes"
            :value="$stats['total_clientes']['valor'] ?? '0'"
            :change="$stats['total_clientes']['variacao'] ?? '0%'"
            :trend="$stats['total_clientes']['tendencia'] ?? 'neutral'"
            icon="users"
            color="purple"
        />

        <x-admin.cards.stat-card
            title="Produtos"
            :value="$stats['total_produtos']['valor'] ?? '0'"
            :change="$stats['total_produtos']['variacao'] ?? '0%'"
            :trend="$stats['total_produtos']['tendencia'] ?? 'neutral'"
            icon="box"
            color="yellow"
        />
    </div>

    <!-- Seção de Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico de Receita -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 space-y-4 sm:space-y-0">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Vendas dos Últimos {{ $periodoSelecionado }} Dias</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Desempenho de vendas diárias</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Período:</span>
                        <select wire:model.live="periodoSelecionado"
                                class="text-sm border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
                            <option value="7">7 dias</option>
                            <option value="30">30 dias</option>
                            <option value="90">90 dias</option>
                        </select>
                    </div>
                </div>

                <!-- Gráfico -->
                <div x-data="{
                    grafico: null,
                    iniciar() {
                        const ctx = this.$refs.canvasGrafico;
                        const dados = @js($dadosGrafico);

                        this.grafico = new Chart(ctx, {
                            type: 'line',
                            data: dados,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151'
                                        }
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.dataset.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                if (context.datasetIndex === 1) {
                                                    label += 'R$ ' + context.parsed.y.toFixed(2).replace('.', ',');
                                                } else {
                                                    label += context.parsed.y;
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#e5e7eb'
                                        },
                                        ticks: {
                                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#9ca3af' : '#6b7280'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#e5e7eb'
                                        },
                                        ticks: {
                                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#9ca3af' : '#6b7280',
                                            callback: function(value) {
                                                if (this.scale.id === 'y') {
                                                    return 'R$ ' + value.toFixed(0);
                                                }
                                                return value;
                                            }
                                        }
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'nearest'
                                }
                            }
                        });

                        // Atualizar gráfico ao mudar tema
                        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                            const isDark = e.matches;
                            this.grafico.options.plugins.legend.labels.color = isDark ? '#d1d5db' : '#374151';
                            this.grafico.options.scales.x.grid.color = isDark ? '#374151' : '#e5e7eb';
                            this.grafico.options.scales.x.ticks.color = isDark ? '#9ca3af' : '#6b7280';
                            this.grafico.options.scales.y.grid.color = isDark ? '#374151' : '#e5e7eb';
                            this.grafico.options.scales.y.ticks.color = isDark ? '#9ca3af' : '#6b7280';
                            this.grafico.update();
                        });
                    }
                }"
                x-init="iniciar"
                wire:ignore>
                    <div class="h-64">
                        <canvas x-ref="canvasGrafico"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produtos Mais Vendidos -->
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Produtos Mais Vendidos</h3>

                <div class="space-y-4">
                    @forelse($produtosMaisVendidos as $produto)
                        <div class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors duration-200">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $produto['posicao'] }}</span>
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $produto['nome'] }}
                                </p>
                                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $produto['total_vendido'] }} vendas</span>
                                    <span>•</span>
                                    <span>{{ $produto['receita_total'] }}</span>
                                </div>
                            </div>
                            <x-admin.badges.status :status="$produto['status']" size="sm" />
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nenhum produto vendido ainda</p>
                        </div>
                    @endforelse
                </div>

                <a href="{{ route('home') }}"
                   class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                    Ver todos os produtos
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Pedidos Recentes & Ações Rápidas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pedidos Recentes -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pedidos Recentes</h3>
                        <a href="{{ route('home') }}"
                           class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            Ver todos
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Pedido
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Data
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pedidosRecentes as $pedido)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $pedido['codigo_pedido'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $pedido['nome_cliente'] }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $pedido['email_cliente'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $pedido['data'] }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $pedido['hora'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                        {{ $pedido['total'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusTraduzido = match($pedido['status']) {
                                                'pendente' => 'pending',
                                                'pago' => 'approved',
                                                'processando' => 'processing',
                                                'enviado' => 'completed',
                                                'entregue' => 'completed',
                                                'cancelado' => 'cancelled',
                                                default => 'pending',
                                            };
                                        @endphp
                                        <x-admin.badges.status :status="$statusTraduzido" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('home', $pedido['id_pedido']) }}"
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-medium">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nenhum pedido encontrado</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div>
            <div class="space-y-6">
                <x-admin.cards.action-card
                    title="Adicionar Produto"
                    description="Crie um novo produto no catálogo"
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>'
                    :action="route('home')"
                    actionText="Criar Produto"
                    color="green"
                />

                <x-admin.cards.action-card
                    title="Ver Relatórios"
                    description="Acesse relatórios detalhados"
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'
                    :action="route('home')"
                    actionText="Ver Relatórios"
                    color="blue"
                />

                <x-admin.cards.info-card
                    title="Status do Sistema"
                    description="Todos os sistemas operando normalmente"
                    variant="success"
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                    :action="route('home')"
                    actionText="Ver detalhes"
                />
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ouvir eventos do Livewire
    document.addEventListener('livewire:init', () => {
        Livewire.on('notificar', (data) => {
            if (typeof window.showNotification === 'function') {
                window.showNotification(data.tipo, data.mensagem);
            }
        });
    });
</script>
@endpush

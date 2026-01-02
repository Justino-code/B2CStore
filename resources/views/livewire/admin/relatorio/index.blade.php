{{--resources/views/livewire/admin/relatorio/index.blade.php--}}
<div class="p-4 md:p-6 bg-gray-50 dark:bg-gray-900 min-h-screen" 
     x-data="relatorioGraficos()" 
     x-init="init()" 
     x-effect="iniciarGraficos()">
    
    <!-- Header -->
    @include('livewire.admin.relatorio.partials.header')
    
    <!-- Filtros -->
    @include('livewire.admin.relatorio.partials.filtros')

    <!-- Loading State -->
    @if($isLoading)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 mb-6">
            <div class="flex flex-col items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-600 dark:text-gray-400">Carregando dados do relatório...</p>
            </div>
        </div>
    @endif

    <!-- Abas -->
    @include('livewire.admin.relatorio.partials.abas')

    <!-- Conteúdo das Abas -->
    <div class="space-y-6">
        @switch($abaAtiva)
            @case('vendas')
                @include('livewire.admin.relatorio.partials.conteudo-vendas')
                @break

            @case('produtos')
                @include('livewire.admin.relatorio.partials.conteudo-produtos')
                @break

            @case('clientes')
                @include('livewire.admin.relatorio.partials.conteudo-clientes')
                @break

            @case('categorias')
                @include('livewire.admin.relatorio.partials.conteudo-categorias')
                @break

            @case('cupons')
                @include('livewire.admin.relatorio.partials.conteudo-cupons')
                @break
        @endswitch
    </div>

    <!-- Resumo do Relatório -->
    @include('livewire.admin.relatorio.partials.resumo')

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function relatorioGraficos() {
        return {
            init() {
                // Inicializar gráficos
                this.iniciarGraficos();
            },
            iniciarGraficos() {
                if (this.$wire.abaAtiva === 'vendas' && this.$wire.dadosVendas.porDia?.length > 0) {
                    this.renderizarGraficoVendas();
                }
            },
            renderizarGraficoVendas() {
                const canvas = document.getElementById('graficoVendasPorDia');
                if (!canvas) return;

                // Limpar gráfico anterior se existir
                if (canvas.chart) {
                    canvas.chart.destroy();
                }

                const ctx = canvas.getContext('2d');
                const dados = this.$wire.dadosVendas.porDia || [];
                
                if (dados.length === 0) {
                    canvas.style.display = 'none';
                    return;
                }

                canvas.style.display = 'block';
                
                canvas.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dados.map(item => new Date(item.data).toLocaleDateString('pt-BR')),
                        datasets: [{
                            label: 'Valor Total (Kz)',
                            data: dados.map(item => item.total),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.1,
                            yAxisID: 'y'
                        }, {
                            label: 'Número de Pedidos',
                            data: dados.map(item => item.pedidos),
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.1,
                            yAxisID: 'y1'
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        stacked: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.datasetIndex === 0) {
                                            label += 'Kz ' + context.parsed.y.toLocaleString('pt-BR');
                                        } else {
                                            label += context.parsed.y + ' pedidos';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Valor (Kz)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Kz ' + value.toLocaleString('pt-BR');
                                    }
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Pedidos'
                                },
                                grid: {
                                    drawOnChartArea: false,
                                },
                            }
                        }
                    }
                });
            }
        }
    }
</script>
@endpush
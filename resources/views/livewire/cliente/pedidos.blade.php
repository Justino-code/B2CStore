<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Título e Estatísticas -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <a 
                    href="{{ route('home') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Novo Pedido
                </a>
            </div>

            <!-- Estatísticas -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total de Pedidos</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['total'] }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Entregues</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $estatisticas['entregues'] }}</p>
                        </div>
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pendentes</p>
                            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $estatisticas['pendentes'] }}</p>
                        </div>
                        <div class="p-2 bg-amber-100 dark:bg-amber-900 rounded-lg">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Processando</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $estatisticas['processando'] }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 mb-6">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filtrar Pedidos</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status
                        </label>
                        <select 
                            wire:model.live="statusFiltro"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Todos os status</option>
                            <option value="pendente">Pendente</option>
                            <option value="pago">Pago</option>
                            <option value="processando">Processando</option>
                            <option value="enviado">Enviado</option>
                            <option value="entregue">Entregue</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <!-- Data Início -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Data Início
                        </label>
                        <input 
                            type="date" 
                            wire:model.live="dataInicio"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Data Fim -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Data Fim
                        </label>
                        <input 
                            type="date" 
                            wire:model.live="dataFim"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Busca -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Buscar
                        </label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="busca"
                            placeholder="Código ou produto..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <!-- Itens por página e ordenação -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Itens por página:</span>
                        <select 
                            wire:model.live="porPagina"
                            class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button 
                            wire:click="limparFiltros"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            Limpar Filtros
                        </button>
                        <button 
                            wire:click="aplicarFiltros"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($pedidos->count() > 0)
                <!-- Cabeçalho da Tabela (Desktop) -->
                <div class="hidden md:grid grid-cols-12 gap-4 p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="col-span-3">
                        <button 
                            wire:click="ordenar('codigo_pedido')"
                            class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                        >
                            Pedido
                            @if($ordenarPor === 'codigo_pedido')
                                <svg class="w-4 h-4 ml-1 {{ $ordenarDirecao === 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            @endif
                        </button>
                    </div>
                    <div class="col-span-2">
                        <button 
                            wire:click="ordenar('created_at')"
                            class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                        >
                            Data
                            @if($ordenarPor === 'created_at')
                                <svg class="w-4 h-4 ml-1 {{ $ordenarDirecao === 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            @endif
                        </button>
                    </div>
                    <div class="col-span-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Produtos</span>
                    </div>
                    <div class="col-span-2">
                        <button 
                            wire:click="ordenar('total')"
                            class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                        >
                            Valor
                            @if($ordenarPor === 'total')
                                <svg class="w-4 h-4 ml-1 {{ $ordenarDirecao === 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            @endif
                        </button>
                    </div>
                    <div class="col-span-2">
                        <button 
                            wire:click="ordenar('status')"
                            class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                        >
                            Status
                            @if($ordenarPor === 'status')
                                <svg class="w-4 h-4 ml-1 {{ $ordenarDirecao === 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            @endif
                        </button>
                    </div>
                    <div class="col-span-1">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Ações</span>
                    </div>
                </div>

                <!-- Lista de Pedidos -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($pedidos as $pedido)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                <!-- Código do Pedido -->
                                <div class="md:col-span-3">
                                    <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">Pedido</div>
                                    <div class="flex items-center">
                                        <div class="p-2 bg-gray-100 dark:bg-gray-600 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                {{ $pedido->codigo_pedido }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $pedido->itens->count() }} item(s)
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data -->
                                <div class="md:col-span-2">
                                    <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">Data</div>
                                    <div class="text-gray-900 dark:text-white">
                                        <p>{{ $pedido->created_at->format('d/m/Y') }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $pedido->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Produtos -->
                                <div class="md:col-span-2">
                                    <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">Produtos</div>
                                    <div class="flex -space-x-2">
                                        @foreach($pedido->itens->take(3) as $item)
                                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-800 overflow-hidden bg-gray-100 dark:bg-gray-600">
                                                @if($item->produto->imagens->first())
                                                    <img 
                                                        src="{{ $item->produto->imagens->first()->url_imagem }}" 
                                                        alt="{{ $item->produto->nome }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <span class="text-xs text-gray-600 dark:text-gray-400">
                                                            {{ strtoupper(substr($item->produto->nome, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($pedido->itens->count() > 3)
                                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-800 bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                                    +{{ $pedido->itens->count() - 3 }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Valor -->
                                <div class="md:col-span-2">
                                    <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">Valor</div>
                                    <div class="text-gray-900 dark:text-white">
                                        <p class="font-bold"> {{ format_kwanza($pedido->total) }}</p>
                                        @if($pedido->custo_envio > 0)
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Frete: {{ format_kwanza($pedido->custo_envio) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="md:col-span-2">
                                    <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">Status</div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($pedido->status == 'entregue') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($pedido->status == 'enviado') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @elseif($pedido->status == 'processando') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($pedido->status == 'pago') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                        @elseif($pedido->status == 'cancelado') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                        @endif">
                                        @if($pedido->status == 'pendente')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($pedido->status == 'processando')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        @elseif($pedido->status == 'enviado')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($pedido->status == 'entregue')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                        {{ ucfirst($pedido->status) }}
                                    </span>
                                </div>

                                <!-- Ações -->
                                <div class="md:col-span-1">
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            wire:click="verDetalhes({{ $pedido->id_pedido }})"
                                            class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg"
                                            title="Ver detalhes"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        @if($pedido->status !== 'cancelado')
                                            <button 
                                                wire:click="confirmarRepetirPedido({{ $pedido->id_pedido }})"
                                                class="p-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg"
                                                title="Repetir pedido"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Ações Móvel -->
                            <div class="mt-4 md:hidden flex flex-wrap gap-2">
                                <button 
                                    wire:click="verDetalhes({{ $pedido->id_pedido }})"
                                    class="flex-1 px-3 py-2 bg-gray-800 dark:bg-gray-700 text-white text-sm rounded-lg"
                                >
                                    Detalhes
                                </button>
                                @if($pedido->status !== 'cancelado')
                                    <button 
                                        wire:click="confirmarRepetirPedido({{ $pedido->id_pedido }})"
                                        class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-lg"
                                    >
                                        Repetir
                                    </button>
                                @endif
                                @if($pedido->status === 'pendente')
                                    <button 
                                        wire:click="cancelarPedido({{ $pedido->id_pedido }})"
                                        onclick="return confirm('Tem certeza que deseja cancelar este pedido?')"
                                        class="flex-1 px-3 py-2 bg-red-600 text-white text-sm rounded-lg"
                                    >
                                        Cancelar
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $pedidos->links() }}
                </div>
            @else
                <!-- Sem Pedidos -->
                <div class="p-12 text-center">
                    <div class="w-24 h-24 mx-auto text-gray-400 mb-6">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Nenhum pedido encontrado</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        @if($statusFiltro || $busca || $dataInicio || $dataFim)
                            Não encontramos pedidos com os filtros aplicados. Tente ajustar sua busca.
                        @else
                            Você ainda não realizou nenhum pedido. Explore nossos produtos e faça sua primeira compra!
                        @endif
                    </p>
                    <div class="space-x-4">
                        @if($statusFiltro || $busca || $dataInicio || $dataFim)
                            <button 
                                wire:click="limparFiltros"
                                class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700"
                            >
                                Limpar Filtros
                            </button>
                        @endif
                        <a 
                            href="{{ route('home') }}"
                            class="inline-block px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            Ir para Loja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detalhes do Pedido -->
    @if($mostrarDetalhes && $pedidoSelecionado)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <!-- Cabeçalho -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Pedido {{ $pedidoSelecionado->codigo_pedido }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Realizado em {{ $pedidoSelecionado->created_at->format('d/m/Y \à\s H:i') }}
                        </p>
                    </div>
                    <button 
                        wire:click="fecharDetalhes"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Conteúdo Scrollável -->
                <div class="overflow-y-auto max-h-[calc(90vh-200px)]">
                    <!-- Status e Progresso -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-4 py-2 rounded-full text-sm font-medium
                                @if($pedidoSelecionado->status == 'entregue') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($pedidoSelecionado->status == 'enviado') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                @elseif($pedidoSelecionado->status == 'processando') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @elseif($pedidoSelecionado->status == 'pago') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                @elseif($pedidoSelecionado->status == 'cancelado') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                @endif">
                                {{ ucfirst($pedidoSelecionado->status) }}
                            </span>
                            @if($pedidoSelecionado->data_entrega)
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Previsão de entrega</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $pedidoSelecionado->data_entrega->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Linha do Tempo -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Progresso do pedido</span>
                                @if($pedidoSelecionado->metodo_envio)
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $pedidoSelecionado->metodo_envio }}
                                    </span>
                                @endif
                            </div>
                            <div class="relative">
                                <!-- Linha -->
                                <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                
                                <!-- Passos -->
                                <div class="relative flex justify-between">
                                    @php
                                        $passos = [
                                            'pendente' => ['icon' => '🛒', 'label' => 'Pedido Realizado'],
                                            'pago' => ['icon' => '💳', 'label' => 'Pagamento Confirmado'],
                                            'processando' => ['icon' => '⚙️', 'label' => 'Processando'],
                                            'enviado' => ['icon' => '🚚', 'label' => 'Enviado'],
                                            'entregue' => ['icon' => '📦', 'label' => 'Entregue']
                                        ];
                                        $statusIndex = array_search($pedidoSelecionado->status, array_keys($passos));
                                    @endphp
                                    
                                    @foreach($passos as $statusKey => $passo)
                                        <div class="flex flex-col items-center relative z-10">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                                @if($statusIndex >= array_search($statusKey, array_keys($passos)))
                                                    bg-blue-600 text-white
                                                @else
                                                    bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400
                                                @endif">
                                                {{ $passo['icon'] }}
                                            </div>
                                            <span class="mt-2 text-xs text-center {{ $statusIndex >= array_search($statusKey, array_keys($passos)) ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                                                {{ $passo['label'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Produtos -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Produtos</h4>
                        <div class="space-y-4">
                            @foreach($pedidoSelecionado->itens as $item)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-600">
                                            @if($item->produto->imagens->first())
                                                <img 
                                                    src="{{ $item->produto->imagens->first()->url_imagem }}" 
                                                    alt="{{ $item->produto->nome }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                {{ $item->produto->nome }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Quantidade: {{ $item->quantidade }} × {{ format_kwanza($item->preco_unitario) }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                SKU: {{ $item->produto->sku }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900 dark:text-white">
                                            {{ format_kwanza($item->quantidade * $item->preco_unitario) }}
                                        </p>
                                        @if($item->produto->estoque > 0)
                                            <button 
                                                wire:click="$dispatch('adicionar-ao-carrinho', { produtoId: {{ $item->id_produto }} })"
                                                class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline"
                                            >
                                                Comprar novamente
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Resumo Financeiro -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Resumo do Pedido</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-white">
                                    {{ format_kwanza($pedidoSelecionado->total - $pedidoSelecionado->custo_envio + ($pedidoSelecionado->valor_desconto ?? 0)) }}
                                </span>
                            </div>
                            
                            @if($pedidoSelecionado->custo_envio > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Frete</span>
                                    <span class="text-gray-900 dark:text-white">
                                        {{ format_kwanza($pedidoSelecionado->custo_envio) }}
                                    </span>
                                </div>
                            @endif
                            
                            @if($pedidoSelecionado->valor_desconto > 0)
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Desconto</span>
                                    <span>- {{ format_kwanza($pedidoSelecionado->valor_desconto) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-700 pt-3">
                                <span class="text-gray-900 dark:text-white">Total</span>
                                <span class="text-gray-900 dark:text-white">
                                    {{ format_kwanza($pedidoSelecionado->total) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Informações de Entrega e Pagamento -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Endereço de Entrega -->
                            <div>
                                <h5 class="font-medium text-gray-900 dark:text-white mb-3">Endereço de Entrega</h5>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ $pedidoSelecionado->endereco_entrega }}</p>
                                </div>
                            </div>

                            <!-- Informações de Pagamento -->
                            <div>
                                <h5 class="font-medium text-gray-900 dark:text-white mb-3">Pagamento</h5>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    @if($pedidoSelecionado->pagamento)
                                        <div class="space-y-2">
                                            <p class="text-gray-900 dark:text-white">
                                                Método: {{ ucfirst($pedidoSelecionado->pagamento->metodo) }}
                                            </p>
                                            <p class="text-gray-900 dark:text-white">
                                                Status: 
                                                <span class="{{ $pedidoSelecionado->pagamento->status == 'pago' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                                    {{ ucfirst($pedidoSelecionado->pagamento->status) }}
                                                </span>
                                            </p>
                                            <p class="text-gray-900 dark:text-white">
                                                Valor: {{ format_kwanza($pedidoSelecionado->pagamento->valor) }}
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400">Informações de pagamento não disponíveis</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($pedidoSelecionado->observacoes)
                            <div class="mt-6">
                                <h5 class="font-medium text-gray-900 dark:text-white mb-3">Observações</h5>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ $pedidoSelecionado->observacoes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Rodapé do Modal -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <div class="space-x-3">
                            <button 
                                wire:click="confirmarRepetirPedido({{ $pedidoSelecionado->id_pedido }})"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            >
                                Repetir Pedido
                            </button>
                            <button 
                                wire:click="baixarNotaFiscal({{ $pedidoSelecionado->id_pedido }})"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                Nota Fiscal
                            </button>
                        </div>
                        @if($pedidoSelecionado->status === 'pendente')
                            <button 
                                wire:click="cancelarPedido({{ $pedidoSelecionado->id_pedido }})"
                                onclick="return confirm('Tem certeza que deseja cancelar este pedido?')"
                                class="px-4 py-2 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900"
                            >
                                Cancelar Pedido
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Confirmar Repetir Pedido -->
    @if($mostrarModalRepetir && $pedidoParaRepetir)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-2">
                        Repetir Pedido
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 text-center mb-4">
                        Deseja adicionar todos os itens do pedido 
                        <span class="font-medium text-gray-900 dark:text-white">{{ $pedidoParaRepetir->codigo_pedido }}</span> 
                        ao carrinho?
                    </p>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            Itens do pedido:
                        </p>
                        <ul class="text-sm space-y-1">
                            @foreach($pedidoParaRepetir->itens as $item)
                                <li class="flex items-center justify-between">
                                    <span class="text-gray-900 dark:text-white truncate mr-2">
                                        {{ $item->produto->nome }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400">
                                        {{ $item->quantidade }}×
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="flex justify-center space-x-3">
                        <button 
                            wire:click="$set('mostrarModalRepetir', false)"
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            Cancelar
                        </button>
                        <button 
                            wire:click="repetirPedido"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('carrinho-atualizado', () => {
            // Atualizar contador do carrinho no navbar
            const event = new CustomEvent('atualizar-contador-carrinho');
            window.dispatchEvent(event);
        });

        Livewire.on('notificar', (data) => {
            mostrarToast(data.tipo, data.mensagem);
        });
    });

    function mostrarToast(tipo, mensagem) {
        // Usar a mesma função de toast dos outros componentes
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 translate-x-full`;
        
        if (tipo === 'sucesso') {
            toast.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700', 'dark:bg-green-900', 'dark:border-green-700', 'dark:text-green-300');
        } else if (tipo === 'erro') {
            toast.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'dark:bg-red-900', 'dark:border-red-700', 'dark:text-red-300');
        } else {
            toast.classList.add('bg-blue-100', 'border', 'border-blue-400', 'text-blue-700', 'dark:bg-blue-900', 'dark:border-blue-700', 'dark:text-blue-300');
        }
        
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${tipo === 'sucesso' ? 'M5 13l4 4L19 7' : tipo === 'erro' ? 'M6 18L18 6M6 6l12 12' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}" />
                </svg>
                <span>${mensagem}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 10);
        
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 4000);
        
        toast.addEventListener('click', () => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        });
    }
</script>
@endpush
<!-- Filtros Principais -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm mb-4 md:mb-6 p-4 md:p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Período -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Período
                </div>
            </label>
            <div class="relative">
                <select wire:model.live="periodo" 
                        class="w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                    <option value="hoje">Hoje</option>
                    <option value="semana">Esta Semana</option>
                    <option value="mes">Este Mês</option>
                    <option value="30dias">Últimos 30 Dias</option>
                    <option value="trimestre">Este Trimestre</option>
                    <option value="ano">Este Ano</option>
                    <option value="personalizado">Personalizado</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Data Início -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Data Início
            </label>
            <div class="relative">
                <input type="date" 
                       wire:model.live="dataInicio"
                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
            </div>
        </div>

        <!-- Data Fim -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Data Fim
            </label>
            <div class="relative">
                <input type="date" 
                       wire:model.live="dataFim"
                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
            </div>
        </div>

        <!-- Categoria -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Categoria
                </div>
            </label>
            <div class="relative">
                <select wire:model.live="categoriaId" 
                        class="w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                    <option value="">Todas as Categorias</option>
                    @foreach($this->categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nome }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Produto -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Produto
                </div>
            </label>
            <div class="relative">
                <select wire:model.live="produtoId" 
                        class="w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                    <option value="">Todos os Produtos</option>
                    @foreach($this->produtos as $produto)
                        <option value="{{ $produto->id_produto }}">{{ $produto->nome }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Avançados (Mostrar quando relevante) -->
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if(in_array($abaAtiva, ['vendas', 'clientes', 'cupons']))
                <!-- Cliente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cliente
                    </label>
                    <div class="relative">
                        <select wire:model.live="clienteId" 
                                class="w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                            <option value="">Todos os Clientes</option>
                            @foreach($this->clientes as $cliente)
                                <option value="{{ $cliente->id_usuario }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif

            @if($abaAtiva === 'vendas')
                <!-- Status do Pedido -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status do Pedido
                    </label>
                    <div class="relative">
                        <select wire:model.live="statusPedido" 
                                class="w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                            <option value="">Todos os Status</option>
                            <option value="pendente">Pendente</option>
                            <option value="processando">Processando</option>
                            <option value="enviado">Enviado</option>
                            <option value="entregue">Entregue</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Método de Pagamento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Método de Pagamento
                    </label>
                    <div class="relative">
                        <select wire:model.live="metodoPagamento" 
                                class="w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                            <option value="">Todos os Métodos</option>
                            @foreach($this->metodosPagamento as $valor => $label)
                                <option value="{{ $valor }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Ações dos Filtros -->
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                @if($dataInicio && $dataFim)
                    Período: {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} 
                    até {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                @endif
            </div>
            
            <div class="flex flex-wrap gap-2">
                @if($categoriaId || $produtoId || $statusPedido || $clienteId || $metodoPagamento)
                    <button wire:click="limparFiltros"
                            class="inline-flex items-center px-3 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Limpar Filtros
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
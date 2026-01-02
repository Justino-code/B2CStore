<div class="p-4 md:p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white truncate">
                    Gestão de Pedidos
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm md:text-base">
                    Gerencie os pedidos dos seus clientes
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <!-- Botão Imprimir -->
                <button onclick="window.print()"
                        class="inline-flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium text-sm transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Imprimir</span>
                    <span class="inline sm:hidden">Imprimir</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Total de Pedidos -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 truncate">Total de Pedidos</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mt-1 md:mt-2">
                        {{ $totalPedidos }}
                    </p>
                </div>
                <div class="p-2 md:p-3 bg-blue-50 dark:bg-blue-900/30 rounded-full flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pendentes -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 truncate">Pedidos Pendentes</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mt-1 md:mt-2">
                        {{ $totalPendentes }}
                    </p>
                </div>
                <div class="p-2 md:p-3 bg-yellow-50 dark:bg-yellow-900/30 rounded-full flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Em Processamento -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 truncate">Em Processamento</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mt-1 md:mt-2">
                        {{ $totalProcessando }}
                    </p>
                </div>
                <div class="p-2 md:p-3 bg-purple-50 dark:bg-purple-900/30 rounded-full flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm mb-4 md:mb-6 p-4 md:p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Busca -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Buscar Pedidos
                </label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Código, cliente ou endereço..."
                           class="pl-10 w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm md:text-base">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status
                </label>
                <div class="relative">
                    <select wire:model.live="status" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm md:text-base pr-10">
                        <option value="">Todos</option>
                        <option value="pendente">Pendente</option>
                        <option value="processando">Processando</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregue">Entregue</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cliente -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Cliente
                </label>
                <div class="relative">
                    <select wire:model.live="clienteId" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm md:text-base pr-10">
                        <option value="">Todos</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_usuario }}">
                                {{ \Illuminate\Support\Str::limit($cliente->nome, 15) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Data -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Período
                </label>
                <div class="space-y-2">
                    <div class="relative">
                        <input type="date" 
                               wire:model.live="dataInicio"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm md:text-base">
                    </div>
                    <div class="relative">
                        <input type="date" 
                               wire:model.live="dataFim"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm md:text-base">
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados da Busca -->
        @if($search || $status || $clienteId || $dataInicio || $dataFim)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex flex-wrap gap-2">
                        @if($search)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                Busca: "{{ $search }}"
                                <button wire:click="$set('search', '')" 
                                        class="ml-2 hover:text-blue-900 dark:hover:text-blue-100">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if($status)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                Status: {{ ucfirst($status) }}
                                <button wire:click="$set('status', '')" 
                                        class="ml-2 hover:text-green-900 dark:hover:text-green-100">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if($clienteId)
                            @php
                                $clienteSelecionado = $clientes->firstWhere('id_usuario', $clienteId);
                            @endphp
                            @if($clienteSelecionado)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
                                    Cliente: {{ \Illuminate\Support\Str::limit($clienteSelecionado->nome, 10) }}
                                    <button wire:click="$set('clienteId', '')" 
                                            class="ml-2 hover:text-purple-900 dark:hover:text-purple-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        @endif
                    </div>
                    
                    <button wire:click="limparFiltros" 
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:underline self-start sm:self-center">
                        Limpar todos os filtros
                    </button>
                </div>
            </div>
        @endif

        <!-- Ações em lote -->
        @if(count($selectedPedidos) > 0)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ count($selectedPedidos) }} pedido(s) selecionado(s)
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <div class="relative">
                            <select wire:model="statusLote" 
                                    wire:change="atualizarStatusLote($event.target.value)"
                                    class="pl-3 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white appearance-none text-sm">
                                <option value="">Atualizar status...</option>
                                <option value="processando">Em Processamento</option>
                                <option value="enviado">Enviado</option>
                                <option value="entregue">Entregue</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        
                        <button wire:click="exportarPedidos" 
                                class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-sm transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Exportar
                        </button>
                        
                        <button wire:click="$set('selectedPedidos', [])"
                                class="inline-flex items-center px-3 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm transition-colors">
                            Desmarcar
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Tabela de Pedidos -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="w-12 px-4 py-3 text-center">
                                <input type="checkbox" 
                                       wire:model="selectAll"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer whitespace-nowrap"
                                wire:click="sortBy('codigo_pedido')">
                                <div class="flex items-center space-x-1">
                                    <span>Pedido</span>
                                    @if($sortField === 'codigo_pedido')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer whitespace-nowrap"
                                wire:click="sortBy('id_usuario')">
                                <div class="flex items-center space-x-1">
                                    <span>Cliente</span>
                                    @if($sortField === 'id_usuario')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer whitespace-nowrap"
                                wire:click="sortBy('total')">
                                <div class="flex items-center space-x-1">
                                    <span>Total</span>
                                    @if($sortField === 'total')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer whitespace-nowrap"
                                wire:click="sortBy('status')">
                                <div class="flex items-center space-x-1">
                                    <span>Status</span>
                                    @if($sortField === 'status')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer whitespace-nowrap"
                                wire:click="sortBy('created_at')">
                                <div class="flex items-center space-x-1">
                                    <span>Data</span>
                                    @if($sortField === 'created_at')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($pedidos as $pedido)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" 
                                           value="{{ $pedido->id_pedido }}"
                                           wire:model="selectedPedidos"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        <div class="font-medium text-gray-900 dark:text-white text-sm">
                                            {{ $pedido->codigo_pedido }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $pedido->itens->count() }} item(s)
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex-shrink-0">
                                            <img class="h-8 w-8 rounded-full border border-gray-200 dark:border-gray-600" 
                                                 src="{{ $pedido->usuario->avatar_url ? image_url($pedido->usuario->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($pedido->usuario->nome) . '&background=random' }}" 
                                                 alt="{{ $pedido->usuario->nome }}"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($pedido->usuario->nome) }}&background=random'">
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-medium text-gray-900 dark:text-white text-sm truncate max-w-[120px]">
                                                {{ $pedido->usuario->nome }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[120px]">
                                                {{ $pedido->usuario->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ format_kwanza($pedido->total) }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            @if($pedido->pagamento)
                                                {{ ucfirst($pedido->pagamento->metodo) }}
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClasses = [
                                            'entregue' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'pendente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'processando' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'enviado' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                        ];
                                        $statusIcon = [
                                            'entregue' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                            'pendente' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                            'cancelado' => 'M6 18L18 6M6 6l12 12',
                                            'processando' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                                            'enviado' => 'M5 10l7-7m0 0l7 7m-7-7v18',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$pedido->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcon[$pedido->status] ?? 'M5 13l4 4L19 7' }}"/>
                                        </svg>
                                        {{ ucfirst($pedido->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $pedido->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $pedido->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('admin.pedidos.show', $pedido->id_pedido) }}" 
                                           class="p-1.5 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                           title="Visualizar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        
                                        @if($pedido->status !== 'cancelado' && $pedido->status !== 'entregue')
                                            <a href="{{ route('admin.pedidos.edit', $pedido->id_pedido) }}" 
                                               class="p-1.5 text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors"
                                               title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        <button onclick="gerarNotaFiscal('{{ $pedido->id_pedido }}')"
                                                class="p-1.5 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
                                                title="Gerar Nota Fiscal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="max-w-sm mx-auto">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                                            Nenhum pedido encontrado
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            @if($search || $status || $clienteId)
                                                Não foram encontrados pedidos com os filtros aplicados.
                                            @else
                                                Não há pedidos no período selecionado.
                                            @endif
                                        </p>
                                        @if($search || $status || $clienteId)
                                            <button wire:click="limparFiltros" 
                                                    class="mt-3 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
                                                Limpar filtros
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginação -->
        @if($pedidos->hasPages() || $pedidos->total() > 0)
            <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Mostrando 
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $pedidos->firstItem() ?? 0 }}</span>
                        a 
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $pedidos->lastItem() ?? 0 }}</span>
                        de 
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $pedidos->total() }}</span>
                        pedidos
                    </div>
                    
                    @if($pedidos->hasPages())
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                                Por página:
                            </div>
                            <div class="hidden sm:block">
                                {{ $pedidos->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($pedidos->hasPages())
                    <div class="sm:hidden mt-3">
                        {{ $pedidos->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@script
<script>
    function gerarNotaFiscal(pedidoId) {
        // Abrir nota fiscal em nova aba
        window.open(`/admin/pedidos/${pedidoId}/nota-fiscal`, '_blank', 'noopener,noreferrer');
    }
</script>
@endscript
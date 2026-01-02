<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestão de Clientes</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Visualize e gerencie os clientes da sua loja
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full">
                    Modo Visualização
                </span>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Total de Clientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total de Clientes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['totalClientes'] }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Novos este Mês -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Novos este Mês</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['novosClientesMes'] }}
                    </p>
                    @if($estatisticas['novosClientesMes'] > 0)
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                            ↑ {{ number_format(($estatisticas['novosClientesMes'] / $estatisticas['totalClientes']) * 100, 1) }}% do total
                        </p>
                    @endif
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Clientes Ativos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Clientes Ativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['clientesAtivos'] }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Últimos 90 dias
                    </p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Clientes Inativos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Clientes Inativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['clientesInativos'] }}
                    </p>
                    @if($estatisticas['clientesInativos'] > 0)
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                            > 90 dias sem compra
                        </p>
                    @endif
                </div>
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Ticket Médio -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Ticket Médio</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ format_kwanza($estatisticas['ticketMedio']) }}
                    </p>
                    @if($estatisticas['ticketMedio'] > 0)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Por pedido
                        </p>
                    @endif
                </div>
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Ações -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Busca -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar Clientes
                    </div>
                </label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Digite nome, email ou telefone..."
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status
                    </div>
                </label>
                <select wire:model.live="status" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                    <option value="">Todos os Clientes</option>
                    <option value="ativo">Ativos</option>
                    <option value="inativo">Inativos</option>
                    <option value="nunca-comprou">Nunca Comprou</option>
                </select>
            </div>

            <!-- Ordenação Rápida -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                        </svg>
                        Ordenar por
                    </div>
                </label>
                <select wire:model.live="sortField" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                    <option value="nome">Nome (A-Z)</option>
                    <option value="created_at">Data de Cadastro</option>
                    <option value="pedidos_count">Nº de Pedidos</option>
                    <option value="pedidos_sum_total">Valor Total</option>
                </select>
            </div>
        </div>

        <!-- Resultados da Busca -->
        @if($search || $status)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        @if($search)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                Busca: "{{ $search }}"
                                <button wire:click="$set('search', '')" class="ml-2 text-blue-600 hover:text-blue-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if($status)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                {{ match($status) {
                                    'ativo' => 'Ativos',
                                    'inativo' => 'Inativos',
                                    'nunca-comprou' => 'Nunca Comprou',
                                    default => 'Todos'
                                } }}
                                <button wire:click="$set('status', '')" class="ml-2 text-green-600 hover:text-green-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </div>
                    <button wire:click="$set('search', '') & $set('status', '')" 
                            class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                        Limpar filtros
                    </button>
                </div>
            </div>
        @endif

        <!-- Ações em lote -->
        @if(count($selectedClientes) > 0)
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    {{ count($selectedClientes) }} cliente(s) selecionado(s)
                </span>
                
                <div class="flex space-x-2">
                    <button wire:click="enviarEmailLote"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center space-x-2 text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Enviar Email</span>
                    </button>
                    
                    <button wire:click="exportarClientes"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center space-x-2 text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Exportar</span>
                    </button>
                    
                    <button wire:click="$set('selectedClientes', [])"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg text-sm transition-colors">
                        Desmarcar
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Tabela de Clientes -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" 
                                   wire:model="selectAll"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                            wire:click="sortBy('nome')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Cliente
                                @if($sortField === 'nome')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                            wire:click="sortBy('email')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Contato
                                @if($sortField === 'email')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                            wire:click="sortBy('pedidos_count')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Pedidos
                                @if($sortField === 'pedidos_count')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                            wire:click="sortBy('pedidos_sum_total')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Valor Total
                                @if($sortField === 'pedidos_sum_total')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                            wire:click="sortBy('created_at')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Cadastrado em
                                @if($sortField === 'created_at')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Ações
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($clientes as $cliente)
                        @php
                            $statusCliente = 'ativo';
                            if ($cliente->pedidos_count === 0) {
                                $statusCliente = 'nunca-comprou';
                            } elseif ($cliente->pedidos_count > 0 && !$cliente->pedidos()->where('created_at', '>=', \Carbon\Carbon::now()->subDays(90))->exists()) {
                                $statusCliente = 'inativo';
                            }
                            
                            $statusColors = [
                                'ativo' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dark_bg' => 'dark:bg-green-900', 'dark_text' => 'dark:text-green-300'],
                                'inativo' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dark_bg' => 'dark:bg-yellow-900', 'dark_text' => 'dark:text-yellow-300'],
                                'nunca-comprou' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dark_bg' => 'dark:bg-gray-900', 'dark_text' => 'dark:text-gray-300']
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       value="{{ $cliente->id_usuario }}"
                                       wire:model="selectedClientes"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-full border-2 border-gray-200 dark:border-gray-700" 
                                             src="{{ $cliente->avatar_url ? image_url($cliente->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($cliente->nome) . '&color=7F9CF5&background=EBF4FF&bold=true' }}" 
                                             alt="{{ $cliente->nome }}"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($cliente->nome) }}&color=7F9CF5&background=EBF4FF&bold=true'">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $cliente->nome }}
                                            <span class="ml-2 text-xs px-2 py-0.5 rounded-full {{ $statusColors[$statusCliente]['bg'] }} {{ $statusColors[$statusCliente]['text'] }} {{ $statusColors[$statusCliente]['dark_bg'] }} {{ $statusColors[$statusCliente]['dark_text'] }}">
                                                {{ match($statusCliente) {
                                                    'ativo' => 'Ativo',
                                                    'inativo' => 'Inativo',
                                                    'nunca-comprou' => 'Novo',
                                                    default => ''
                                                } }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            ID: {{ $cliente->id_usuario }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-1">
                                    <a href="mailto:{{ $cliente->email }}" 
                                       class="text-sm text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/>
                                        </svg>
                                        {{ $cliente->email }}
                                    </a>
                                    @if($cliente->telefone)
                                        <a href="tel:{{ $cliente->telefone }}" 
                                           class="text-xs text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $cliente->telefone }}
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $cliente->pedidos_count }}
                                        <span class="text-xs font-normal text-gray-500 dark:text-gray-400">pedidos</span>
                                    </div>
                                    @if($cliente->pedidos_count > 0)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $cliente->pedidos_entregues }} entregues
                                            @if($cliente->pedidos_entregues > 0)
                                                <span class="text-green-600 dark:text-green-400 ml-1">
                                                    ({{ number_format(($cliente->pedidos_entregues / $cliente->pedidos_count) * 100, 0) }}%)
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ format_kwanza($cliente->pedidos_sum_total ?? 0) }}
                                    </div>
                                    @if($cliente->pedidos_count > 0)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ format_kwanza(($cliente->pedidos_sum_total ?? 0) / $cliente->pedidos_count) }} médio
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $cliente->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $cliente->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.clientes.show', $cliente->id_usuario) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 rounded-lg transition-colors"
                                       title="Visualizar detalhes do cliente">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span class="text-sm">Ver</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="max-w-sm mx-auto">
                                    <svg class="w-20 h-20 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75l-4.5-2.48m0 0l-4.5 2.48m4.5-2.48v7.5"/>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                                        Nenhum cliente encontrado
                                    </h3>
                                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                                        @if($search || $status)
                                            Não foram encontrados clientes com os filtros aplicados.
                                            <button wire:click="$set('search', '') & $set('status', '')" 
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
                                                Limpar filtros
                                            </button>
                                        @else
                                            Não há clientes cadastrados no sistema.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação e Contador -->
        @if($clientes->hasPages() || $clientes->total() > 0)
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Mostrando 
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $clientes->firstItem() ?? 0 }}</span>
                        a 
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $clientes->lastItem() ?? 0 }}</span>
                        de 
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $clientes->total() }}</span>
                        clientes
                    </div>
                    
                    @if($clientes->hasPages())
                        <div class="flex items-center space-x-2">
                            <select wire:model.live="perPage" 
                                    class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="10">10 por página</option>
                                <option value="25">25 por página</option>
                                <option value="50">50 por página</option>
                                <option value="100">100 por página</option>
                            </select>
                            
                            <div class="hidden sm:block">
                                {{ $clientes->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($clientes->hasPages())
                    <div class="sm:hidden mt-3">
                        {{ $clientes->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
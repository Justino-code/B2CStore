<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header Admin -->
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between h-auto sm:h-16 py-3 sm:py-0">
                <div class="flex items-center mb-3 sm:mb-0">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Detalhes do Cliente</h1>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('admin.clientes.index') }}" 
                       class="inline-flex items-center text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar para Clientes
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded">
            {{ session('success') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded">
            {{ session('error') }}
        </div>
        @endif
        @if(session()->has('info'))
        <div class="mb-4 p-4 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-300 rounded">
            {{ session('info') }}
        </div>
        @endif

        <div class="px-4 py-6 sm:px-0">
            <!-- Cabeçalho do Cliente -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-4 lg:mb-0">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ strtoupper(substr($cliente->nome ?? $cliente->email, 0, 1)) }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">{{ $cliente->nome ?? 'Cliente sem nome' }}</h2>
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $estatisticas['statusCliente'] == 'ativo' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 
                                       ($estatisticas['statusCliente'] == 'inativo' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300' : 
                                       'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300') }}">
                                    {{ ucfirst($estatisticas['statusCliente']) }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-300 text-sm truncate">{{ $cliente->email }}</span>
                                @if($estatisticas['emailVerificado'])
                                <span class="text-green-600 dark:text-green-400 text-xs sm:text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Verificado
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botões de Ação - Layout Responsivo -->
                    <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
                        <button wire:click="enviarEmail" 
                                class="inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-md transition text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email
                        </button>
                        <button wire:click="toggleStatus" 
                                class="inline-flex items-center justify-center px-3 py-2 {{ $estatisticas['statusCliente'] == 'ativo' ? 'bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600' : 'bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600' }} text-white rounded-md transition text-sm font-medium">
                            @if($estatisticas['statusCliente'] == 'ativo')
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Desativar
                            @else
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ativar
                            @endif
                        </button>
                        <button wire:click="confirmDelete" 
                                class="inline-flex items-center justify-center px-3 py-2 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-md transition text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Deletar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 hover:translate-y-[-2px] transition-transform">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">Total de Pedidos</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">{{ $estatisticas['totalPedidos'] }}</p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-2 sm:p-3 rounded-lg shrink-0 ml-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 hover:translate-y-[-2px] transition-transform">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">Valor Total Gasto</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">
                                {{ format_kwanza($estatisticas['valorTotalGasto']) }}
                            </p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-2 sm:p-3 rounded-lg shrink-0 ml-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 hover:translate-y-[-2px] transition-transform">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">Ticket Médio</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">
                                {{ format_kwanza($estatisticas['ticketMedio']) }}
                            </p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-2 sm:p-3 rounded-lg shrink-0 ml-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 hover:translate-y-[-2px] transition-transform">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">Cliente desde</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate" title="{{ $cliente->created_at->format('d/m/Y H:i') }}">
                                {{ $estatisticas['tempoComoCliente'] }}
                            </p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-2 sm:p-3 rounded-lg shrink-0 ml-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abas de Navegação -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex overflow-x-auto -mb-px">
                        <button wire:click="$set('abaAtiva', 'pedidos')"
                                class="{{ $abaAtiva == 'pedidos' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }} py-3 sm:py-4 px-4 sm:px-6 text-sm font-medium border-b-2 border-transparent whitespace-nowrap shrink-0">
                            <span class="hidden sm:inline">Pedidos</span>
                            <span class="sm:hidden">Pedidos</span>
                            <span class="ml-1 sm:ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                {{ $estatisticas['totalPedidos'] }}
                            </span>
                        </button>
                        <button wire:click="$set('abaAtiva', 'favoritos')"
                                class="{{ $abaAtiva == 'favoritos' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }} py-3 sm:py-4 px-4 sm:px-6 text-sm font-medium border-b-2 border-transparent whitespace-nowrap shrink-0">
                            <span class="hidden sm:inline">Favoritos</span>
                            <span class="sm:hidden">Favs</span>
                            <span class="ml-1 sm:ml-2 px-2 py-1 text-xs rounded-full bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-300">
                                {{ $estatisticas['totalFavoritos'] }}
                            </span>
                        </button>
                        <button wire:click="$set('abaAtiva', 'informacoes')"
                                class="{{ $abaAtiva == 'informacoes' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }} py-3 sm:py-4 px-4 sm:px-6 text-sm font-medium border-b-2 border-transparent whitespace-nowrap shrink-0">
                            <span class="hidden sm:inline">Informações</span>
                            <span class="sm:hidden">Info</span>
                        </button>
                    </nav>
                </div>

                <div class="p-4 sm:p-6">
                    <!-- Conteúdo da Aba Pedidos -->
                    @if($abaAtiva == 'pedidos')
                        <div class="mb-6">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Histórico de Pedidos</h3>
                                <select wire:model.live="periodoPedidos" 
                                        class="block w-full sm:w-48 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 dark:bg-gray-700 dark:text-white text-sm">
                                    <option value="todos">Todos os pedidos</option>
                                    <option value="30dias">Últimos 30 dias</option>
                                    <option value="90dias">Últimos 90 dias</option>
                                    <option value="ano">Último ano</option>
                                </select>
                            </div>
                        </div>

                        @if($pedidos->count() > 0)
                            <div class="overflow-x-auto -mx-4 sm:mx-0">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Pedido
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Data
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Valor
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($pedidos as $pedido)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">#{{ $pedido->id }}</div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-300">{{ $pedido->created_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $pedido->status == 'entregue' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 
                                                       ($pedido->status == 'cancelado' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300' : 
                                                       'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300') }}">
                                                    {{ ucfirst($pedido->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                                {{ format_kwanza($pedido->total) }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.pedidos.show', $pedido->id_pedido) }}" 
                                                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $pedidos->links() }}
                            </div>
                        @else
                            <div class="text-center py-8 sm:py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhum pedido encontrado</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $cliente->nome ?? 'Este cliente' }} ainda não realizou nenhum pedido.
                                </p>
                            </div>
                        @endif

                    <!-- Conteúdo da Aba Favoritos -->
                    @elseif($abaAtiva == 'favoritos')
                        @if($favoritos->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                                @foreach($favoritos as $favorito)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md dark:hover:shadow-gray-800 transition">
                                    @if($favorito->produto->imagens && $favorito->produto->imagens->first())
                                    <img src="{{ image_url($favorito->produto->imagens->first()->url_imagem) }}" 
                                         alt="{{ $favorito->produto->nome }}"
                                         class="w-full h-40 sm:h-48 object-cover">
                                    @else
                                    <div class="w-full h-40 sm:h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="p-3 sm:p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ $favorito->produto->nome }}</h4>
                                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $favorito->produto->descricao }}</p>
                                        <div class="mt-3 sm:mt-4 flex justify-between items-center">
                                            <span class="text-base sm:text-lg font-bold text-blue-600 dark:text-blue-400">
                                                {{ format_kwanza($favorito->produto->preco) }}
                                            </span>
                                            <a href="{{ route('admin.produtos.show', $favorito->produto->id_produto) }}" 
                                               class="inline-flex items-center text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                Ver
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                {{ $favoritos->links() }}
                            </div>
                        @else
                            <div class="text-center py-8 sm:py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhum favorito</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $cliente->nome ?? 'Este cliente' }} ainda não favoritou nenhum produto.
                                </p>
                            </div>
                        @endif

                    <!-- Conteúdo da Aba Informações -->
                    @elseif($abaAtiva == 'informacoes')
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informações do Cliente</h3>
                                <dl class="space-y-3 sm:space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->nome ?? 'Não informado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white break-all">{{ $cliente->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Telefone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->telefone ?? 'Não informado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Cadastro</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->created_at->format('d/m/Y H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Atualização</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->updated_at->format('d/m/Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Atividade e Estatísticas</h3>
                                <dl class="space-y-3 sm:space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status da Conta</dt>
                                        <dd class="mt-1">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $estatisticas['statusCliente'] == 'ativo' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 
                                                   ($estatisticas['statusCliente'] == 'inativo' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300' : 
                                                   'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300') }}">
                                                {{ ucfirst($estatisticas['statusCliente']) }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Verificado</dt>
                                        <dd class="mt-1">
                                            @if($estatisticas['emailVerificado'])
                                                <span class="inline-flex items-center text-green-600 dark:text-green-400 font-medium text-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    Sim
                                                    @if(isset($cliente->email_verificado_em))
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                                            em {{ $cliente->email_verificado_em->format('d/m/Y') }}
                                                        </span>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center text-red-600 dark:text-red-400 font-medium text-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                    Não
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Último Pedido</dt>
                                        <dd class="mt-1">
                                            @if($estatisticas['ultimoPedido'])
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $estatisticas['ultimoPedido']->created_at->format('d/m/Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    (há {{ $estatisticas['diasDesdeUltimoPedido'] }} dias)
                                                </div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">Nenhum pedido realizado</span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pedidos Entregues</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white">{{ $estatisticas['pedidosEntregues'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Favoritos</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white">{{ $estatisticas['totalFavoritos'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
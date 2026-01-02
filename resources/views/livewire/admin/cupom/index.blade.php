<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Cupons de Desconto</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Gerencie os cupons de desconto da sua loja</p>
            </div>
            <a href="{{ route('admin.cupons.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Novo Cupom</span>
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total de Cupons -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total de Cupons</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['totalCupons'] }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Cupons Ativos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Cupons Ativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['cuponsAtivos'] }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total de Usos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total de Usos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['totalUsos'] }}
                    </p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Próximo a Expirar -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Expirando em 7 dias</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $estatisticas['cuponsProximoExpirar'] }}
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Tipo de Desconto -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                <select wire:model.live="tipo" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="todos">Todos os tipos</option>
                    <option value="percentual">Percentual</option>
                    <option value="fixo">Valor Fixo</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select wire:model.live="status" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="ativos">Ativos</option>
                    <option value="expirados">Expirados</option>
                    <option value="inativos">Inativos</option>
                    <option value="todos">Todos</option>
                </select>
            </div>

            <!-- Busca -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar por código..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <!-- Ações em lote -->
        @if(count($selectedItems) > 0)
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ count($selectedItems) }} cupom(ns) selecionado(s)
                </span>
                
                <div class="flex space-x-2">
                    <button wire:click="$dispatch('confirm', {
                        title: 'Deletar Cupons',
                        text: 'Tem certeza que deseja deletar ' + {{ count($selectedItems) }} + ' cupom(ns) selecionados? Esta ação não pode ser desfeita.',
                        icon: 'warning',
                        confirmButtonText: 'Sim, deletar',
                        cancelButtonText: 'Cancelar',
                        method: 'deletarSelecionadosConfirmado',
                        params: []
                    })"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>Deletar Selecionados</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Tabela de Cupons -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" 
                                   wire:model="selectAll"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('codigo')">
                            <div class="flex items-center">
                                Código
                                @if($sortField === 'codigo')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('tipo_desconto')">
                            <div class="flex items-center">
                                Tipo
                                @if($sortField === 'tipo_desconto')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('valor_desconto')">
                            <div class="flex items-center">
                                Desconto
                                @if($sortField === 'valor_desconto')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('usos_atual')">
                            <div class="flex items-center">
                                Usos
                                @if($sortField === 'usos_atual')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('validade_fim')">
                            <div class="flex items-center">
                                Validade
                                @if($sortField === 'validade_fim')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('ativo')">
                            <div class="flex items-center">
                                Status
                                @if($sortField === 'ativo')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($cupons as $cupom)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       value="{{ $cupom->id_cupom }}"
                                       wire:model="selectedItems"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $cupom->codigo }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $cupom->tipo_desconto == 'percentual' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }}">
                                    {{ $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Valor Fixo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    @if($cupom->tipo_desconto == 'percentual')
                                        {{ number_format($cupom->valor_desconto, 2) }}%
                                    @else
                                        {{ format_kwanza($cupom->valor_desconto) }}
                                    @endif
                                </div>
                                @if($cupom->valor_minimo > 0)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Mín: {{ format_kwanza($cupom->valor_minimo) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $cupom->usos_atual }} 
                                    @if($cupom->usos_maximos)
                                        / {{ $cupom->usos_maximos }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($cupom->usos_maximos)
                                        {{ number_format(($cupom->usos_atual / $cupom->usos_maximos) * 100, 0) }}% usado
                                    @else
                                        Ilimitado
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($cupom->validade_fim)
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($cupom->validade_fim)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs {{ \Carbon\Carbon::parse($cupom->validade_fim)->isPast() ? 'text-red-500 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ \Carbon\Carbon::parse($cupom->validade_fim)->isPast() ? 'Expirado' : 'Expira em ' . \Carbon\Carbon::parse($cupom->validade_fim)->diffForHumans() }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Sem validade</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus('{{ $cupom->id_cupom }}')"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $cupom->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                    {{ $cupom->ativo ? 'Ativo' : 'Inativo' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.cupons.show', $cupom->id_cupom) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 p-1"
                                       title="Ver detalhes">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('admin.cupons.edit', $cupom->id_cupom) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 p-1"
                                       title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <button wire:click="duplicarCupom('{{ $cupom->id_cupom }}')"
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 p-1"
                                            title="Duplicar cupom">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="$dispatch('confirm', {
                                        title: 'Deletar Cupom',
                                        text: 'Tem certeza que deseja deletar o cupom &quot;{{ addslashes($cupom->codigo) }}&quot;? Esta ação não pode ser desfeita.',
                                        icon: 'warning',
                                        confirmButtonText: 'Sim, deletar',
                                        cancelButtonText: 'Cancelar',
                                        method: 'deleteCupomConfirmed',
                                        params: ['{{ $cupom->id_cupom }}']
                                    })"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1"
                                            title="Deletar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Nenhum cupom encontrado</h3>
                                <p class="mt-1 text-gray-500 dark:text-gray-400">
                                    {{ $search ? 'Tente ajustar sua busca.' : 'Crie seu primeiro cupom de desconto.' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($cupons->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $cupons->links() }}
            </div>
        @endif
    </div>
</div>
<div class="container mx-auto px-4 py-8">
    <!-- Título e Estatísticas -->
    <div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- Total de Cupons -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $estatisticas['total'] }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cupons Usados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Usados por Você</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $estatisticas['usados'] }}</p>
                    </div>
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cupons Expirados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Expirados</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $estatisticas['expirados'] }}</p>
                    </div>
                    <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Próximos da Expiração -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Expirando em 7 dias</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $estatisticas['proximos_expiracao'] }}</p>
                    </div>
                    <div class="p-2 bg-amber-100 dark:bg-amber-900 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filtrar Cupons</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Tipo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipo
                    </label>
                    <select 
                        wire:model.live="tipoFiltro"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="ativos">Cupons Ativos</option>
                        <option value="expirados">Cupons Expirados</option>
                        <option value="usados">Cupons Usados por Você</option>
                    </select>
                </div>

                <!-- Busca -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Buscar por Código
                    </label>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="busca"
                        placeholder="Digite o código do cupom..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>

                <!-- Ordenação -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Ordenar por
                    </label>
                    <select 
                        wire:model.live="ordenarPor"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="validade_fim">Data de Validade</option>
                        <option value="valor_desconto">Valor do Desconto</option>
                        <option value="codigo">Código</option>
                        <option value="created_at">Data de Criação</option>
                    </select>
                </div>
            </div>

            <!-- Itens por página -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Itens por página:</span>
                    <select 
                        wire:model.live="porPagina"
                        class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    >
                        <option value="6">6</option>
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="48">48</option>
                    </select>
                </div>

                <div class="flex items-center space-x-3">
                    <button 
                        wire:click="limparFiltros"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                    >
                        Limpar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Cupons -->
    @if($cupons->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cupons as $cupom)
                @php
                    $valido = $this->cupomEstaValido($cupom);
                    $usadoPeloCliente = $this->cupomFoiUsadoPeloCliente($cupom->id_cupom);
                    $proximoExpiracao = $this->cupomProximoExpiracao($cupom);
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Badge de Status -->
                    <div class="absolute top-3 left-3 z-10">
                        @if(!$valido)
                            <span class="px-3 py-1 text-xs font-bold bg-red-600 text-white rounded-full">
                                Expirado
                            </span>
                        @elseif($proximoExpiracao)
                            <span class="px-3 py-1 text-xs font-bold bg-amber-500 text-white rounded-full">
                                Expira em {{ now()->diffInDays($cupom->validade_fim) }} dias
                            </span>
                        @elseif($usadoPeloCliente)
                            <span class="px-3 py-1 text-xs font-bold bg-green-600 text-white rounded-full">
                                Usado por Você
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold bg-blue-600 text-white rounded-full">
                                Disponível
                            </span>
                        @endif
                    </div>

                    <!-- Cabeçalho do Cupom -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <span class="text-4xl font-bold {{ $valido ? 'text-green-600 dark:text-green-400' : 'text-gray-400 dark:text-gray-500' }}">
                                @if($cupom->tipo_desconto === 'percentual')
                                    {{ $cupom->valor_desconto }}%
                                @else
                                    {{ format_kwanza($cupom->valor_desconto) }}
                                @endif
                            </span>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                @if($cupom->tipo_desconto === 'percentual')
                                    de desconto
                                @else
                                    em desconto
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Corpo do Cupom -->
                    <div class="p-6">
                        <!-- Código -->
                        <div class="text-center mb-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Código do Cupom</p>
                            <div class="flex items-center justify-center">
                                <span class="text-xl font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                                    {{ $cupom->codigo }}
                                </span>
                                <button 
                                    wire:click="copiarCodigo('{{ $cupom->codigo }}')"
                                    class="ml-2 p-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg"
                                    title="Copiar código"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Detalhes -->
                        <div class="space-y-3 text-sm">
                            <!-- Validade -->
                            @if($cupom->validade_fim)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-600 dark:text-gray-400">Válido até:</span>
                                    <span class="ml-auto font-medium {{ $proximoExpiracao ? 'text-amber-600 dark:text-amber-400' : 'text-gray-900 dark:text-white' }}">
                                        {{ $cupom->validade_fim->format('d/m/Y') }}
                                    </span>
                                </div>
                            @endif

                            <!-- Valor Mínimo -->
                            @if($cupom->valor_minimo)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2-.9 2-2s-.89-2-2-2-2 .9-2 2 .89 2 2 2z" />
                                    </svg>
                                    <span class="text-gray-600 dark:text-gray-400">Valor mínimo:</span>
                                    <span class="ml-auto font-medium text-gray-900 dark:text-white">
                                        {{ format_kwanza($cupom->valor_minimo) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Usos -->
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Usos:</span>
                                <span class="ml-auto font-medium text-gray-900 dark:text-white">
                                    {{ $cupom->usos_atual }} / {{ $cupom->usos_maximos ?? '∞' }}
                                </span>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                <span class="ml-auto font-medium {{ $valido ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $valido ? 'Válido' : 'Inválido' }}
                                </span>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="mt-6 flex space-x-2">
                            <button 
                                wire:click="verDetalhes({{ $cupom->id_cupom }})"
                                class="flex-1 px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 transition-colors"
                            >
                                Detalhes
                            </button>
                            
                            @if($valido && !$usadoPeloCliente)
                                <a 
                                    href="{{ route('home') }}"
                                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center"
                                >
                                    Usar Agora
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="mt-8">
            {{ $cupons->links() }}
        </div>
    @else
        <!-- Sem Cupons -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-12 text-center">
            <div class="w-24 h-24 mx-auto text-gray-400 mb-6">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                @if($tipoFiltro === 'ativos')
                    Nenhum cupom ativo disponível
                @elseif($tipoFiltro === 'expirados')
                    Nenhum cupom expirado encontrado
                @elseif($tipoFiltro === 'usados')
                    Você ainda não usou nenhum cupom
                @else
                    Nenhum cupom encontrado
                @endif
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                @if($tipoFiltro === 'ativos')
                    No momento não há cupons de desconto disponíveis. Fique atento às nossas promoções!
                @elseif($tipoFiltro === 'expirados')
                    Não encontramos cupons expirados nos seus registros.
                @elseif($tipoFiltro === 'usados')
                    Aproveite nossos cupons de desconto em sua próxima compra!
                @else
                    Tente ajustar os filtros para encontrar cupons.
                @endif
            </p>
            <div class="space-x-4">
                @if($tipoFiltro !== 'ativos')
                    <button 
                        wire:click="$set('tipoFiltro', 'ativos')"
                        class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700"
                    >
                        Ver Cupons Ativos
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

<!-- Modal Detalhes do Cupom -->
@if($mostrarDetalhes && $cupomSelecionado)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Cabeçalho -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Detalhes do Cupom
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $cupomSelecionado->codigo }}
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
                <!-- Código e Valor -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-500 to-purple-600">
                    <div class="text-center text-white">
                        <div class="text-5xl font-bold mb-2">
                            @if($cupomSelecionado->tipo_desconto === 'percentual')
                                {{ $cupomSelecionado->valor_desconto }}% OFF
                            @else
                                {{ format_kwanza($cupomSelecionado->valor_desconto) }} OFF
                            @endif
                        </div>
                        <div class="text-xl font-medium bg-white bg-opacity-20 inline-block px-6 py-2 rounded-full">
                            {{ $cupomSelecionado->codigo }}
                        </div>
                        <button 
                            wire:click="copiarCodigo('{{ $cupomSelecionado->codigo }}')"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-gray-100"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Copiar Código
                        </button>
                    </div>
                </div>

                <!-- Detalhes -->
                <div class="p-6 space-y-6">
                    <!-- Status -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informações do Cupom</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tipo de Desconto</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $cupomSelecionado->tipo_desconto === 'percentual' ? 'Percentual' : 'Valor Fixo' }}
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Valor Mínimo</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    @if($cupomSelecionado->valor_minimo)
                                        {{ format_kwanza($cupomSelecionado->valor_minimo) }}
                                    @else
                                        Sem valor mínimo
                                    @endif
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Usos</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $cupomSelecionado->usos_atual }} de {{ $cupomSelecionado->usos_maximos ?? '∞' }} usos
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                <p class="font-medium {{ $this->cupomEstaValido($cupomSelecionado) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $this->cupomEstaValido($cupomSelecionado) ? 'Válido' : 'Inválido' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Validade -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Validade</h4>
                        <div class="space-y-3">
                            @if($cupomSelecionado->validade_inicio)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-400">Início da Validade</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ $cupomSelecionado->validade_inicio->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            @endif
                            
                            @if($cupomSelecionado->validade_fim)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-400">Fim da Validade</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ $cupomSelecionado->validade_fim->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                
                                @php
                                    $diasRestantes = now()->diffInDays($cupomSelecionado->validade_fim, false);
                                @endphp
                                
                                @if($diasRestantes > 0)
                                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-blue-700 dark:text-blue-300">
                                                @if($diasRestantes == 1)
                                                    Este cupom expira amanhã!
                                                @elseif($diasRestantes <= 7)
                                                    Este cupom expira em {{ $diasRestantes }} dias
                                                @else
                                                    Este cupom expira em {{ $diasRestantes }} dias
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Uso pelo Cliente -->
                    @if($cupomSelecionado->usado_pelo_cliente)
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-green-700 dark:text-green-300 font-medium">
                                    Você já utilizou este cupom em uma compra anterior
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Como Usar -->
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                        <h5 class="font-medium text-blue-800 dark:text-blue-300 mb-2">Como usar este cupom:</h5>
                        <ol class="text-blue-700 dark:text-blue-400 text-sm space-y-2">
                            <li class="flex items-start">
                                <span class="font-bold mr-2">1.</span>
                                Adicione produtos ao carrinho
                            </li>
                            <li class="flex items-start">
                                <span class="font-bold mr-2">2.</span>
                                Vá para o carrinho de compras
                            </li>
                            <li class="flex items-start">
                                <span class="font-bold mr-2">3.</span>
                                Insira o código <span class="font-bold ml-1">{{ $cupomSelecionado->codigo }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="font-bold mr-2">4.</span>
                                Clique em "Aplicar"
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Rodapé do Modal -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    @if($this->cupomEstaValido($cupomSelecionado) && !$cupomSelecionado->usado_pelo_cliente)
                        <a 
                            href="{{ route('home') }}"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center font-medium"
                        >
                            Usar Cupom na Loja
                        </a>
                    @endif
                    <button 
                        wire:click="fecharDetalhes"
                        class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal Código Copiado -->
@if($mostrarModalCopiar)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-2">
                    Código Copiado!
                </h3>
                
                <p class="text-gray-600 dark:text-gray-400 text-center">
                    O código do cupom foi copiado para a área de transferência.
                </p>
                
                <div class="mt-6 text-center">
                    <button 
                        wire:click="$set('mostrarModalCopiar', false)"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Copiar para clipboard
        Livewire.on('copiar-para-clipboard', ({ texto }) => {
            navigator.clipboard.writeText(texto).then(() => {
                console.log('Código copiado: ' + texto);
            }).catch(err => {
                console.error('Erro ao copiar: ', err);
                // Fallback para método antigo
                const textArea = document.createElement('textarea');
                textArea.value = texto;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
            });
        });
    });
</script>
@endpush
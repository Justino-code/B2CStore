{{-- Barra de controle --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        {{-- Contador e ordenação --}}
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Mostrando <span class="font-semibold">{{ $produtos->firstItem() ?? 0 }}-{{ $produtos->lastItem() ?? 0 }}</span> de {{ $produtos->total() }} produtos
            </div>

            {{-- Ordenação --}}
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-sort"></i>
                    <span>
                        @switch($ordenarPor)
                            @case('mais_recentes') Mais recentes @break
                            @case('preco_menor') Preço: menor primeiro @break
                            @case('preco_maior') Preço: maior primeiro @break
                            @case('nome_az') Nome: A-Z @break
                            @case('nome_za') Nome: Z-A @break
                            @case('mais_vendidos') Mais vendidos @break
                            @case('mais_avaliados') Melhor avaliados @break
                        @endswitch
                    </span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>

                <div x-show="open"
                     x-transition
                     class="absolute z-10 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700"
                     style="display: none;">
                    <div class="py-1">
                        <button wire:click="$set('ordenarPor', 'mais_recentes')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'mais_recentes' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Mais recentes</span>
                            @if($ordenarPor === 'mais_recentes')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                        <button wire:click="$set('ordenarPor', 'preco_menor')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'preco_menor' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Preço: menor primeiro</span>
                            @if($ordenarPor === 'preco_menor')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                        <button wire:click="$set('ordenarPor', 'preco_maior')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'preco_maior' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Preço: maior primeiro</span>
                            @if($ordenarPor === 'preco_maior')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                        <button wire:click="$set('ordenarPor', 'nome_az')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'nome_az' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Nome: A-Z</span>
                            @if($ordenarPor === 'nome_az')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                        <button wire:click="$set('ordenarPor', 'nome_za')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'nome_za' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Nome: Z-A</span>
                            @if($ordenarPor === 'nome_za')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                        <button wire:click="$set('ordenarPor', 'mais_vendidos')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'mais_vendidos' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Mais vendidos</span>
                            @if($ordenarPor === 'mais_vendidos')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                        <button wire:click="$set('ordenarPor', 'mais_avaliados')"
                                wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'mais_avaliados' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                            <span>Melhor avaliados</span>
                            @if($ordenarPor === 'mais_avaliados')
                                <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modo de visualização e itens por página --}}
        <div class="flex items-center gap-4">
            {{-- Itens por página --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Mostrar:</span>
                <select wire:model.live="itensPorPagina"
                        wire:loading.attr="disabled"
                        class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>
            </div>

            {{-- Modo de visualização --}}
            <div class="flex border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <button wire:click="$set('viewMode', 'grid')"
                        wire:loading.attr="disabled"
                        class="px-3 py-2 transition-all duration-200 flex items-center gap-2 {{ $viewMode === 'grid' ? 'bg-blue-600 text-white shadow-inner' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600' }}">
                    <i class="fas fa-th-large"></i>
                    <span class="text-xs font-medium">Grid</span>
                </button>
                <button wire:click="$set('viewMode', 'list')"
                        wire:loading.attr="disabled"
                        class="px-3 py-2 transition-all duration-200 flex items-center gap-2 {{ $viewMode === 'list' ? 'bg-blue-600 text-white shadow-inner' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600' }}">
                    <i class="fas fa-list"></i>
                    <span class="text-xs font-medium">Lista</span>
                </button>
            </div>

            {{-- Botão filtro mobile --}}
            <button @click="$dispatch('open-filters')"
                    class="lg:hidden px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                <i class="fas fa-filter"></i>
                <span class="text-sm font-medium">Filtros</span>
            </button>
        </div>
    </div>

    {{-- Loading indicator --}}
    <div wire:loading wire:target="ordenarPor,viewMode,itensPorPagina" 
         class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center">
        <div class="flex flex-col items-center gap-2">
            <div class="w-8 h-8 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Atualizando...</span>
        </div>
    </div>
</div>
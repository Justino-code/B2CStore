{{-- Sidebar de Filtros (Desktop) --}}
<aside class="lg:w-1/4 h-full" style="width:100%;">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-6 h-full flex flex-col">

        {{-- Header filtros --}}
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                    <i class="fas fa-sliders-h text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Filtros
                </h2>
            </div>
            @if($search || $categoriaId || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                <button wire:click="limparFiltros"
                        class="group relative px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-200 hover:scale-105 active:scale-95">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-redo text-xs opacity-70 group-hover:rotate-180 transition-transform duration-300"></i>
                        Limpar tudo
                    </span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </button>
            @endif
        </div>

        {{-- Conteúdo dos filtros --}}
        <div class="flex-1 overflow-y-auto pr-2 -mr-2 custom-scrollbar">
            {{-- Barra de busca --}}
            <div class="mb-8">
                <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 ml-1">
                    <i class="fas fa-search mr-2 text-gray-400"></i>
                    Buscar produto
                </label>
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-600/10 rounded-xl blur opacity-0 group-focus-within:opacity-100 transition-opacity duration-300"></div>
                    <input type="text"
                           id="search"
                           wire:model.live.debounce.500ms="search"
                           placeholder="Digite nome ou descrição..."
                           class="relative w-full pl-12 pr-10 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-300 placeholder-gray-400 dark:placeholder-gray-500">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-300"></i>
                    @if($search)
                        <button wire:click="$set('search', '')"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all duration-200">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Filtro por preço --}}
            <div x-data="{ open: true }" class="mb-8 bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-800/50 dark:to-gray-900/50 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-600">
                <button @click="open = !open" class="w-full px-5 py-4 flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100/80 dark:from-gray-800 dark:to-gray-900 hover:from-gray-100 dark:hover:from-gray-800/80 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-sm">
                            <i class="fas fa-tag text-white text-xs"></i>
                        </div>
                        <span class="font-semibold text-gray-800 dark:text-gray-200 tracking-wide">Faixa de Preço</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transform transition-transform duration-300 group-hover:scale-125" 
                       :class="{ 'rotate-180': open }"></i>
                </button>
                
                <div x-show="open" x-collapse class="px-5 py-4 space-y-6">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mínimo</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ format_kwanza($precoMin) }}</span>
                        </div>
                        <div class="h-px w-6 bg-gray-300 dark:bg-gray-600 mx-2"></div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Máximo</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ format_kwanza($precoMax) }}</span>
                        </div>
                    </div>

                    <div x-data="{ min: $wire.$entangle('precoMin', true), max: $wire.$entangle('precoMax', true) }" class="space-y-6">
                        {{-- Range Slider --}}
                        <div class="relative pt-1">
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-3 px-1">
                                <span>0</span>
                                <span>{{ format_kwanza($precoMaximoDisponivel / 2) }}</span>
                                <span>{{ format_kwanza($precoMaximoDisponivel) }}</span>
                            </div>
                            
                            <div class="relative h-3">
                                {{-- Track --}}
                                <div class="absolute top-0 left-0 right-0 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700"></div>
                                </div>
                                
                                {{-- Active Range --}}
                                <div class="absolute top-0 h-3 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-full"
                                     :style="`left: ${(min / {{ $precoMaximoDisponivel }}) * 100}%; right: ${100 - (max / {{ $precoMaximoDisponivel }}) * 100}%`">
                                </div>
                            </div>
                        </div>
                        
                        {{-- Inputs --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2 ml-1">
                                    <i class="fas fa-arrow-down text-xs mr-1 text-gray-400"></i>
                                    Mínimo
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">kz</span>
                                    <input type="number"
                                           wire:model.live.debounce.500ms="precoMin"
                                           min="0"
                                           max="{{ $precoMaximoDisponivel }}"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300">
                                </div>
                            </div>
                            <div class="relative">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2 ml-1">
                                    <i class="fas fa-arrow-up text-xs mr-1 text-gray-400"></i>
                                    Máximo
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">kz</span>
                                    <input type="number"
                                           wire:model.live.debounce.500ms="precoMax"
                                           min="0"
                                           max="{{ $precoMaximoDisponivel }}"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtro por categoria --}}
            @if($categorias->count() > 0)
            <div x-data="{ open: true }" class="mb-8 bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-800/50 dark:to-gray-900/50 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-600">
                <button @click="open = !open" class="w-full px-5 py-4 flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100/80 dark:from-gray-800 dark:to-gray-900 hover:from-gray-100 dark:hover:from-gray-800/80 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-sm">
                            <i class="fas fa-tags text-white text-xs"></i>
                        </div>
                        <span class="font-semibold text-gray-800 dark:text-gray-200 tracking-wide">
                            Categorias
                            <span class="ml-2 text-sm font-normal text-gray-500 dark:text-gray-400">
                                ({{ $categorias->count() }})
                            </span>
                        </span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transform transition-transform duration-300 group-hover:scale-125" 
                       :class="{ 'rotate-180': open }"></i>
                </button>
                
                <div x-show="open" x-collapse class="max-h-64 overflow-y-auto custom-scrollbar">
                    <div class="p-4 space-y-1">
                        @foreach($categorias as $categoria)
                        <label class="flex items-center cursor-pointer group p-3 rounded-xl hover:bg-white dark:hover:bg-gray-800/80 hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200 dark:hover:border-gray-700">
                            <div class="relative">
                                <input type="radio"
                                       name="categoria"
                                       wire:model.live="categoriaId"
                                       value="{{ $categoria->id_categoria }}"
                                       class="h-5 w-5 text-blue-600 focus:ring-3 focus:ring-blue-500/40 border-2 border-gray-300 dark:border-gray-600 rounded-lg checked:border-blue-500 transition-all duration-200">
                                <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500/30 rounded-lg transition-colors duration-200"></div>
                            </div>
                            <span class="ml-4 flex-1 text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-200">
                                {{ $categoria->nome }}
                            </span>
                            <span class="text-xs font-medium px-2.5 py-1.5 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-600 dark:text-gray-400 group-hover:from-blue-50 group-hover:to-blue-100 dark:group-hover:from-blue-900/30 dark:group-hover:to-blue-900/20 transition-all duration-300">
                                {{ $categoria->produtos_count }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Filtro por marca --}}
            @if($marcas && $marcas->count() > 0)
            <div x-data="{ open: false }" class="mb-8 bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-800/50 dark:to-gray-900/50 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-600">
                <button @click="open = !open" class="w-full px-5 py-4 flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100/80 dark:from-gray-800 dark:to-gray-900 hover:from-gray-100 dark:hover:from-gray-800/80 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-sm">
                            <i class="fas fa-copyright text-white text-xs"></i>
                        </div>
                        <span class="font-semibold text-gray-800 dark:text-gray-200 tracking-wide">
                            Marcas
                            <span class="ml-2 text-sm font-normal text-gray-500 dark:text-gray-400">
                                ({{ $marcas->count() }})
                            </span>
                        </span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transform transition-transform duration-300 group-hover:scale-125" 
                       :class="{ 'rotate-180': open }"></i>
                </button>
                
                <div x-show="open" x-collapse class="max-h-64 overflow-y-auto custom-scrollbar">
                    <div class="p-4 space-y-1">
                        @foreach($marcas as $marca)
                        <label class="flex items-center cursor-pointer group p-3 rounded-xl hover:bg-white dark:hover:bg-gray-800/80 hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200 dark:hover:border-gray-700">
                            <div class="relative">
                                <input type="radio"
                                       name="marca"
                                       wire:model.live="marcaId"
                                       value="{{ $marca->id_marca }}"
                                       class="h-5 w-5 text-blue-600 focus:ring-3 focus:ring-blue-500/40 border-2 border-gray-300 dark:border-gray-600 rounded-lg checked:border-blue-500 transition-all duration-200">
                                <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500/30 rounded-lg transition-colors duration-200"></div>
                            </div>
                            <span class="ml-4 flex-1 text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-200">
                                {{ $marca->nome }}
                            </span>
                            <span class="text-xs font-medium px-2.5 py-1.5 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-600 dark:text-gray-400 group-hover:from-blue-50 group-hover:to-blue-100 dark:group-hover:from-blue-900/30 dark:group-hover:to-blue-900/20 transition-all duration-300">
                                {{ $marca->produtos_count }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Filtros ativos --}}
        @if($search || $categoriaId || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
        <div class="pt-6 border-t border-gray-200 dark:border-gray-800 mt-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-gradient-to-r from-blue-500/10 to-indigo-600/10 rounded-lg">
                    <i class="fas fa-check-circle text-blue-500 dark:text-blue-400 text-sm"></i>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200">Filtros Ativos</h3>
            </div>
            <div class="flex flex-wrap gap-3">
                @if($search)
                <div class="group relative">
                    <span class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/20 text-blue-700 dark:text-blue-400 border-2 border-blue-200 dark:border-blue-800/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-md">
                        <i class="fas fa-search text-xs mr-2.5"></i>
                        "{{ Str::limit($search, 12) }}"
                    </span>
                    <button wire:click="$set('search', '')" 
                            class="absolute -top-2 -right-2 w-6 h-6 bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-800 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-md">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                @endif
                
                @if($categoriaId && $categorias->find($categoriaId))
                <div class="group relative">
                    <span class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-900/20 text-green-700 dark:text-green-400 border-2 border-green-200 dark:border-green-800/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-md">
                        <i class="fas fa-tag text-xs mr-2.5"></i>
                        {{ $categorias->find($categoriaId)->nome }}
                    </span>
                    <button wire:click="$set('categoriaId', '')" 
                            class="absolute -top-2 -right-2 w-6 h-6 bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-800 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-md">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                @endif
                
                @if($marcaId && $marcas->find($marcaId))
                <div class="group relative">
                    <span class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-900/20 text-purple-700 dark:text-purple-400 border-2 border-purple-200 dark:border-purple-800/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-md">
                        <i class="fas fa-copyright text-xs mr-2.5"></i>
                        {{ $marcas->find($marcaId)->nome }}
                    </span>
                    <button wire:click="$set('marcaId', '')" 
                            class="absolute -top-2 -right-2 w-6 h-6 bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-800 rounded-full flex items-center justify-center text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-md">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                @endif
                
                @if($precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                <div class="group relative">
                    <span class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-900/20 text-amber-700 dark:text-amber-400 border-2 border-amber-200 dark:border-amber-800/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-md">
                        <i class="fas fa-money-bill-wave text-xs mr-2.5"></i>
                        {{ format_kwanza($precoMin) }} - {{ format_kwanza($precoMax) }}
                    </span>
                    <button wire:click="$set(['precoMin' => 0, 'precoMax' => $precoMaximoDisponivel])" 
                            class="absolute -top-2 -right-2 w-6 h-6 bg-white dark:bg-gray-800 border-2 border-amber-200 dark:border-amber-800 rounded-full flex items-center justify-center text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-md">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</aside>
<!-- Modal Filtros Mobile -->
<div x-data="mobileFilters()" x-cloak>
    <div x-show="open" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        <div class="fixed inset-0 bg-black/50" @click="closeModal"></div>

        <div class="fixed inset-y-0 right-0 w-full max-w-sm bg-white dark:bg-gray-800 shadow-xl overflow-y-auto transform transition-transform duration-300"
             :class="{ 'translate-x-0': open, 'translate-x-full': !open }">
            
            <div class="h-full flex flex-col">
                {{-- Header --}}
                <div class="flex-none px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Filtros</h2>
                        <div class="flex items-center gap-3">
                            @if($search || $categoriaId || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                                <button wire:click="limparFiltros"
                                        class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    Limpar tudo
                                </button>
                            @endif
                            <button @click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Conteúdo rolável --}}
                <div class="flex-1 overflow-y-auto">
                    <div class="p-6 space-y-6">
                        
                        {{-- Filtros ativos --}}
                        @if($search || $categoriaId || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filtros Ativos:</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($search)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                    "{{ $search }}"
                                    <button wire:click="$set('search', '')" class="ml-1">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endif
                                
                                @if($categoriaId && $categorias->find($categoriaId))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                    {{ $categorias->find($categoriaId)->nome }}
                                    <button wire:click="$set('categoriaId', '')" class="ml-1">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Busca --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Buscar produto
                            </label>
                            <div class="relative">
                                <input type="text"
                                       wire:model.live.debounce.500ms="search"
                                       placeholder="Digite nome ou descrição..."
                                       class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        {{-- Filtro preço com accordion --}}
                        <div x-data="{ open: true }" class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <button @click="open = !open" class="w-full px-4 py-3 flex items-center justify-between bg-gray-50 dark:bg-gray-700/50">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Faixa de Preço</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open }"></i>
                            </button>
                            
                            <div x-show="open" x-collapse class="p-4">
                                <div class="space-y-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Min: {{ format_kwanza($precoMin) }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">Max: {{ format_kwanza($precoMax) }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <input type="number"
                                               wire:model.live.debounce.500ms="precoMin"
                                               min="0"
                                               max="{{ $precoMaximoDisponivel ?? 10000 }}"
                                               class="w-1/2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                                        <input type="number"
                                               wire:model.live.debounce.500ms="precoMax"
                                               min="0"
                                               max="{{ $precoMaximoDisponivel ?? 10000 }}"
                                               class="w-1/2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Filtro categoria com accordion --}}
                        @if($categorias->count() > 0)
                        <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <button @click="open = !open" class="w-full px-4 py-3 flex items-center justify-between bg-gray-50 dark:bg-gray-700/50">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Categorias</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open }"></i>
                            </button>
                            
                            <div x-show="open" x-collapse class="max-h-60 overflow-y-auto">
                                <div class="p-4 space-y-2">
                                    @foreach($categorias as $categoria)
                                    <label class="flex items-center cursor-pointer p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <input type="radio"
                                               name="categoria_mobile"
                                               wire:model.live="categoriaId"
                                               value="{{ $categoria->id_categoria }}"
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $categoria->nome }}
                                            <span class="text-gray-500 text-xs ml-1">({{ $categoria->produtos_count }})</span>
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Filtro marca com accordion --}}
                        @if($marcas && $marcas->count() > 0)
                        <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <button @click="open = !open" class="w-full px-4 py-3 flex items-center justify-between bg-gray-50 dark:bg-gray-700/50">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Marcas</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open }"></i>
                            </button>
                            
                            <div x-show="open" x-collapse class="max-h-60 overflow-y-auto">
                                <div class="p-4 space-y-2">
                                    @foreach($marcas as $marca)
                                    <label class="flex items-center cursor-pointer p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <input type="radio"
                                               name="marca_mobile"
                                               wire:model.live="marcaId"
                                               value="{{ $marca->id_marca }}"
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $marca->nome }}
                                            <span class="text-gray-500 text-xs ml-1">({{ $marca->produtos_count }})</span>
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex-none p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex gap-3">
                        <button @click="closeModal"
                                class="flex-1 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancelar
                        </button>
                        <button @click="closeModal"
                                class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('mobileFilters', () => ({
        open: false,
        
        init() {
            window.addEventListener('open-filters', () => {
                this.open = true;
                document.body.style.overflow = 'hidden';
            });
        },
        
        closeModal() {
            this.open = false;
            document.body.style.overflow = 'auto';
        }
    }));
});
</script>
@endpush
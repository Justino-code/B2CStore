{{-- resources/views/livewire/pages/public/categoria-show.blade.php --}}
<div>
    {{-- Breadcrumb --}}
    <nav class="py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <a href="{{ route('categorias') }}" 
                       class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        Categorias
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-gray-900 dark:text-white font-medium truncate max-w-xs">
                        {{ $categoria->nome }}
                    </span>
                </li>
            </ol>
        </div>
    </nav>

    <div class="py-8 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            {{-- Category Header --}}
            <div class="mb-12">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-8">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $categoria->nome }}
                        </h1>
                        @if($categoria->descricao)
                            <p class="text-gray-600 dark:text-gray-400 text-lg max-w-3xl">
                                {{ $categoria->descricao }}
                            </p>
                        @endif
                    </div>
                    
                    {{-- Category Stats --}}
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg min-w-32">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Total de Produtos</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProdutos }}</p>
                        </div>
                        
                        @if($precoMinimoDisponivel > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg min-w-32">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Preço a partir de</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ format_kwanza($precoMinimoDisponivel) }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- Filters Sidebar --}}
                <div class="lg:w-1/4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 sticky top-4">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Filtros</h2>
                            <button wire:click="limparFiltros" 
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                Limpar todos
                            </button>
                        </div>

                        {{-- Search --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Buscar produtos
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       wire:model.live.debounce.500ms="search"
                                       placeholder="Digite o nome do produto..."
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>

                        {{-- Brands --}}
                        @if($marcas->count() > 0)
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Marcas</h3>
                            <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
                                @foreach($marcas as $marca)
                                <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg transition-colors">
                                    <input type="radio" 
                                           wire:model.live="marcaId"
                                           value="{{ $marca->id_marca }}"
                                           class="text-blue-600 focus:ring-blue-500 rounded-full">
                                    <span class="text-gray-600 dark:text-gray-400 flex-1">
                                        {{ $marca->nome }}
                                    </span>
                                    <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full">
                                        {{ $marca->produtos_count }}
                                    </span>
                                </label>
                                @endforeach
                                <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg transition-colors">
                                    <input type="radio" 
                                           wire:model.live="marcaId"
                                           value=""
                                           class="text-blue-600 focus:ring-blue-500 rounded-full">
                                    <span class="text-gray-600 dark:text-gray-400">Todas as marcas</span>
                                </label>
                            </div>
                        </div>
                        @endif

                        {{-- Price Range --}}
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Preço: {{ format_kwanza($precoMin) }} - {{ format_kwanza($precoMax) }}
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                    <span>{{ format_kwanza(0) }}</span>
                                    <span>{{ format_kwanza($precoMaximoDisponivel) }}</span>
                                </div>
                                <div class="space-y-3">
                                    <input type="range" 
                                           wire:model.live="precoMin"
                                           min="0" 
                                           max="{{ $precoMaximoDisponivel }}"
                                           step="10"
                                           class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer">
                                    <input type="range" 
                                           wire:model.live="precoMax"
                                           min="0" 
                                           max="{{ $precoMaximoDisponivel }}"
                                           step="10"
                                           class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer">
                                </div>
                            </div>
                        </div>

                        {{-- Sort --}}
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Ordenar por</h3>
                            <select wire:model.live="ordenarPor" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="mais_recentes">Mais recentes</option>
                                <option value="preco_menor">Preço: menor primeiro</option>
                                <option value="preco_maior">Preço: maior primeiro</option>
                                <option value="nome_az">Nome: A-Z</option>
                                <option value="nome_za">Nome: Z-A</option>
                                <option value="mais_vendidos">Mais vendidos</option>
                                <option value="mais_avaliados">Melhor avaliados</option>
                            </select>
                        </div>

                        {{-- Items per page --}}
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Itens por página</h3>
                            <select wire:model.live="itensPorPagina" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="12">12 produtos</option>
                                <option value="24">24 produtos</option>
                                <option value="36">36 produtos</option>
                                <option value="48">48 produtos</option>
                            </select>
                        </div>
                    </div>

                    {{-- Featured Products --}}
                    @if($produtosDestaque->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-star text-amber-500 mr-2"></i>
                            Produtos em Destaque
                        </h3>
                        <div class="space-y-4">
                            @foreach($produtosDestaque as $produto)
                            <a href="{{ route('produto.detalhe', $produto->slug) }}" 
                               class="flex items-center space-x-3 group hover:bg-gray-50 dark:hover:bg-gray-700 p-3 rounded-xl transition-all duration-300 border border-transparent hover:border-gray-200 dark:hover:border-gray-700">
                                <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                    <img src="{{ image_url($produto->imagens->first()?->url_imagem) }}" 
                                         alt="{{ $produto->nome }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                         onerror="this.src='{{ image_url('placeholder.jpg') }}'">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ Str::limit($produto->nome, 40) }}
                                    </h4>
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                            {{ format_kwanza($produto->preco) }}
                                        </p>
                                        @if($produto->preco_promocional)
                                        <span class="text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 px-2 py-1 rounded-full">
                                            -{{ calculateDiscountPercentage($produto->preco, $produto->preco_promocional) }}%
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Products Section --}}
                <div class="lg:w-3/4">
                    {{-- Results Info --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="text-gray-600 dark:text-gray-400">
                                Mostrando <span class="font-semibold text-gray-900 dark:text-white">{{ $produtos->firstItem() ?? 0 }}-{{ $produtos->lastItem() ?? 0 }}</span> 
                                de <span class="font-semibold text-gray-900 dark:text-white">{{ $totalProdutos }}</span> produtos
                            </div>
                            
                            @if($search || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                            <div class="flex flex-wrap gap-2">
                                @if($search)
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">
                                    Busca: {{ $search }}
                                    <button wire:click="$set('search', '')" class="ml-2 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endif
                                
                                @if($marcaId)
                                @php
                                    $marcaSelecionada = $marcas->firstWhere('id_marca', $marcaId);
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">
                                    Marca: {{ $marcaSelecionada->nome ?? '' }}
                                    <button wire:click="$set('marcaId', '')" class="ml-2 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endif
                                
                                @if($precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm">
                                    Preço: {{ format_kwanza($precoMin) }} - {{ format_kwanza($precoMax) }}
                                    <button wire:click="limparPrecoFiltro" class="ml-2 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Products Grid --}}
                    @if($produtos->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach($produtos as $produto)
                                <x-ui.product-card :produto="$produto" />
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mb-8">
                            {{ $produtos->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                            <i class="fas fa-box-open text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                Nenhum produto encontrado
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                @if($search || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                                    Nenhum produto corresponde aos seus filtros.
                                @else
                                    Esta categoria ainda não possui produtos disponíveis.
                                @endif
                            </p>
                            @if($search || $marcaId || $precoMin > 0 || $precoMax < $precoMaximoDisponivel)
                                <button wire:click="limparFiltros"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center space-x-2">
                                    <i class="fas fa-times mr-2"></i>
                                    Limpar filtros
                                </button>
                            @endif
                        </div>
                    @endif

                    {{-- Category Description --}}
                    @if($categoria->descricao_longa)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            Sobre a Categoria {{ $categoria->nome }}
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $categoria->descricao_longa !!}
                        </div>
                    </div>
                    @endif

                    {{-- Top Brands in Category --}}
                    @if($marcas->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Marcas Disponíveis
                        </h2>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                @foreach($marcas->take(10) as $marca)
                                <a href="{{ route('produtos') }}?marcaId={{ $marca->id_marca }}"
                                   class="group flex flex-col items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300">
                                    @if($marca->logo_url)
                                    <div class="w-16 h-16 mb-3 rounded-full bg-white dark:bg-gray-700 p-2 flex items-center justify-center">
                                        <img src="{{ image_url($marca->logo_url) }}" 
                                             alt="{{ $marca->nome }}"
                                             class="w-full h-full object-contain"
                                             onerror="this.src='{{ image_url('placeholder.jpg') }}'">
                                    </div>
                                    @else
                                    <div class="w-16 h-16 mb-3 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-copyright text-blue-600 dark:text-blue-400 text-2xl"></i>
                                    </div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center line-clamp-2">
                                        {{ $marca->nome }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $marca->produtos_count }} produtos
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    .prose {
        color: #374151;
    }
    
    .dark .prose {
        color: #d1d5db;
    }
    
    .prose p {
        margin-bottom: 1rem;
    }
    
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .prose ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    
    /* Custom scrollbar for brands list */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        @apply bg-gray-100 dark:bg-gray-700 rounded;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        @apply bg-gray-400 dark:bg-gray-500 rounded;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        @apply bg-gray-500 dark:bg-gray-400;
    }
    
    /* Range slider styling */
    input[type="range"]::-webkit-slider-thumb {
        @apply appearance-none w-5 h-5 rounded-full bg-blue-600 dark:bg-blue-400 cursor-pointer shadow;
    }
    
    input[type="range"]::-moz-range-thumb {
        @apply w-5 h-5 rounded-full bg-blue-600 dark:bg-blue-400 cursor-pointer border-0 shadow;
    }
</style>
@endpush

@push('scripts')
<script>
    // Smooth scroll to top when filters change
    Livewire.hook('commit', ({ component, commit, respond, succeed }) => {
        respond(() => {
            setTimeout(() => {
                window.scrollTo({
                    top: 200,
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
</script>
@endpush
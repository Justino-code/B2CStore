{{-- resources/views/livewire/pages/public/categorias-index.blade.php --}}
<div>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="container mx-auto px-4">
            
            {{-- Breadcrumb --}}
            <nav class="mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-gray-900 dark:text-white font-medium">Categorias</span>
                    </li>
                </ol>
            </nav>

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                    Todas as Categorias
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Explore nossa variedade de produtos por categoria
                </p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="rounded-lg bg-blue-100 dark:bg-blue-900/30 p-3 mr-4">
                            <i class="fas fa-th-large text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Categorias Ativas</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $categoriasAtivas->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="rounded-lg bg-green-100 dark:bg-green-900/30 p-3 mr-4">
                            <i class="fas fa-box text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total de Produtos</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $categoriasAtivas->sum('produtos_count') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="rounded-lg bg-purple-100 dark:bg-purple-900/30 p-3 mr-4">
                            <i class="fas fa-star text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Categoria Mais Popular</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                {{ $categoriasAtivas->sortByDesc('produtos_count')->first()?->nome ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="rounded-lg bg-amber-100 dark:bg-amber-900/30 p-3 mr-4">
                            <i class="fas fa-chart-line text-amber-600 dark:text-amber-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Média por Categoria</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ round($categoriasAtivas->avg('produtos_count') ?? 0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Controls Bar --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-8 relative">
                {{-- Loading indicator --}}
                <div wire:loading wire:target="search,ordenarPor,itensPorPagina" 
                     class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center z-10">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-8 h-8 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Atualizando...</span>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    {{-- Search --}}
                    <div class="md:w-1/3">
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live.debounce.500ms="search"
                                   wire:loading.attr="disabled"
                                   placeholder="Buscar categoria..."
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Sort and Items per page --}}
                    <div class="flex items-center gap-4">
                        {{-- Items per page --}}
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Mostrar:</span>
                            <select wire:model.live="itensPorPagina" 
                                    wire:loading.attr="disabled"
                                    class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="36">36</option>
                                <option value="48">48</option>
                            </select>
                        </div>
                        
                        {{-- Sort --}}
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" 
                                    wire:loading.attr="disabled"
                                    class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                <i class="fas fa-sort"></i>
                                <span>
                                    @switch($ordenarPor)
                                        @case('nome_az') Nome: A-Z @break
                                        @case('nome_za') Nome: Z-A @break
                                        @case('mais_produtos') Mais produtos @break
                                        @case('menos_produtos') Menos produtos @break
                                        @case('ordem_crescente') Ordem crescente @break
                                        @case('ordem_decrescente') Ordem decrescente @break
                                    @endswitch
                                </span>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-transition
                                 class="absolute z-20 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 right-0"
                                 style="display: none;">
                                <div class="py-1">
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
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                    <button wire:click="$set('ordenarPor', 'mais_produtos')"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'mais_produtos' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                                        <span>Mais produtos primeiro</span>
                                        @if($ordenarPor === 'mais_produtos')
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        @endif
                                    </button>
                                    <button wire:click="$set('ordenarPor', 'menos_produtos')"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'menos_produtos' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                                        <span>Menos produtos primeiro</span>
                                        @if($ordenarPor === 'menos_produtos')
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        @endif
                                    </button>
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                    <button wire:click="$set('ordenarPor', 'ordem_crescente')"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'ordem_crescente' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                                        <span>Ordem crescente</span>
                                        @if($ordenarPor === 'ordem_crescente')
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        @endif
                                    </button>
                                    <button wire:click="$set('ordenarPor', 'ordem_decrescente')"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-between {{ $ordenarPor === 'ordem_decrescente' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                                        <span>Ordem decrescente</span>
                                        @if($ordenarPor === 'ordem_decrescente')
                                            <i class="fas fa-check text-blue-600 dark:text-blue-400 text-xs"></i>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Categories Grid --}}
            @if($categorias->count() > 0)
                <div wire:loading.remove wire:target="search,ordenarPor,itensPorPagina" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($categorias as $categoria)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100/50 dark:border-gray-700/50 hover:-translate-y-1">
                            {{-- Category Header --}}
                            <a href="{{ route('categoria', $categoria->slug) }}" class="block">
                                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                                    @if($categoria->imagem_url)
                                        <img 
                                            src="{{ image_url($categoria->imagem_url) }}" 
                                            alt="{{ $categoria->nome }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                            loading="lazy"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-boxes text-gray-300 dark:text-gray-700 text-6xl"></i>
                                        </div>
                                    @endif
                                    
                                    {{-- Product Count Badge --}}
                                    <div class="absolute top-4 right-4">
                                        <span class="px-3 py-1.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-gray-900 dark:text-white text-sm font-bold rounded-full shadow-lg">
                                            {{ $categoria->produtos_count }} produtos
                                        </span>
                                    </div>
                                </div>
                            </a>

                            {{-- Category Content --}}
                            <div class="p-6">
                                <a href="{{ route('categoria', $categoria->slug) }}" class="block">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $categoria->nome }}
                                    </h3>
                                </a>
                                
                                @if($categoria->descricao)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($categoria->descricao, 100) }}
                                    </p>
                                @endif

                                {{-- Featured Products Preview --}}
                                @if($categoria->produtos_destaque && $categoria->produtos_destaque->count() > 0)
                                    <div class="mb-4">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Produtos em destaque:</p>
                                        <div class="flex -space-x-2">
                                            @foreach($categoria->produtos_destaque->take(3) as $produto)
                                                <div class="relative w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 overflow-hidden">
                                                    @if($produto->imagens->first()?->url_imagem)
                                                        <img 
                                                            src="{{ image_url($produto->imagens->first()->url_imagem) }}" 
                                                            alt="{{ $produto->nome }}"
                                                            class="w-full h-full object-cover"
                                                        >
                                                    @else
                                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                            <i class="fas fa-box text-gray-400 dark:text-gray-500 text-xs"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if($categoria->produtos_destaque->count() > 3)
                                                <div class="relative w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                                                    +{{ $categoria->produtos_destaque->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                {{-- Category Action --}}
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <a href="{{ route('categoria', $categoria->slug) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium text-sm flex items-center">
                                        Ver produtos
                                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </a>
                                    
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $categoria->produtos_count > 20 ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 
                                           ($categoria->produtos_count > 5 ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 
                                           'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300') }}">
                                        {{ $categoria->produtos_count > 20 ? 'Grande' : 
                                           ($categoria->produtos_count > 5 ? 'Média' : 'Pequena') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginação com loading --}}
                <div class="mb-8 relative">
                    {{-- Loading overlay para paginação --}}
                    <div wire:loading wire:target="gotoPage,previousPage,nextPage"
                         class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center z-10">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-8 h-8 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Carregando...</span>
                        </div>
                    </div>
                    
                    {{-- Paginação normal --}}
                    <div wire:loading.remove wire:target="gotoPage,previousPage,nextPage">
                        {{ $categorias->links('vendor.livewire.tailwind') }}
                    </div>
                </div>
            @else
                {{-- No Categories Found --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                    <i class="fas fa-th-large text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        Nenhuma categoria encontrada
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        @if($search)
                            Nenhuma categoria corresponde à sua busca.
                        @else
                            Não há categorias cadastradas no momento.
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            Limpar busca
                        </button>
                    @endif
                </div>
            @endif

            {{-- Featured Categories --}}
            @if($categoriasAtivas->count() > 0)
                <div class="mb-16">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-8">
                        Categorias em Destaque
                    </h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                        @foreach($categoriasAtivas->where('produtos_count', '>', 0)->sortByDesc('produtos_count')->take(8) as $categoria)
                            <a href="{{ route('categoria', $categoria->slug) }}"
                               class="group bg-white dark:bg-gray-800 rounded-xl p-4 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    @if($categoria->imagem_url)
                                        <img src="{{ image_url($categoria->imagem_url) }}" 
                                             alt="{{ $categoria->nome }}"
                                             class="w-8 h-8 object-contain">
                                    @else
                                        <i class="fas fa-box text-blue-600 dark:text-blue-400 text-lg"></i>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-1 text-sm line-clamp-1">
                                    {{ $categoria->nome }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $categoria->produtos_count }} produtos
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- All Categories List (Alphabetical) --}}
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-8">
                    Todas as Categorias (A-Z)
                </h2>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @php
                            $groupedCategories = $categoriasAtivas->groupBy(function($item) {
                                return strtoupper(substr($item->nome, 0, 1));
                            })->sortKeys();
                        @endphp
                        
                        @foreach($groupedCategories as $letter => $letterCategories)
                            <div class="border-r border-b border-gray-200 dark:border-gray-700">
                                <div class="p-4 bg-gray-50 dark:bg-gray-900">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $letter }}</h3>
                                </div>
                                <div class="p-4">
                                    <ul class="space-y-2">
                                        @foreach($letterCategories as $categoria)
                                            <li>
                                                <a href="{{ route('categoria', $categoria->slug) }}"
                                                   class="flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded-lg transition-colors">
                                                    <span class="truncate">{{ $categoria->nome }}</span>
                                                    <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full">
                                                        {{ $categoria->produtos_count }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
    
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }
</style>
@endpush
{{-- resources/views/components/produto-card-list.blade.php --}}

@php
    $imagem = $produto->imagens->first()?->url_imagem;
    $isFavorito = auth()->check() && auth()->user()->favoritos->contains($produto->id_produto);
    $desconto = calculateDiscountPercentage($produto->preco, $produto->preco_promocional);
@endphp

<div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden
            border border-gray-100/80 dark:border-gray-700/50 hover:border-blue-200/50 dark:hover:border-blue-500/20
            relative before:absolute before:inset-0 before:bg-gradient-to-r before:from-blue-50/0 before:via-white/0 before:to-white/0
            dark:before:from-gray-900/0 before:transition-all before:duration-700 before:hover:from-blue-50/5 before:hover:via-white/3
            dark:before:hover:from-blue-500/5 before:hover:to-white/5"
     x-data="{ showActions: false }"
     @mouseenter="showActions = true"
     @mouseleave="showActions = false">

    {{-- Efeito de brilho sutil --}}
    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500/0 via-indigo-500/0 to-purple-500/0 
                group-hover:from-blue-500/5 group-hover:via-indigo-500/5 group-hover:to-purple-500/5 
                blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 -z-10"></div>

    <div class="flex flex-col lg:flex-row relative z-10">

        {{-- Imagem com efeito elegante --}}
        <div class="lg:w-2/5 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 z-0"></div>
            
            <a href="{{ route('produto.detalhe', $produto->slug) }}" class="block relative z-10 h-full">
                <div class="relative overflow-hidden h-64 lg:h-full">
                    @if($imagem)
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/20 to-indigo-100/10 dark:from-blue-900/10 dark:to-indigo-900/10"></div>
                        <img src="{{ image_url($imagem) }}"
                             alt="{{ $produto->nome }}"
                             class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110 group-hover:rotate-1"
                             loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-500/20 rounded-full blur-xl"></div>
                                <i class="fas fa-cube text-gray-300 dark:text-gray-600 text-5xl relative z-10"></i>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Badges modernas --}}
                <div class="absolute top-4 left-4 flex flex-col gap-3">
                    @if($desconto > 0)
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-pink-500 rounded-xl blur opacity-70"></div>
                            <span class="relative px-3 py-1.5 bg-gradient-to-r from-rose-500 to-pink-500 text-white 
                                       text-xs font-bold rounded-xl shadow-lg flex items-center gap-1.5">
                                <i class="fas fa-bolt text-xs"></i>
                                {{ $desconto }}% OFF
                            </span>
                        </div>
                    @endif
                    @if($produto->novidade)
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl blur opacity-70"></div>
                            <span class="relative px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white 
                                       text-xs font-bold rounded-xl shadow-lg flex items-center gap-1.5">
                                <i class="fas fa-sparkles text-xs"></i>
                                NOVO
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Estoque baixo --}}
                @if($produto->estoque > 0 && $produto->estoque <= 10)
                    <div class="absolute bottom-4 right-4">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full blur opacity-50"></div>
                            <span class="relative px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white 
                                       text-xs font-medium rounded-full shadow-lg flex items-center gap-1.5">
                                <i class="fas fa-fire text-xs"></i>
                                {{ $produto->estoque }} restantes
                            </span>
                        </div>
                    </div>
                @endif
            </a>
        </div>

        {{-- Conteúdo --}}
        <div class="flex-1 p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-8">

                {{-- Informações principais --}}
                <div class="flex-1 space-y-6">
                    {{-- Categoria com ícone --}}
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-900/10 rounded-lg">
                            <i class="fas fa-tag text-blue-500 dark:text-blue-400 text-xs"></i>
                        </div>
                        <a href="{{ route('categoria', $produto->categoria->slug) }}"
                           class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 
                                  transition-colors duration-300 group/category inline-flex items-center">
                            {{ $produto->categoria->nome }}
                            <i class="fas fa-arrow-right ml-1 text-xs opacity-0 group-hover/category:opacity-100 
                                      group-hover/category:translate-x-0.5 transition-all duration-300"></i>
                        </a>
                    </div>

                    {{-- Nome do produto --}}
                    <div class="space-y-3">
                        <h3 class="mb-1">
                            <a href="{{ route('produto.detalhe', $produto->slug) }}"
                               class="text-2xl font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 
                                      transition-colors duration-300 inline-flex items-center gap-2 group/title">
                                {{ $produto->nome }}
                                <i class="fas fa-external-link-alt text-sm text-gray-400 group-hover/title:text-blue-500 
                                          opacity-0 group-hover/title:opacity-100 transition-all duration-300"></i>
                            </a>
                        </h3>

                        {{-- Descrição breve --}}
                        @if($produto->descricao)
                            <div class="relative">
                                <div class="absolute -left-4 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-300 to-indigo-300 
                                           dark:from-blue-700 dark:to-indigo-700 rounded-full opacity-0 group-hover:opacity-100 
                                           transition-opacity duration-500"></div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed pl-2">
                                    {{ Str::limit(strip_tags($produto->descricao), 180) }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Rating elegante --}}
                    @if($produto->reviews_count > 0)
                        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100/50 
                                    dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl border border-gray-200/50 
                                    dark:border-gray-700/50">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full blur opacity-30"></div>
                                    <div class="flex items-center relative z-10">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-lg mr-0.5
                                                {{ $i <= $produto->rating_medio ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($produto->rating_medio, 1) }}
                                </span>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400 border-l border-gray-300 dark:border-gray-700 pl-4">
                                <i class="fas fa-comment-alt mr-1.5"></i>
                                {{ $produto->reviews_count }} avaliações
                            </span>
                        </div>
                    @endif

                    {{-- Especificações com design moderno --}}
                    @if($produto->especificacoes)
                        <div class="grid grid-cols-2 gap-4">
                            @foreach(array_slice($produto->especificacoes, 0, 4) as $key => $value)
                                <div class="p-3 bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 
                                            rounded-lg border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 
                                            hover:border-blue-200 dark:hover:border-blue-500/30">
                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                        <i class="fas fa-check-circle text-blue-500 dark:text-blue-400 text-xs mr-1.5"></i>
                                        {{ $key }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-800 dark:text-gray-300">
                                        {{ Str::limit($value, 25) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Lado direito: Preço e ações --}}
                <div class="lg:w-2/5">
                    <div class="space-y-6 sticky top-24">
                        {{-- Preço com design premium --}}
                        <div class="text-right space-y-2">
                            <div class="inline-flex flex-col items-end p-4 bg-gradient-to-br from-blue-50 to-indigo-50/50 
                                        dark:from-blue-900/20 dark:to-indigo-900/10 rounded-2xl border border-blue-200/50 
                                        dark:border-blue-500/20">
                                @if($produto->preco_promocional && $desconto > 0)
                                    <div class="mb-2">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white bg-gradient-to-r 
                                                   from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 
                                                   bg-clip-text text-transparent">
                                            {{ format_kwanza($produto->preco_promocional) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-end gap-3">
                                        <span class="text-sm line-through text-gray-500 dark:text-gray-400 px-2 py-1 
                                                   bg-gray-100 dark:bg-gray-800 rounded-lg">
                                            {{ format_kwanza($produto->preco) }}
                                        </span>
                                        <span class="text-xs font-bold px-2 py-1 bg-gradient-to-r from-rose-500 to-pink-500 
                                                   text-white rounded-full">
                                            Economize {{ format_kwanza($produto->preco - $produto->preco_promocional) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="mb-2">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            {{ format_kwanza($produto->preco) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Preço regular
                                    </div>
                                @endif
                            </div>

                            {{-- Status do estoque --}}
                            @if($produto->estoque <= 0)
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-rose-100 to-pink-100 
                                            dark:from-rose-900/30 dark:to-pink-900/20 text-rose-700 dark:text-rose-400 
                                            rounded-xl text-sm font-medium">
                                    <i class="fas fa-times-circle"></i>
                                    Esgotado
                                </div>
                            @elseif($produto->estoque <= 5)
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-orange-100 
                                            dark:from-amber-900/30 dark:to-orange-900/20 text-amber-700 dark:text-amber-400 
                                            rounded-xl text-sm font-medium animate-pulse">
                                    <i class="fas fa-fire"></i>
                                    Últimas unidades!
                                </div>
                            @endif
                        </div>

                        {{-- Ações modernas --}}
                        <div class="space-y-3"
                             :class="{ 'opacity-100 translate-y-0': showActions, 'opacity-0 translate-y-2': !showActions }"
                             x-transition:enter="transition-all duration-500 ease-out"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition-all duration-300 ease-in"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2">
                            
                            {{-- Botão principal de compra (VERSÃO MELHORADA) --}}
                            @if($produto->estoque > 0 && $produto->estoque <= 5)
                                {{-- Botão de urgência para estoque baixo --}}
                                <button wire:click="addToCart({{ $produto->id_produto }})"
                                        wire:loading.attr="disabled"
                                        class="w-full group/urgent relative overflow-hidden animate-pulse hover:animate-none">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 
                                                group-hover/urgent:from-amber-600 group-hover/urgent:via-orange-600 group-hover/urgent:to-red-600 
                                                transition-all duration-500"></div>
                                    
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-300 to-amber-300 opacity-0 
                                                group-hover/urgent:opacity-30 animate-ping group-hover/urgent:animate-none"></div>
                                    
                                    <div class="relative py-4 px-6 text-white font-bold rounded-xl flex items-center justify-center gap-3
                                                shadow-xl hover:shadow-2xl transition-all duration-300">
                                        <i class="fas fa-bolt text-xl animate-bounce group-hover/urgent:animate-none"></i>
                                        <span>COMPRAR AGORA</span>
                                        <span class="ml-auto bg-white/30 px-2 py-1 rounded text-xs font-bold">
                                            APENAS {{ $produto->estoque }} {{ $produto->estoque == 1 ? 'UNIDADE' : 'UNIDADES' }}
                                        </span>
                                        <i class="fas fa-fire text-sm"></i>
                                    </div>
                                </button>
                                
                            @elseif($produto->estoque <= 0)
                                {{-- Botão para produto esgotado --}}
                                <button disabled
                                        class="w-full relative overflow-hidden opacity-80 cursor-not-allowed">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-r from-gray-400 to-gray-600"></div>
                                    
                                    <div class="relative py-4 px-6 text-white font-medium rounded-xl flex items-center justify-center gap-3
                                                shadow-inner">
                                        <i class="fas fa-times-circle text-xl"></i>
                                        <span>PRODUTO ESGOTADO</span>
                                        <div class="ml-auto">
                                            <span class="text-xs opacity-75">Indisponível</span>
                                        </div>
                                    </div>
                                </button>
                                
                            @else
                                {{-- Botão normal com efeitos elegantes --}}
                                <button wire:click="addToCart({{ $produto->id_produto }})"
                                        wire:loading.attr="disabled"
                                        class="w-full group/btn-elegant relative overflow-hidden bg-gradient-to-br from-gray-900 to-black 
                                               dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-all duration-500
                                               border border-gray-700/50 dark:border-gray-600/50 hover:border-blue-500/50">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-cyan-500/0 to-indigo-500/0 
                                                group-hover/btn-elegant:from-blue-500/10 group-hover/btn-elegant:via-cyan-500/5 
                                                group-hover/btn-elegant:to-indigo-500/10 transition-all duration-700"></div>
                                    
                                    <div class="relative py-4 px-6 flex items-center justify-between gap-4">
                                        
                                        {{-- Ícone e texto --}}
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="absolute inset-0 bg-blue-500 rounded-full blur opacity-0 
                                                            group-hover/btn-elegant:opacity-50 transition-opacity duration-500"></div>
                                                <i class="fas fa-plus-circle text-blue-400 text-lg relative z-10 
                                                          group-hover/btn-elegant:text-blue-300 transition-colors duration-300"></i>
                                            </div>
                                            <div class="text-left">
                                                <div class="text-white font-semibold text-base">Adicionar ao Carrinho</div>
                                                <div class="text-gray-400 text-xs">Clique para adicionar</div>
                                            </div>
                                        </div>
                                        
                                        {{-- Preço --}}
                                        <div class="flex items-center gap-2">
                                            <div class="text-right">
                                                @if($produto->preco_promocional && $desconto > 0)
                                                    <div class="text-xs text-gray-400 line-through">
                                                        {{ format_kwanza($produto->preco) }}
                                                    </div>
                                                    <div class="text-lg font-bold text-white">
                                                        {{ format_kwanza($produto->preco_promocional) }}
                                                    </div>
                                                @else
                                                    <div class="text-lg font-bold text-white">
                                                        {{ format_kwanza($produto->preco) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-500 text-sm 
                                                      group-hover/btn-elegant:text-blue-400 group-hover/btn-elegant:translate-x-1 
                                                      transition-all duration-300"></i>
                                        </div>
                                        
                                        {{-- Loading --}}
                                        <div wire:loading wire:target="addToCart({{ $produto->id_produto }})" 
                                             class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm rounded-xl 
                                                    flex items-center justify-center">
                                            <div class="flex items-center gap-2">
                                                <div class="w-4 h-4 border-2 border-blue-500/30 border-t-blue-400 rounded-full animate-spin"></div>
                                                <span class="text-white text-sm">Processando...</span>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            @endif

                            {{-- Botões secundários --}}
                            <div class="flex gap-3">
                                {{-- Favorito --}}
                                <button wire:click="addToFavorites({{ $produto->id_produto }})"
                                        class="flex-1 group/fav relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white 
                                                dark:from-gray-800 dark:to-gray-900 border border-gray-300/50 
                                                dark:border-gray-600/50 rounded-xl transition-all duration-300 
                                                group-hover/fav:border-rose-300 dark:group-hover/fav:border-rose-500/50"></div>
                                    <div class="relative py-3 rounded-xl flex items-center justify-center gap-2 
                                                transition-all duration-300 group-hover/fav:scale-105">
                                        <i class="fas fa-heart text-lg {{ $isFavorito ? 'text-rose-500' : 'text-gray-600 dark:text-gray-400' }} 
                                                  group-hover/fav:text-rose-500 transition-colors duration-300"></i>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $isFavorito ? 'Salvo' : 'Salvar' }}
                                        </span>
                                    </div>
                                </button>

                                {{-- Visualizar --}}
                                <a href="{{ route('produto.detalhe', $produto->slug) }}"
                                   class="flex-1 group/view relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white 
                                                dark:from-gray-800 dark:to-gray-900 border border-gray-300/50 
                                                dark:border-gray-600/50 rounded-xl transition-all duration-300 
                                                group-hover/view:border-blue-300 dark:group-hover/view:border-blue-500/50"></div>
                                    <div class="relative py-3 rounded-xl flex items-center justify-center gap-2 
                                                transition-all duration-300 group-hover/view:scale-105">
                                        <i class="fas fa-eye text-lg text-gray-600 dark:text-gray-400 
                                                  group-hover/view:text-blue-500 transition-colors duration-300"></i>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Detalhes
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Entrega estimada --}}
                        {{--
                        <div class="pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-shipping-fast text-blue-500"></i>
                                    <span>Entrega em</span>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">2-3 dias úteis</span>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Efeito de borda luminosa --}}
    <div class="absolute inset-0 rounded-2xl pointer-events-none border-2 border-transparent 
                group-hover:border-blue-500/10 dark:group-hover:border-blue-400/5 transition-all duration-700"></div>
</div>

@push('styles')
<style>
    /* Animações para os botões */
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }
    
    .animate-shimmer {
        animation: shimmer 1.5s infinite;
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }
    
    .animate-bounce {
        animation: bounce 1s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes ping {
        75%, 100% {
            transform: scale(1.1);
            opacity: 0;
        }
    }
    
    .animate-ping {
        animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    
    /* Melhorias visuais gerais */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .bg-clip-text {
        -webkit-background-clip: text;
            background-clip: text;
    }
    
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
</style>
@endpush
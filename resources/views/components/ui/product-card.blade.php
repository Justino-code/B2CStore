{{-- resources/views/components/produto-card.blade.php --}}

@php
    $imagem = $produto->imagens->first()?->url_imagem;
    $isFavorito = auth()->check() && auth()->user()->favoritos->contains($produto->id_produto);
    $desconto = calculateDiscountPercentage($produto->preco, $produto->preco_promocional);
@endphp

<div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 
            rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-700 overflow-hidden
            border border-gray-200/30 dark:border-gray-700/30 hover:border-blue-300/20 dark:hover:border-blue-500/20
            before:absolute before:inset-0 before:bg-gradient-to-br before:from-blue-500/0 before:via-indigo-500/0 before:to-purple-500/0
            before:group-hover:from-blue-500/5 before:group-hover:via-indigo-500/3 before:group-hover:to-purple-500/5
            before:transition-all before:duration-700 cursor-pointer"
     x-data="{ showActions: false }"
     @mouseenter="showActions = true"
     @mouseleave="showActions = false"
     onclick="window.location.href='{{ route('produto.detalhe', $produto->slug) }}'">

    {{-- Efeito de brilho sutil --}}
    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500/0 via-indigo-500/0 to-purple-500/0 
                group-hover:from-blue-500/10 group-hover:via-indigo-500/8 group-hover:to-purple-500/10 
                blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700 -z-10"></div>

    {{-- Badges superiores --}}
    <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
        @if($desconto > 0)
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full blur opacity-70"></div>
                <span class="relative px-3 py-1.5 bg-gradient-to-r from-rose-500 to-pink-500 text-white 
                           text-xs font-bold rounded-full shadow-lg flex items-center gap-1.5"
                      onclick="event.stopPropagation();">
                    <i class="fas fa-bolt text-xs"></i>
                    -{{ $desconto }}%
                </span>
            </div>
        @endif
        
        @if($produto->novidade)
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full blur opacity-70"></div>
                <span class="relative px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white 
                           text-xs font-bold rounded-full shadow-lg flex items-center gap-1.5"
                      onclick="event.stopPropagation();">
                    <i class="fas fa-sparkles text-xs"></i>
                    NOVO
                </span>
            </div>
        @endif
    </div>

    {{-- Container da imagem --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
        {{-- Imagem --}}
        <div class="relative aspect-square overflow-hidden">
            @if($imagem)
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/10 to-indigo-100/5 
                            dark:from-blue-900/10 dark:to-indigo-900/5"></div>
                <img src="{{ image_url($imagem) }}"
                     alt="{{ $produto->nome }}"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover transition-all duration-1000 
                            group-hover:scale-110 group-hover:rotate-1">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-500/20 rounded-full blur-xl"></div>
                        <i class="fas fa-cube text-gray-300 dark:text-gray-600 text-5xl relative z-10"></i>
                    </div>
                </div>
            @endif
        </div>

        {{-- Overlay escuro para ações --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 
                    opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

        {{-- Ações rápidas (aparecem no hover) --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 p-6
                    transition-all duration-500 ease-out"
             :class="{ 'opacity-100 translate-y-0': showActions, 'opacity-0 translate-y-4': !showActions }">
            
            {{-- Botão Visualização Rápida --}}
            <button @click="$dispatch('quick-view', { id: {{ $produto->id_produto }} })"
                    class="relative group/quickview overflow-hidden z-20"
                    onclick="event.stopPropagation();">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-0 
                            group-hover/quickview:opacity-100 transition-opacity duration-300"></div>
                <div class="relative w-14 h-14 rounded-2xl bg-white/90 backdrop-blur-sm flex items-center justify-center 
                            shadow-xl transition-all duration-300 group-hover/quickview:scale-110 
                            group-hover/quickview:shadow-2xl group-hover/quickview:bg-white">
                    <i class="fas fa-eye text-gray-700 text-lg group-hover/quickview:text-blue-600 
                              transition-colors duration-300"></i>
                </div>
                <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-900 text-white 
                            text-xs font-medium rounded opacity-0 group-hover/quickview:opacity-100 
                            transition-all duration-300 whitespace-nowrap">
                    Visualização rápida
                    <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                </div>
            </button>

            {{-- Botão Carrinho --}}
            @if($produto->estoque > 0)
                <button wire:click="addToCart({{ $produto->id_produto }})"
                        wire:loading.attr="disabled"
                        class="relative group/cart overflow-hidden z-20"
                        onclick="event.stopPropagation();">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl blur opacity-0 
                                group-hover/cart:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 
                                flex items-center justify-center shadow-xl shadow-emerald-500/30
                                transition-all duration-300 group-hover/cart:scale-110 
                                group-hover/cart:shadow-2xl group-hover/cart:shadow-emerald-500/40">
                        <i class="fas fa-shopping-cart text-white text-lg"></i>
                    </div>
                    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-900 text-white 
                                text-xs font-medium rounded opacity-0 group-hover/cart:opacity-100 
                                transition-all duration-300 whitespace-nowrap">
                        Adicionar ao carrinho
                        <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                    </div>
                    <div wire:loading wire:target="addToCart({{ $produto->id_produto }})" 
                         class="absolute inset-0 bg-emerald-600/90 backdrop-blur-sm rounded-2xl 
                                flex items-center justify-center">
                        <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    </div>
                </button>
            @endif

            {{-- Botão Favorito --}}
            <button wire:click="addToFavorites({{ $produto->id_produto }})"
                    class="relative group/fav overflow-hidden z-20"
                    onclick="event.stopPropagation();">
                <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-pink-500 rounded-2xl blur opacity-0 
                            group-hover/fav:opacity-100 transition-opacity duration-300"></div>
                <div class="relative w-14 h-14 rounded-2xl bg-white/90 backdrop-blur-sm flex items-center justify-center 
                            shadow-xl transition-all duration-300 group-hover/fav:scale-110 
                            group-hover/fav:shadow-2xl group-hover/fav:bg-white">
                    <i class="fas fa-heart text-lg transition-all duration-300 
                              {{ $isFavorito ? 'text-rose-500 animate-pulse' : 'text-gray-700' }}
                              group-hover/fav:text-rose-500"></i>
                </div>
                <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-900 text-white 
                            text-xs font-medium rounded opacity-0 group-hover/fav:opacity-100 
                            transition-all duration-300 whitespace-nowrap">
                    {{ $isFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}
                    <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                </div>
            </button>
        </div>

        {{-- Status estoque --}}
        @if($produto->estoque <= 0)
            <div class="absolute bottom-4 right-4 z-10">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full blur opacity-50"></div>
                    <span class="relative px-3 py-1.5 bg-gradient-to-r from-rose-500 to-pink-500 text-white 
                               text-xs font-bold rounded-full shadow-lg flex items-center gap-1.5"
                          onclick="event.stopPropagation();">
                        <i class="fas fa-times-circle text-xs"></i>
                        ESGOTADO
                    </span>
                </div>
            </div>
        @elseif($produto->estoque <= 5)
            <div class="absolute bottom-4 right-4 z-10">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full blur opacity-50"></div>
                    <span class="relative px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white 
                               text-xs font-bold rounded-full shadow-lg flex items-center gap-1.5 animate-pulse"
                          onclick="event.stopPropagation();">
                        <i class="fas fa-fire text-xs"></i>
                        ÚLTIMAS {{ $produto->estoque }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    {{-- Conteúdo do produto --}}
    <div class="p-6">
        {{-- Categoria --}}
        <div class="inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 mb-3 group/category">
            <div class="mr-2 p-1.5 bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-900/10 rounded-lg"
                 onclick="event.stopPropagation();">
                <i class="fas fa-tag text-blue-500 dark:text-blue-400 text-xs"></i>
            </div>
            <a href="{{ route('categoria', $produto->categoria->slug) }}" 
               class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
               onclick="event.stopPropagation();">
                <span>{{ $produto->categoria->nome }}</span>
                <i class="fas fa-arrow-right ml-1.5 text-xs opacity-0 group-hover/category:opacity-100 
                          group-hover/category:translate-x-0.5 transition-all duration-300"></i>
            </a>
        </div>

        {{-- Nome do produto --}}
        <h3 class="mb-4 group/title">
            <span class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 
                      transition-colors duration-300 line-clamp-2 inline-flex items-start">
                {{ $produto->nome }}
                <i class="fas fa-external-link-alt ml-2 text-sm text-gray-400 group-hover/title:text-blue-500 
                          opacity-0 group-hover/title:opacity-100 transition-all duration-300 mt-1"></i>
            </span>
        </h3>

        {{-- Rating --}}
        @if($produto->reviews_count > 0)
            <div class="flex items-center gap-2 mb-4 p-3 bg-gradient-to-r from-gray-50 to-gray-100/50 
                        dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl border border-gray-200/50 
                        dark:border-gray-700/50">
                <div class="flex items-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full blur opacity-30"></div>
                        <div class="flex items-center relative z-10">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-sm mr-0.5
                                    {{ $i <= $produto->rating_medio ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <span class="ml-2 text-sm font-semibold text-gray-900 dark:text-white">
                        {{ number_format($produto->rating_medio, 1) }}
                    </span>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    ({{ $produto->reviews_count }} avaliações)
                </span>
            </div>
        @endif

        {{-- Preço --}}
        <div class="mt-6 pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
            @if($produto->preco_promocional)
                <div class="space-y-2">
                    <div class="flex items-baseline gap-3">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white bg-gradient-to-r 
                                   from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 
                                   bg-clip-text text-transparent">
                            {{ format_kwanza($produto->preco_promocional) }}
                        </span>
                        <span class="text-sm line-through text-gray-500 dark:text-gray-400 px-2 py-1 
                                   bg-gray-100 dark:bg-gray-800 rounded-lg">
                            {{ format_kwanza($produto->preco) }}
                        </span>
                    </div>
                    @php $economia = $produto->preco - $produto->preco_promocional; @endphp
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold px-2 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 
                                   text-white rounded-full">
                            Economize {{ format_kwanza($economia) }}
                        </span>
                        @if($desconto > 0)
                            <span class="text-xs font-medium text-rose-600 dark:text-rose-400">
                                {{ $desconto }}% OFF
                            </span>
                        @endif
                    </div>
                </div>
            @else
                <div class="space-y-1">
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ format_kwanza($produto->preco) }}
                    </span>
                    @if($produto->parcelamento > 1)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-credit-card mr-1"></i>
                                ou {{ $produto->parcelamento }}x de 
                            </span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ format_kwanza($produto->preco / $produto->parcelamento) }}
                            </span>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Efeito de borda luminosa --}}
    <div class="absolute inset-0 rounded-3xl pointer-events-none border-2 border-transparent 
                group-hover:border-blue-500/10 dark:group-hover:border-blue-400/5 transition-all duration-700"></div>
</div>

@push('styles')
<style>
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
    
    .aspect-square {
        aspect-ratio: 1 / 1;
    }
    
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Cursor pointer para indicar que é clicável */
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush
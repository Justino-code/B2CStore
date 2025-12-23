{{-- resources/views/components/produto-card.blade.php --}}

@php
    $imagem = $produto->imagens->first()?->url_imagem;
@endphp

<div
    class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-md
           hover:shadow-xl transition-all duration-300 overflow-hidden
           border border-gray-100 dark:border-gray-700"
>

    {{-- Badge Promoção --}}
    @if(!empty($destaquePromo) && $produto->preco_promocional)
        <span
            class="absolute top-3 left-3 z-10 px-3 py-1
                   bg-red-500 text-white text-xs font-bold
                   rounded-full animate-pulse"
        >
            -{{ calculateDiscountPercentage($produto->preco, $produto->preco_promocional) }}%
        </span>
    @endif

    {{-- Badge Novo --}}
    @if(!empty($novidade))
        <span
            class="absolute top-3 right-3 z-10 px-3 py-1
                   bg-green-500 text-white text-xs font-bold
                   rounded-full"
        >
            <i class="fas fa-leaf mr-1"></i> Novo
        </span>
    @endif

    {{-- Imagem --}}
    <a href="{{ route('produto.detalhe', $produto->slug) }}"
       class="relative block bg-gray-100 dark:bg-gray-700 overflow-hidden">

        @if($imagem)
            <img
                src="{{ image_url($imagem) }}"
                alt="{{ $produto->nome }}"
                loading="lazy"
                decoding="async"
                class="w-full h-48 object-cover
                       transition-transform duration-500
                       group-hover:scale-110"
            >
        @else
            <div class="w-full h-48 flex items-center justify-center">
                <i class="fas fa-image text-gray-300 dark:text-gray-600 text-4xl"></i>
            </div>
        @endif

        {{-- Ações rápidas --}}
        <div
            class="absolute top-3 right-3 space-y-2
                   opacity-0 group-hover:opacity-100
                   transition-opacity duration-300"
        >
            <button
                wire:click="addToFavorites({{ $produto->id_produto }})"
                class="action-btn"
                aria-label="Adicionar aos favoritos"
            >
                <i class="fas fa-heart
                   {{ auth()->check() && auth()->user()->favoritos->contains($produto->id_produto)
                        ? 'text-red-500'
                        : 'text-gray-400' }}">
                </i>
            </button>

            <button
                @click="$dispatch('quick-view', { id: {{ $produto->id_produto }} })"
                class="action-btn"
                aria-label="Visualização rápida"
            >
                <i class="fas fa-eye text-gray-400"></i>
            </button>
        </div>
    </a>

    {{-- Conteúdo --}}
    <div class="p-4">

        {{-- Categoria --}}
        <a
            href="{{ route('categoria', $produto->categoria->slug) }}"
            class="text-xs font-medium text-blue-600 dark:text-blue-400
                   hover:underline"
        >
            {{ $produto->categoria->nome }}
        </a>

        {{-- Nome --}}
        <h3
            class="mt-1 mb-2 font-semibold text-gray-900 dark:text-white
                   line-clamp-1 group-hover:text-blue-600
                   dark:group-hover:text-blue-400 transition-colors"
        >
            <a href="{{ route('produto.detalhe', $produto->slug) }}">
                {{ $produto->nome }}
            </a>
        </h3>

        {{-- Rating --}}
        <div class="flex items-center mb-3">
            <div class="flex mr-2">
                @for ($i = 1; $i <= 5; $i++)
                    <i
                        class="fas fa-star text-sm
                        {{ $i <= $produto->rating_medio
                            ? 'text-yellow-400'
                            : 'text-gray-300 dark:text-gray-600' }}"
                    ></i>
                @endfor
            </div>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                ({{ $produto->reviews_count }})
            </span>
        </div>

        {{-- Preço + Estoque --}}
        <div class="flex items-center justify-between mb-4">

            <div>
                @if($produto->preco_promocional)
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ format_kwanza($produto->preco_promocional) }}
                    </span>
                    <span class="ml-2 text-sm line-through text-gray-500">
                        {{ format_kwanza($produto->preco) }}
                    </span>
                @else
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ format_kwanza($produto->preco) }}
                    </span>
                @endif
            </div>

            <span
                class="text-xs px-2 py-1 rounded-full
                {{ $produto->estoque > 0
                    ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300'
                    : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}"
            >
                {{ $produto->estoque > 0 ? $produto->estoque.' disponíveis' : 'Esgotado' }}
            </span>
        </div>

        {{-- Botão --}}
        <button
            wire:click="addToCart({{ $produto->id_produto }})"
            @disabled($produto->estoque <= 0)
            class="w-full py-3 rounded-lg font-medium text-white
                   bg-blue-600 hover:bg-blue-700
                   dark:bg-blue-700 dark:hover:bg-blue-600
                   transition-all duration-300
                   flex items-center justify-center
                   disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <i class="fas fa-shopping-cart mr-2"></i>
            {{ $produto->estoque > 0 ? 'Adicionar ao Carrinho' : 'Indisponível' }}
        </button>
    </div>
</div>
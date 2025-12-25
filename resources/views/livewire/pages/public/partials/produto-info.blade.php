{{-- resources/views/livewire/pages/public/partials/produto-info.blade.php --}}
<div>
    {{-- Category and Brand --}}
    <div class="flex items-center gap-4 mb-4">
        <a href="{{ route('categoria', $produto->categoria->slug) }}" 
           class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
            <i class="fas fa-tag mr-1.5"></i>
            {{ $produto->categoria->nome }}
        </a>
        
        @if($produto->marca)
            <a href="{{ route('produtos') }}?marcaId={{ $produto->marca->id_marca }}"
               class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-copyright mr-1.5"></i>
                {{ $produto->marca->nome }}
            </a>
        @endif
    </div>

    {{-- Product Name --}}
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
        {{ $produto->nome }}
    </h1>

    {{-- SKU --}}
    <div class="mb-6">
        <span class="text-sm text-gray-500 dark:text-gray-400">
            SKU: <span class="font-mono font-medium bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $produto->sku }}</span>
        </span>
    </div>

    {{-- Rating --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="flex items-center">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fas fa-star text-xl {{ $i <= floor($ratingMedio) ? 'text-amber-400' : ($i <= ceil($ratingMedio) ? 'text-amber-300' : 'text-gray-300 dark:text-gray-600') }} mr-1"></i>
            @endfor
            <span class="ml-2 text-lg font-semibold text-gray-900 dark:text-white">
                {{ number_format($ratingMedio, 1) }}
            </span>
        </div>
        <a href="#reviews" onclick="Alpine.data('productPage').activeTab = 'reviews'" 
           class="text-blue-600 dark:text-blue-400 hover:underline">
            ({{ $totalReviews }} {{ Str::plural('avaliação', $totalReviews) }})
        </a>
        <span class="text-gray-500 dark:text-gray-400 hidden sm:inline">•</span>
        <div class="text-gray-600 dark:text-gray-400 hidden sm:flex items-center">
            <i class="fas fa-eye mr-1"></i>
            {{ rand(100, 999) }} visualizações
        </div>
    </div>

    {{-- Price --}}
    <div class="mb-8">
        @if($produto->preco_promocional)
            <div class="flex flex-wrap items-baseline gap-4 mb-2">
                <span class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">
                    {{ format_kwanza($produto->preco_promocional) }}
                </span>
                <span class="text-2xl line-through text-gray-500 dark:text-gray-400">
                    {{ format_kwanza($produto->preco) }}
                </span>
                <span class="px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 font-bold rounded-lg">
                    Economize {{ format_kwanza($produto->preco - $produto->preco_promocional) }}
                </span>
            </div>
            <p class="text-sm text-rose-600 dark:text-rose-400 font-medium">
                Você está economizando {{ calculateDiscountPercentage($produto->preco, $produto->preco_promocional) }}%
            </p>
        @else
            <span class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">
                {{ format_kwanza($produto->preco) }}
            </span>
        @endif
        
        {{-- Installments --}}
        @if($produto->preco > 500)
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                <i class="fas fa-credit-card mr-1"></i>
                ou 12x de {{ format_kwanza($produto->preco / 12) }} sem juros
            </p>
        @endif
    </div>

    {{-- Stock Status --}}
    <div class="mb-8">
        @if($produto->estoque > 10)
            <div class="inline-flex items-center px-4 py-2.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="font-semibold">Disponível</span>
                <span class="ml-2 text-sm">({{ $produto->estoque }} em estoque)</span>
            </div>
        @elseif($produto->estoque > 0)
            <div class="inline-flex items-center px-4 py-2.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-semibold">Últimas unidades!</span>
                <span class="ml-2 text-sm">(Apenas {{ $produto->estoque }} disponíveis)</span>
            </div>
        @else
            <div class="inline-flex items-center px-4 py-2.5 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 rounded-lg">
                <i class="fas fa-times-circle mr-2"></i>
                <span class="font-semibold">Produto esgotado</span>
            </div>
        @endif
    </div>

    {{-- Quantity Selector --}}
    <div class="mb-8">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
            <i class="fas fa-box mr-1"></i> Quantidade
        </label>
        <div class="flex items-center">
            <button 
                wire:click="decrementarQuantidade"
                class="w-12 h-12 rounded-l-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 transition-colors"
                {{ $quantidade <= 1 ? 'disabled' : '' }}
                aria-label="Diminuir quantidade"
            >
                <i class="fas fa-minus"></i>
            </button>
            <input 
                type="number" 
                wire:model="quantidade"
                min="1" 
                max="{{ $produto->estoque }}"
                class="w-20 h-12 text-center border-y border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                aria-label="Quantidade do produto"
            >
            <button 
                wire:click="incrementarQuantidade"
                class="w-12 h-12 rounded-r-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 transition-colors"
                {{ $quantidade >= $produto->estoque ? 'disabled' : '' }}
                aria-label="Aumentar quantidade"
            >
                <i class="fas fa-plus"></i>
            </button>
            <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">
                Máximo: {{ $produto->estoque }} unidades
            </span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-4 mb-12">
        <button 
            wire:click="addToCart"
            {{ $produto->estoque <= 0 ? 'disabled' : '' }}
            class="flex-1 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl transition-all duration-300 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 hover:scale-[1.02] active:scale-[0.98]"
            aria-label="Adicionar ao carrinho"
        >
            <i class="fas fa-shopping-cart text-xl"></i>
            {{ $produto->estoque > 0 ? 'Adicionar ao Carrinho' : 'Indisponível' }}
        </button>
        
        <button 
            wire:click="addToFavorites"
            class="px-6 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors flex items-center justify-center hover:scale-[1.02] active:scale-[0.98]"
            aria-label="Adicionar aos favoritos"
        >
            <i class="fas fa-heart text-xl {{ auth()->check() && auth()->user()->favoritos->contains($produto->id_produto) ? 'text-rose-500' : '' }}"></i>
        </button>
    </div>

    {{-- Delivery Info --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-8">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <i class="fas fa-shipping-fast text-blue-600 dark:text-blue-400 mr-2"></i>
            Entrega e Devolução
        </h3>
        <div class="space-y-3">
            <div class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Entrega Rápida</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Entrega em 2-3 dias úteis para grandes cidades</p>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Frete Grátis</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Para compras acima de {{ format_kwanza(500) }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Devolução Fácil</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">30 dias para troca ou devolução</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Share --}}
    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Compartilhar:</p>
        <div class="flex gap-3">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
               target="_blank" 
               class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors"
               aria-label="Compartilhar no Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($produto->nome) }}" 
               target="_blank"
               class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition-colors"
               aria-label="Compartilhar no Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($produto->nome . ' ' . url()->current()) }}" 
               target="_blank"
               class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-colors"
               aria-label="Compartilhar no WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <button 
                onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link copiado!')"
                class="w-10 h-10 rounded-full bg-gray-600 text-white flex items-center justify-center hover:bg-gray-700 transition-colors"
                aria-label="Copiar link"
            >
                <i class="fas fa-link"></i>
            </button>
        </div>
    </div>
</div>
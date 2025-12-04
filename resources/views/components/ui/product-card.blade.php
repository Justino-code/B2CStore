@props(['product'])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="relative pb-2/3">
            <img class="absolute h-full w-full object-cover"
                 src="{{ $product->imagemPrincipal->url_imagem ?? 'https://via.placeholder.com/300x300' }}"
                 alt="{{ $product->nome }}">
            @if($product->preco_promocional)
                <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                    -{{ $product->percentualDesconto() }}%
                </div>
            @endif
        </div>
    </a>

    <div class="p-4">
        <div class="mb-2">
            <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 px-2 py-1 rounded">
                {{ $product->categoria->nome }}
            </span>
        </div>

        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 hover:text-blue-600 dark:hover:text-blue-400">
                {{ $product->nome }}
            </h3>
        </a>

        <div class="flex items-center mb-3">
            @if($product->preco_promocional)
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    R$ {{ number_format($product->preco_promocional, 2, ',', '.') }}
                </span>
                <span class="ml-2 text-sm text-gray-500 line-through">
                    R$ {{ number_format($product->preco, 2, ',', '.') }}
                </span>
            @else
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    R$ {{ number_format($product->preco, 2, ',', '.') }}
                </span>
            @endif
        </div>

        <div class="flex items-center justify-between mb-4">
            <span class="text-sm {{ $product->estoque > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                {{ $product->estoque > 0 ? 'Em estoque' : 'Esgotado' }}
            </span>
            @if($product->avaliacaoMedia() > 0)
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="ml-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ number_format($product->avaliacaoMedia(), 1) }}
                    </span>
                </div>
            @endif
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors duration-300 flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Adicionar ao Carrinho
        </button>
    </div>
</div>

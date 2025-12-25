{{-- resources/views/livewire/pages/public/partials/produtos-relacionados.blade.php --}}
<div class="mb-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
            Produtos Relacionados
        </h2>
        <a href="{{ route('categoria', $produto->categoria->slug) }}" 
           class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center group transition-colors">
            Ver todos
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    @if($produtosRelacionados->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($produtosRelacionados as $produtoRelacionado)
                {{-- Calculando dados adicionais para o produto card --}}
                @php
                    // Verifica se há promoção
                    $destaquePromo = $produtoRelacionado->preco_promocional ? true : false;
                    // Verifica se é novidade
                    $novidade = $produtoRelacionado->novidade ? true : false;
                    // Calcula rating médio se não existir
                    $ratingMedio = $produtoRelacionado->reviews_count > 0 
                        ? $produtoRelacionado->rating_medio 
                        : 0;
                    // Número de parcelas
                    $parcelamento = $produtoRelacionado->preco > 500 ? 12 : 6;
                @endphp

                {{-- Usando o componente produto-card existente --}}
                @include('components.ui.product-card', [
                    'produto' => $produtoRelacionado,
                    'destaquePromo' => $destaquePromo,
                    'novidade' => $novidade,
                    'parcelamento' => $parcelamento
                ])
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
            <i class="fas fa-box-open text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Nenhum produto relacionado encontrado
            </h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Explore outros produtos na mesma categoria
            </p>
        </div>
    @endif
</div>
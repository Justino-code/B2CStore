{{-- Grid de produtos --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
    @foreach($produtos as $produto)
        {{-- Calculando dados adicionais para o produto card --}}
        @php
            $destaquePromo = $produto->preco_promocional ? true : false;
            $novidade = $produto->novidade ? true : false;
            $parcelamento = $produto->preco > 500 ? 12 : 6;
        @endphp

        @include('components.ui.product-card', [
            'produto' => $produto,
            'destaquePromo' => $destaquePromo,
            'novidade' => $novidade,
            'parcelamento' => $parcelamento
        ])
    @endforeach
</div>
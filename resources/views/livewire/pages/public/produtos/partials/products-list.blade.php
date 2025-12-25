{{-- Lista de produtos --}}
<div class="space-y-4">
    @foreach($produtos as $produto)
        @include('components.ui.produto-card-list', ['produto' => $produto])
    @endforeach
</div>
{{-- resources/views/livewire/cliente/cliente-page.blade.php --}}
<div>
    @if($currentRoute === 'cliente.dashboard')
        <livewire:cliente.dashboard />
    @elseif($currentRoute === 'cliente.conta')
        <livewire:cliente.conta />
    @elseif($currentRoute === 'cliente.pedidos')
        <livewire:cliente.pedidos />
    @elseif($currentRoute === 'cliente.favoritos')
        <livewire:cliente.favoritos />
    @elseif($currentRoute === 'cliente.carrinho')
        <livewire:cliente.carrinho />
    @elseif($currentRoute === 'cliente.cupons')
        <livewire:cliente.cupons />
    @endif
</div>
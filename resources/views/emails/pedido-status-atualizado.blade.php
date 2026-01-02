<x-mail::message>
# Atualização do seu pedido #{{ $pedido->codigo_pedido }}

Olá {{ $pedido->usuario->nome }},

O status do seu pedido foi atualizado de **{{ ucfirst($statusAnterior) }}** para **{{ ucfirst($novoStatus) }}**.

<x-mail::panel>
**Detalhes do Pedido:**
- Número do Pedido: #{{ $pedido->codigo_pedido }}
- Data do Pedido: {{ $pedido->created_at->format('d/m/Y H:i') }}
- Valor Total: {{ format_kwanza($pedido->total) }}
</x-mail::panel>

@if($codigoRastreamento)
**Informações de Rastreamento:**
- Código de Rastreamento: {{ $codigoRastreamento }}
@if($transportadora)
- Transportadora: {{ $transportadora }}
@endif
@endif

@if($mensagemAdicional)
**Mensagem da Loja:**
{{ $mensagemAdicional }}
@endif

**Itens do Pedido:**
@foreach($pedido->itens as $item)
- {{ $item->quantidade }}x {{ $item->produto->nome }} - {{ format_kwanza($item->preco_unitario) }}
@endforeach

<x-mail::button :url="route('pedido.show', $pedido->id_pedido)">
Acompanhar Pedido
</x-mail::button>

Obrigado por comprar conosco!<br>
{{ config('app.name') }}
</x-mail::message>
@php
    $dados = $dados ?? [];
@endphp

<!-- Produtos Mais Vendidos -->
@if(!empty($dados['produtosMaisVendidos']))
<div class="section">
    <div class="section-title">Produtos Mais Vendidos</div>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>SKU</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
                <th>Preço Médio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['produtosMaisVendidos'] as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->sku }}</td>
                    <td class="valor">{{ $produto->quantidade_vendida }}</td>
                    <td class="valor">Kz {{ number_format($produto->valor_total, 2, ',', '.') }}</td>
                    <td class="valor">Kz {{ number_format($produto->preco_medio_vendido, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Produtos com Estoque Baixo -->
@if(!empty($dados['estoqueBaixo']))
<div class="section">
    <div class="section-title">Produtos com Estoque Baixo (< 10 unidades)</div>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>SKU</th>
                <th>Estoque</th>
                <th>Preço</th>
                <th>Valor do Estoque</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['estoqueBaixo'] as $produto)
                @php
                    $status = match(true) {
                        $produto->estoque < 3 => ['class' => 'badge-danger', 'label' => 'Crítico'],
                        $produto->estoque < 5 => ['class' => 'badge-warning', 'label' => 'Baixo'],
                        default => ['class' => 'badge-info', 'label' => 'Atenção']
                    };
                @endphp
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->sku }}</td>
                    <td class="valor">{{ $produto->estoque }}</td>
                    <td class="valor">Kz {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td class="valor">Kz {{ number_format($produto->preco * $produto->estoque, 2, ',', '.') }}</td>
                    <td><span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Produtos Nunca Vendidos -->
@if(!empty($dados['produtosNuncaVendidos']))
<div class="section">
    <div class="section-title">Produtos Nunca Vendidos (no período)</div>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>SKU</th>
                <th>Estoque</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['produtosNuncaVendidos'] as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->sku }}</td>
                    <td class="valor">{{ $produto->estoque }}</td>
                    <td class="valor">Kz {{ number_format($produto->preco, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Desempenho por Categoria -->
@if(!empty($dados['desempenhoCategorias']))
<div class="section">
    <div class="section-title">Desempenho por Categoria</div>
    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Pedidos</th>
                <th>Produtos Vendidos</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['desempenhoCategorias'] as $categoria)
                <tr>
                    <td>{{ $categoria->nome }}</td>
                    <td class="valor">{{ $categoria->pedidos }}</td>
                    <td class="valor">{{ $categoria->produtos_vendidos }}</td>
                    <td class="valor">Kz {{ number_format($categoria->valor_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(empty($dados['produtosMaisVendidos']) && empty($dados['estoqueBaixo']) && empty($dados['desempenhoCategorias']))
<div class="no-data">
    Nenhum dado disponível para o período selecionado.
</div>
@endif
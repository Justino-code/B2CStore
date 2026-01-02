@php
    $dados = $dados ?? [];
@endphp

<!-- Desempenho por Categoria -->
@if(!empty($dados['desempenhoCategorias']))
<div class="section">
    <div class="section-title">Desempenho por Categoria</div>
    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Status</th>
                <th>Pedidos</th>
                <th>Produtos Vendidos</th>
                <th>Quantidade Total</th>
                <th>Valor Total</th>
                <th>Preço Médio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['desempenhoCategorias'] as $categoria)
                @php
                    $statusClass = $categoria->ativo ? 'badge-success' : 'badge-danger';
                @endphp
                <tr>
                    <td>{{ $categoria->nome }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ $categoria->ativo ? 'Ativa' : 'Inativa' }}</span></td>
                    <td class="valor">{{ $categoria->pedidos }}</td>
                    <td class="valor">{{ $categoria->produtos_vendidos }}</td>
                    <td class="valor">{{ $categoria->quantidade_total }}</td>
                    <td class="valor">Kz {{ number_format($categoria->valor_total, 2, ',', '.') }}</td>
                    <td class="valor">Kz {{ number_format($categoria->preco_medio, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Categorias sem Vendas -->
@if(!empty($dados['categoriasSemVendas']))
<div class="section">
    <div class="section-title">Categorias sem Vendas (no período)</div>
    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Total de Produtos</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['categoriasSemVendas'] as $categoria)
                @php
                    $statusClass = $categoria->ativo ? 'badge-success' : 'badge-danger';
                @endphp
                <tr>
                    <td>{{ $categoria->nome }}</td>
                    <td class="valor">{{ $categoria->produtos_count }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ $categoria->ativo ? 'Ativa' : 'Inativa' }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Distribuição de Produtos por Categoria -->
@if(!empty($dados['distribuicaoProdutos']))
<div class="section">
    <div class="section-title">Distribuição de Produtos por Categoria</div>
    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Total de Produtos</th>
                <th>Produtos Ativos</th>
                <th>Com Estoque Baixo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['distribuicaoProdutos'] as $categoria)
                @php
                    $estoqueBaixoClass = $categoria->produtos_estoque_baixo > 0 ? 'badge-warning' : 'badge-success';
                @endphp
                <tr>
                    <td>{{ $categoria->nome }}</td>
                    <td class="valor">{{ $categoria->total_produtos }}</td>
                    <td class="valor">{{ $categoria->produtos_ativos }}</td>
                    <td>
                        <span class="badge {{ $estoqueBaixoClass }}">
                            {{ $categoria->produtos_estoque_baixo }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(empty($dados['desempenhoCategorias']) && empty($dados['categoriasSemVendas']) && empty($dados['distribuicaoProdutos']))
<div class="no-data">
    Nenhum dado disponível para o período selecionado.
</div>
@endif
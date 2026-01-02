@php
    $dados = $dados ?? [];
@endphp

<!-- Totais -->
<div class="section">
    <div class="section-title">Totais</div>
    <table>
        <tr class="total-row">
            <td>Total de Clientes</td>
            <td class="valor">{{ $dados['totais']['totalClientes'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Novos Clientes (período)</td>
            <td class="valor">{{ $dados['totais']['novosClientes'] ?? 0 }}</td>
        </tr>
    </table>
</div>

<!-- Clientes Mais Ativos -->
@if(!empty($dados['clientesMaisAtivos']))
<div class="section">
    <div class="section-title">Clientes Mais Ativos</div>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Pedidos</th>
                <th>Valor Total</th>
                <th>Ticket Médio</th>
                <th>Última Compra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['clientesMaisAtivos'] as $cliente)
                @php
                    $ticketMedio = $cliente->total_pedidos > 0 ? 
                        $cliente->valor_total / $cliente->total_pedidos : 0;
                    $ultimaCompra = $cliente->ultima_compra ? 
                        \Carbon\Carbon::parse($cliente->ultima_compra)->format('d/m/Y') : 'N/A';
                @endphp
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td class="valor">{{ $cliente->total_pedidos }}</td>
                    <td class="valor">Kz {{ number_format($cliente->valor_total, 2, ',', '.') }}</td>
                    <td class="valor">Kz {{ number_format($ticketMedio, 2, ',', '.') }}</td>
                    <td>{{ $ultimaCompra }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Clientes Inativos -->
@if(!empty($dados['clientesInativos']))
<div class="section">
    <div class="section-title">Clientes Inativos (últimos 90 dias)</div>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Total de Pedidos</th>
                <th>Data de Cadastro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['clientesInativos'] as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td class="valor">{{ $cliente->total_pedidos }}</td>
                    <td>{{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Distribuição Geográfica -->
@if(!empty($dados['distribuicaoGeografica']))
<div class="section">
    <div class="section-title">Distribuição Geográfica</div>
    <table>
        <thead>
            <tr>
                <th>Cidade</th>
                <th>Clientes</th>
                <th>Percentual</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalClientes = array_sum($dados['distribuicaoGeografica']->toArray());
            @endphp
            @foreach($dados['distribuicaoGeografica'] as $cidade => $quantidade)
                @php
                    $percentual = $totalClientes > 0 ? ($quantidade / $totalClientes * 100) : 0;
                @endphp
                <tr>
                    <td>{{ $cidade }}</td>
                    <td class="valor">{{ $quantidade }}</td>
                    <td class="valor">{{ number_format($percentual, 1) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(empty($dados['clientesMaisAtivos']) && empty($dados['clientesInativos']) && empty($dados['distribuicaoGeografica']))
<div class="no-data">
    Nenhum dado disponível para o período selecionado.
</div>
@endif
@php
    $dados = $dados ?? [];
@endphp

<!-- Estatísticas -->
<div class="section">
    <div class="section-title">Estatísticas</div>
    <table>
        <tr>
            <td>Total de Pedidos</td>
            <td class="valor">{{ $dados['estatisticas']['totalPedidos'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Pedidos com Cupom</td>
            <td class="valor">{{ $dados['estatisticas']['pedidosComCupom'] ?? 0 }}</td>
        </tr>
        <tr class="total-row">
            <td>Taxa de Utilização</td>
            <td class="valor">{{ number_format($dados['estatisticas']['taxaUtilizacao'] ?? 0, 1) }}%</td>
        </tr>
        <tr>
            <td>Ticket Médio com Cupom</td>
            <td class="valor">Kz {{ number_format($dados['estatisticas']['valorMedioComCupom'] ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Ticket Médio sem Cupom</td>
            <td class="valor">Kz {{ number_format($dados['estatisticas']['valorMedioSemCupom'] ?? 0, 2, ',', '.') }}</td>
        </tr>
        @php
            $diferenca = ($dados['estatisticas']['valorMedioComCupom'] ?? 0) - ($dados['estatisticas']['valorMedioSemCupom'] ?? 0);
            $diferencaClass = $diferenca >= 0 ? 'badge-success' : 'badge-danger';
        @endphp
        <tr class="total-row">
            <td>Diferença</td>
            <td class="valor">
                <span class="badge {{ $diferencaClass }}">
                    {{ $diferenca >= 0 ? '+' : '' }}Kz {{ number_format($diferenca, 2, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>
</div>

<!-- Cupons Mais Usados -->
@if(!empty($dados['cuponsMaisUsados']))
<div class="section">
    <div class="section-title">Cupons Mais Usados</div>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo</th>
                <th>Desconto</th>
                <th>Usos</th>
                <th>Total Descontado</th>
                <th>Valor Total Vendas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['cuponsMaisUsados'] as $cupom)
                @php
                    $desconto = $cupom->tipo_desconto == 'percentual' ? 
                        $cupom->valor_desconto . '%' : 
                        'Kz ' . number_format($cupom->valor_desconto, 2, ',', '.');
                    $statusClass = $cupom->ativo ? 'badge-success' : 'badge-danger';
                @endphp
                <tr>
                    <td>{{ $cupom->codigo }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Fixo' }}
                        </span>
                    </td>
                    <td class="valor">{{ $desconto }}</td>
                    <td class="valor">{{ $cupom->usos }}</td>
                    <td class="valor" style="color: #e53e3e;">-Kz {{ number_format($cupom->total_descontado, 2, ',', '.') }}</td>
                    <td class="valor" style="color: #38a169;">Kz {{ number_format($cupom->valor_total_vendas, 2, ',', '.') }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ $cupom->ativo ? 'Ativo' : 'Inativo' }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Cupons Expirados -->
@if(!empty($dados['cuponsExpirados']))
<div class="section">
    <div class="section-title">Cupons Expirados (ainda ativos)</div>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo</th>
                <th>Desconto</th>
                <th>Validade Fim</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['cuponsExpirados'] as $cupom)
                @php
                    $desconto = $cupom->tipo_desconto == 'percentual' ? 
                        $cupom->valor_desconto . '%' : 
                        'Kz ' . number_format($cupom->valor_desconto, 2, ',', '.');
                @endphp
                <tr>
                    <td>{{ $cupom->codigo }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Fixo' }}
                        </span>
                    </td>
                    <td class="valor">{{ $desconto }}</td>
                    <td>{{ \Carbon\Carbon::parse($cupom->validade_fim)->format('d/m/Y') }}</td>
                    <td><span class="badge badge-danger">Expirado</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(empty($dados['cuponsMaisUsados']) && empty($dados['cuponsExpirados']))
<div class="no-data">
    Nenhum dado disponível para o período selecionado.
</div>
@endif
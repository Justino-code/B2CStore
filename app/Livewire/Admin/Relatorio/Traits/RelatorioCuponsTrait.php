<?php

namespace App\Livewire\Admin\Relatorio\Traits;

use App\Models\Cupom;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait RelatorioCuponsTrait
{
    private function carregarRelatorioCupons($dataInicio, $dataFim)
    {
        // Cupons mais usados
        $cuponsMaisUsados = DB::table('pedidos')
            ->join('cupons', 'pedidos.id_cupom', '=', 'cupons.id_cupom')
            ->whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
            ->whereNotNull('pedidos.id_cupom')
            ->when($this->clienteId, function ($query) {
                $query->where('pedidos.id_usuario', $this->clienteId);
            })
            ->select(
                'cupons.id_cupom',
                'cupons.codigo',
                'cupons.tipo_desconto',
                'cupons.valor_desconto',
                'cupons.ativo',
                DB::raw('COUNT(pedidos.id_pedido) as usos'),
                DB::raw('SUM(pedidos.valor_desconto) as total_descontado'),
                DB::raw('SUM(pedidos.total) as valor_total_vendas')
            )
            ->groupBy('cupons.id_cupom', 'cupons.codigo', 'cupons.tipo_desconto', 'cupons.valor_desconto', 'cupons.ativo')
            ->orderByDesc('usos')
            ->get();

        // Eficácia dos cupons
        $totalPedidos = Pedido::whereBetween('created_at', [$dataInicio, $dataFim])->count();
        $pedidosComCupom = Pedido::whereBetween('created_at', [$dataInicio, $dataFim])
            ->whereNotNull('id_cupom')
            ->count();
        
        $taxaUtilizacao = $totalPedidos > 0 ? ($pedidosComCupom / $totalPedidos * 100) : 0;

        // Valor médio de pedidos com e sem cupom
        $valorMedioComCupom = Pedido::whereBetween('created_at', [$dataInicio, $dataFim])
            ->whereNotNull('id_cupom')
            ->where('status', 'entregue')
            ->avg('total');

        $valorMedioSemCupom = Pedido::whereBetween('created_at', [$dataInicio, $dataFim])
            ->whereNull('id_cupom')
            ->where('status', 'entregue')
            ->avg('total');

        // Cupons expirados ainda ativos
        $cuponsExpirados = Cupom::where('ativo', true)
            ->where('validade_fim', '<', now())
            ->orderBy('validade_fim', 'desc')
            ->limit(10)
            ->get();

        $this->dadosCupons = [
            'cuponsMaisUsados' => $cuponsMaisUsados,
            'estatisticas' => [
                'totalPedidos' => $totalPedidos,
                'pedidosComCupom' => $pedidosComCupom,
                'taxaUtilizacao' => $taxaUtilizacao,
                'valorMedioComCupom' => $valorMedioComCupom ?? 0,
                'valorMedioSemCupom' => $valorMedioSemCupom ?? 0,
            ],
            'cuponsExpirados' => $cuponsExpirados,
        ];
    }
}
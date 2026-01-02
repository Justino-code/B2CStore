<?php

namespace App\Livewire\Admin\Relatorio\Traits;

use App\Models\Usuario as User;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait RelatorioClientesTrait
{
    private function carregarRelatorioClientes($dataInicio, $dataFim)
    {
        // Total de clientes
        $totalClientes = User::where('role', 'cliente')->count();
        $novosClientes = User::where('role', 'cliente')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->count();

        // Clientes mais ativos
        $clientesMaisAtivos = Pedido::whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
            ->where('pedidos.status', 'entregue')
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id_usuario')
            ->when($this->clienteId, function ($query) {
                $query->where('usuarios.id_usuario', $this->clienteId);
            })
            ->select(
                'usuarios.id_usuario',
                'usuarios.nome',
                'usuarios.email',
                DB::raw('COUNT(pedidos.id_pedido) as total_pedidos'),
                DB::raw('SUM(pedidos.total) as valor_total'),
                DB::raw('MAX(pedidos.created_at) as ultima_compra')
            )
            ->groupBy('usuarios.id_usuario', 'usuarios.nome', 'usuarios.email')
            ->orderByDesc('valor_total')
            ->limit(15)
            ->get();

        // Clientes inativos (sem compras nos últimos 90 dias)
        $dataLimiteInativo = Carbon::now()->subDays(90);
        $clientesInativos = User::where('role', 'cliente')
            ->when($this->clienteId, function ($query) {
                $query->where('id_usuario', $this->clienteId);
            })
            ->whereNotIn('id_usuario', function ($query) use ($dataLimiteInativo) {
                $query->select('id_usuario')
                    ->from('pedidos')
                    ->where('created_at', '>=', $dataLimiteInativo);
            })
            ->withCount(['pedidos as total_pedidos'])
            ->orderBy('nome')
            ->limit(15)
            ->get(['id_usuario', 'nome', 'email', 'created_at']);

        // Distribuição geográfica
        $distribuicaoGeografica = Pedido::whereBetween('created_at', [$dataInicio, $dataFim])
            ->whereNotNull('endereco_entrega')
            ->when($this->clienteId, function ($query) {
                $query->where('id_usuario', $this->clienteId);
            })
            ->select('endereco_entrega')
            ->get()
            ->map(function ($pedido) {
                // Extrair cidade do endereço
                $endereco = $pedido->endereco_entrega;
                $linhas = explode("\n", $endereco);
                return count($linhas) >= 3 ? trim($linhas[count($linhas) - 2]) : 'Desconhecida';
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        $this->dadosClientes = [
            'totais' => [
                'totalClientes' => $totalClientes,
                'novosClientes' => $novosClientes,
            ],
            'clientesMaisAtivos' => $clientesMaisAtivos,
            'clientesInativos' => $clientesInativos,
            'distribuicaoGeografica' => $distribuicaoGeografica,
        ];
    }
}
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RelatorioVendasExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    protected $dados;
    protected $titulo;
    protected $periodo;

    public function __construct(array $dados, string $titulo, array $periodo)
    {
        $this->dados = $dados;
        $this->titulo = $titulo;
        $this->periodo = $periodo;
    }

    public function array(): array
    {
        $data = [];
        
        // Cabeçalho do relatório
        $data[] = ['RELATÓRIO DE VENDAS'];
        $data[] = ['Período:', $this->periodo['inicio'] . ' até ' . $this->periodo['fim']];
        $data[] = ['Data de geração:', now()->format('d/m/Y H:i:s')];
        $data[] = [];
        
        // Totais
        $data[] = ['TOTAIS'];
        $data[] = ['Total de Vendas:', 'Kz ' . number_format($this->dados['totais']['vendas'] ?? 0, 2, ',', '.')];
        $data[] = ['Total de Pedidos:', $this->dados['totais']['pedidos'] ?? 0];
        $data[] = ['Pedidos Entregues:', $this->dados['totais']['entregues'] ?? 0];
        $data[] = ['Ticket Médio:', 'Kz ' . number_format($this->dados['totais']['ticketMedio'] ?? 0, 2, ',', '.')];
        $data[] = [];
        
        // Vendas por Status
        if (!empty($this->dados['porStatus'])) {
            $data[] = ['VENDAS POR STATUS'];
            $data[] = ['Status', 'Pedidos', 'Valor Total', 'Percentual'];
            
            $totalPedidos = $this->dados['totais']['pedidos'] ?? 0;
            foreach ($this->dados['porStatus'] as $status => $dados) {
                $percentual = $totalPedidos > 0 ? ($dados['total'] / $totalPedidos * 100) : 0;
                $data[] = [
                    ucfirst($status),
                    $dados['total'],
                    'Kz ' . number_format($dados['valor'] ?? 0, 2, ',', '.'),
                    number_format($percentual, 1) . '%'
                ];
            }
            $data[] = [];
        }
        
        // Vendas por Dia
        if (!empty($this->dados['porDia'])) {
            $data[] = ['VENDAS POR DIA'];
            $data[] = ['Data', 'Pedidos', 'Valor Total'];
            
            foreach ($this->dados['porDia'] as $item) {
                $data[] = [
                    \Carbon\Carbon::parse($item->data)->format('d/m/Y'),
                    $item->pedidos,
                    'Kz ' . number_format($item->total, 2, ',', '.')
                ];
            }
            $data[] = [];
        }
        
        // Métodos de Pagamento
        if (!empty($this->dados['metodosPagamento'])) {
            $data[] = ['MÉTODOS DE PAGAMENTO'];
            $data[] = ['Método', 'Pedidos', 'Percentual'];
            
            foreach ($this->dados['metodosPagamento'] as $metodo) {
                $percentual = $this->dados['totais']['pedidos'] > 0 ? 
                    ($metodo->total / $this->dados['totais']['pedidos'] * 100) : 0;
                $data[] = [
                    ucfirst($metodo->metodo),
                    $metodo->total,
                    number_format($percentual, 1) . '%'
                ];
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Relatório de Vendas';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            5 => ['font' => ['bold' => true]],
            9 => ['font' => ['bold' => true]],
        ];
    }
}
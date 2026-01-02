<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RelatorioClientesExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
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
        $data[] = ['RELATÓRIO DE CLIENTES'];
        $data[] = ['Período:', $this->periodo['inicio'] . ' até ' . $this->periodo['fim']];
        $data[] = ['Data de geração:', now()->format('d/m/Y H:i:s')];
        $data[] = [];
        
        // Totais
        $data[] = ['TOTAIS'];
        $data[] = ['Total de Clientes:', $this->dados['totais']['totalClientes'] ?? 0];
        $data[] = ['Novos Clientes (período):', $this->dados['totais']['novosClientes'] ?? 0];
        $data[] = [];
        
        // Clientes Mais Ativos
        if (!empty($this->dados['clientesMaisAtivos'])) {
            $data[] = ['CLIENTES MAIS ATIVOS'];
            $data[] = ['Cliente', 'Email', 'Pedidos', 'Valor Total', 'Ticket Médio', 'Última Compra'];
            
            foreach ($this->dados['clientesMaisAtivos'] as $cliente) {
                $ticketMedio = $cliente->total_pedidos > 0 ? 
                    $cliente->valor_total / $cliente->total_pedidos : 0;
                
                $data[] = [
                    $cliente->nome,
                    $cliente->email,
                    $cliente->total_pedidos,
                    'Kz ' . number_format($cliente->valor_total, 2, ',', '.'),
                    'Kz ' . number_format($ticketMedio, 2, ',', '.'),
                    $cliente->ultima_compra ? \Carbon\Carbon::parse($cliente->ultima_compra)->format('d/m/Y') : 'N/A'
                ];
            }
            $data[] = [];
        }
        
        // Clientes Inativos
        if (!empty($this->dados['clientesInativos'])) {
            $data[] = ['CLIENTES INATIVOS (últimos 90 dias)'];
            $data[] = ['Cliente', 'Email', 'Total de Pedidos', 'Data de Cadastro'];
            
            foreach ($this->dados['clientesInativos'] as $cliente) {
                $data[] = [
                    $cliente->nome,
                    $cliente->email,
                    $cliente->total_pedidos,
                    \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y')
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
        return 'Relatório de Clientes';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            5 => ['font' => ['bold' => true]],
            9 => ['font' => ['bold' => true]],
            13 => ['font' => ['bold' => true]],
        ];
    }
}
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RelatorioCuponsExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
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
        $data[] = ['RELATÓRIO DE CUPONS'];
        $data[] = ['Período:', $this->periodo['inicio'] . ' até ' . $this->periodo['fim']];
        $data[] = ['Data de geração:', now()->format('d/m/Y H:i:s')];
        $data[] = [];
        
        // Estatísticas
        $data[] = ['ESTATÍSTICAS'];
        $data[] = ['Total de Pedidos:', $this->dados['estatisticas']['totalPedidos'] ?? 0];
        $data[] = ['Pedidos com Cupom:', $this->dados['estatisticas']['pedidosComCupom'] ?? 0];
        $data[] = ['Taxa de Utilização:', number_format($this->dados['estatisticas']['taxaUtilizacao'] ?? 0, 1) . '%'];
        $data[] = ['Ticket Médio com Cupom:', 'Kz ' . number_format($this->dados['estatisticas']['valorMedioComCupom'] ?? 0, 2, ',', '.')];
        $data[] = ['Ticket Médio sem Cupom:', 'Kz ' . number_format($this->dados['estatisticas']['valorMedioSemCupom'] ?? 0, 2, ',', '.')];
        
        $diferenca = ($this->dados['estatisticas']['valorMedioComCupom'] ?? 0) - ($this->dados['estatisticas']['valorMedioSemCupom'] ?? 0);
        $data[] = ['Diferença:', ($diferenca >= 0 ? '+' : '') . 'Kz ' . number_format($diferenca, 2, ',', '.')];
        $data[] = [];
        
        // Cupons Mais Usados
        if (!empty($this->dados['cuponsMaisUsados'])) {
            $data[] = ['CUPONS MAIS USADOS'];
            $data[] = ['Código', 'Tipo', 'Desconto', 'Usos', 'Total Descontado', 'Valor Total Vendas', 'Status'];
            
            foreach ($this->dados['cuponsMaisUsados'] as $cupom) {
                $desconto = $cupom->tipo_desconto == 'percentual' ? 
                    $cupom->valor_desconto . '%' : 
                    'Kz ' . number_format($cupom->valor_desconto, 2, ',', '.');
                
                $data[] = [
                    $cupom->codigo,
                    $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Fixo',
                    $desconto,
                    $cupom->usos,
                    'Kz ' . number_format($cupom->total_descontado, 2, ',', '.'),
                    'Kz ' . number_format($cupom->valor_total_vendas, 2, ',', '.'),
                    $cupom->ativo ? 'Ativo' : 'Inativo'
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
        return 'Relatório de Cupons';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            5 => ['font' => ['bold' => true]],
            13 => ['font' => ['bold' => true]],
        ];
    }
}
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RelatorioCategoriasExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
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
        $data[] = ['RELATÓRIO DE CATEGORIAS'];
        $data[] = ['Período:', $this->periodo['inicio'] . ' até ' . $this->periodo['fim']];
        $data[] = ['Data de geração:', now()->format('d/m/Y H:i:s')];
        $data[] = [];
        
        // Desempenho por Categoria
        if (!empty($this->dados['desempenhoCategorias'])) {
            $data[] = ['DESEMPENHO POR CATEGORIA'];
            $data[] = ['Categoria', 'Status', 'Pedidos', 'Produtos Vendidos', 'Quantidade Total', 'Valor Total', 'Preço Médio'];
            
            foreach ($this->dados['desempenhoCategorias'] as $categoria) {
                $data[] = [
                    $categoria->nome,
                    $categoria->ativo ? 'Ativa' : 'Inativa',
                    $categoria->pedidos,
                    $categoria->produtos_vendidos,
                    $categoria->quantidade_total,
                    'Kz ' . number_format($categoria->valor_total, 2, ',', '.'),
                    'Kz ' . number_format($categoria->preco_medio, 2, ',', '.')
                ];
            }
            $data[] = [];
        }
        
        // Categorias sem Vendas
        if (!empty($this->dados['categoriasSemVendas'])) {
            $data[] = ['CATEGORIAS SEM VENDAS (no período)'];
            $data[] = ['Categoria', 'Total de Produtos', 'Status'];
            
            foreach ($this->dados['categoriasSemVendas'] as $categoria) {
                $data[] = [
                    $categoria->nome,
                    $categoria->produtos_count,
                    $categoria->ativo ? 'Ativa' : 'Inativa'
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
        return 'Relatório de Categorias';
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
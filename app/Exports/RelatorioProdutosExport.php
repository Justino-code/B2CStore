<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RelatorioProdutosExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
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
        $data[] = ['RELATÓRIO DE PRODUTOS'];
        $data[] = ['Período:', $this->periodo['inicio'] . ' até ' . $this->periodo['fim']];
        $data[] = ['Data de geração:', now()->format('d/m/Y H:i:s')];
        $data[] = [];
        
        // Produtos Mais Vendidos
        if (!empty($this->dados['produtosMaisVendidos'])) {
            $data[] = ['PRODUTOS MAIS VENDIDOS'];
            $data[] = ['Produto', 'SKU', 'Quantidade Vendida', 'Valor Total', 'Preço Médio'];
            
            foreach ($this->dados['produtosMaisVendidos'] as $produto) {
                $data[] = [
                    $produto->nome,
                    $produto->sku,
                    $produto->quantidade_vendida,
                    'Kz ' . number_format($produto->valor_total, 2, ',', '.'),
                    'Kz ' . number_format($produto->preco_medio_vendido, 2, ',', '.')
                ];
            }
            $data[] = [];
        }
        
        // Produtos com Estoque Baixo
        if (!empty($this->dados['estoqueBaixo'])) {
            $data[] = ['PRODUTOS COM ESTOQUE BAIXO (< 10 unidades)'];
            $data[] = ['Produto', 'SKU', 'Estoque', 'Preço', 'Valor do Estoque', 'Status'];
            
            foreach ($this->dados['estoqueBaixo'] as $produto) {
                $status = match(true) {
                    $produto->estoque < 3 => 'Crítico',
                    $produto->estoque < 5 => 'Baixo',
                    default => 'Atenção'
                };
                
                $data[] = [
                    $produto->nome,
                    $produto->sku,
                    $produto->estoque,
                    'Kz ' . number_format($produto->preco, 2, ',', '.'),
                    'Kz ' . number_format($produto->preco * $produto->estoque, 2, ',', '.'),
                    $status
                ];
            }
            $data[] = [];
        }
        
        // Desempenho por Categoria
        if (!empty($this->dados['desempenhoCategorias'])) {
            $data[] = ['DESEMPENHO POR CATEGORIA'];
            $data[] = ['Categoria', 'Pedidos', 'Produtos Vendidos', 'Valor Total'];
            
            foreach ($this->dados['desempenhoCategorias'] as $categoria) {
                $data[] = [
                    $categoria->nome,
                    $categoria->pedidos,
                    $categoria->produtos_vendidos,
                    'Kz ' . number_format($categoria->valor_total, 2, ',', '.')
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
        return 'Relatório de Produtos';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            5 => ['font' => ['bold' => true]],
            8 => ['font' => ['bold' => true]],
            13 => ['font' => ['bold' => true]],
        ];
    }
}
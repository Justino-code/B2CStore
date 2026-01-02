<?php

namespace App\Livewire\Admin\Produto;

use Livewire\Component;
use App\Models\Produto;
use App\Models\PedidoItem;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    public $produto;
    public $produtoId;
    public $vendasUltimos30Dias = 0;
    public $estoqueHistorico = [];

    public function mount($id)
    {
        $this->produtoId = $id;
        $this->carregarProduto();
        $this->carregarEstatisticas();
    }

    public function carregarProduto()
    {
        $this->produto = Produto::with(['categoria', 'imagens', 'reviews' => function($query) {
            $query->where('aprovado', true)->with('usuario');
        }])->findOrFail($this->produtoId);
    }

    public function carregarEstatisticas()
    {
        // Vendas dos últimos 30 dias
        $dataLimite = now()->subDays(30);
        
        $this->vendasUltimos30Dias = PedidoItem::where('id_produto', $this->produtoId)
            ->whereHas('pedido', function($query) use ($dataLimite) {
                $query->where('created_at', '>=', $dataLimite)
                      ->where('status', 'entregue');
            })
            ->sum('quantidade');

        // Histórico de estoque (simulado - você pode ajustar conforme seu sistema)
        $this->estoqueHistorico = [
            ['data' => now()->subDays(30)->format('d/m'), 'estoque' => $this->produto->estoque + 50],
            ['data' => now()->subDays(20)->format('d/m'), 'estoque' => $this->produto->estoque + 20],
            ['data' => now()->subDays(10)->format('d/m'), 'estoque' => $this->produto->estoque + 5],
            ['data' => now()->format('d/m'), 'estoque' => $this->produto->estoque],
        ];
    }

    #[On('delete-product-confirmed')]
    public function deletarProduto()
    {
        try {
            // Deletar imagens
            foreach ($this->produto->imagens as $imagem) {
                if (Storage::exists($imagem->url_imagem)) {
                    Storage::delete($imagem->url_imagem);
                }
                $imagem->delete();
            }

            // Deletar produto
            $this->produto->delete();

            $this->dispatch('notify', 
                type: 'success',
                message: 'Produto deletado com sucesso!'
            );
            
            return redirect()->route('admin.produtos.index');

        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Erro ao deletar produto.'
            );
        }
    }

    public function toggleStatus()
    {
        $this->produto->update(['ativo' => !$this->produto->ativo]);
        $this->carregarProduto();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Status do produto atualizado!'
        );
    }

    public function toggleDestaque()
    {
        $this->produto->update(['destaque' => !$this->produto->destaque]);
        $this->carregarProduto();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Status de destaque atualizado!'
        );
    }

    public function render()
    {
        return view('livewire.admin.produto.show');
    }
}
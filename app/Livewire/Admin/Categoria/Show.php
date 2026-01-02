<?php

namespace App\Livewire\Admin\Categoria;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    use WithPagination;

    public $categoria;
    public $categoriaId;
    public $filtroProdutos = 'todos'; // todos, ativos, inativos
    public $sortField = 'nome';
    public $sortDirection = 'asc';

    public function mount($id)
    {
        $this->categoriaId = $id;
        $this->carregarCategoria();
    }

    public function carregarCategoria()
    {
        $this->categoria = Categoria::findOrFail($this->categoriaId);
    }

    public function toggleStatus()
    {
        $this->categoria->update(['ativo' => !$this->categoria->ativo]);
        $this->carregarCategoria();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Status da categoria atualizado!'
        );
    }

    #[On('delete-category-confirmed')]
    public function deletarCategoria()
    {
        try {
            // Verificar se há produtos associados
            $produtosCount = Produto::where('id_categoria', $this->categoriaId)->count();
            
            if ($produtosCount > 0) {
                $this->dispatch('notify', 
                    type: 'error',
                    message: "Esta categoria possui {$produtosCount} produto(s) associado(s). Não é possível deletar."
                );
                return;
            }

            // Deletar imagem se existir
            if ($this->categoria->imagem_url && Storage::exists($this->categoria->imagem_url)) {
                Storage::delete($this->categoria->imagem_url);
            }

            $this->categoria->delete();

            $this->dispatch('notify', 
                type: 'success',
                message: 'Categoria deletada com sucesso!'
            );
            
            return redirect()->route('admin.categorias.index');

        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Erro ao deletar categoria: ' . $e->getMessage()
            );
        }
    }

    public function getProdutosProperty()
    {
        return Produto::where('id_categoria', $this->categoriaId)
            ->when($this->filtroProdutos === 'ativos', function ($query) {
                $query->where('ativo', true);
            })
            ->when($this->filtroProdutos === 'inativos', function ($query) {
                $query->where('ativo', false);
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->with(['imagens'])
            ->paginate(10);
    }

    public function getEstatisticasProperty()
    {
        $totalProdutos = Produto::where('id_categoria', $this->categoriaId)->count();
        $produtosAtivos = Produto::where('id_categoria', $this->categoriaId)
            ->where('ativo', true)
            ->count();
        $produtosDestaque = Produto::where('id_categoria', $this->categoriaId)
            ->where('destaque', true)
            ->where('ativo', true)
            ->count();
        $valorTotalEstoque = Produto::where('id_categoria', $this->categoriaId)
            ->sum(DB::raw('preco * estoque'));

        return [
            'totalProdutos' => $totalProdutos,
            'produtosAtivos' => $produtosAtivos,
            'produtosDestaque' => $produtosDestaque,
            'valorTotalEstoque' => $valorTotalEstoque,
        ];
    }

    public function render()
    {
        return view('livewire.admin.categoria.show', [
            'produtos' => $this->produtos,
            'estatisticas' => $this->estatisticas,
        ]);
    }
}
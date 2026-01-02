<?php

namespace App\Livewire\Admin\Produto;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoriaId = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedProducts = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoriaId' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProducts = $this->produtos->pluck('id_produto')->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function atualizarStatus($id, $status)
    {
        $produto = Produto::find($id);
        if ($produto) {
            $produto->update(['ativo' => $status === 'ativo']);
            
            $this->dispatch('notify', 
                type: 'success',
                message: 'Status do produto atualizado com sucesso!'
            );
        }
    }

    public function exportarProdutos()
    {
        $produtos = Produto::whereIn('id_produto', $this->selectedProducts)->get();
        
        $this->dispatch('notify', 
            type: 'info',
            message: 'Exportação iniciada para ' . count($produtos) . ' produtos.'
        );
    }

    public function deletarSelecionados()
    {
        if (empty($this->selectedProducts)) {
            $this->dispatch('notify', 
                type: 'warning',
                message: 'Selecione pelo menos um produto para deletar.'
            );
            return;
        }

        $produtos = Produto::whereIn('id_produto', $this->selectedProducts)->get();
        
        foreach ($produtos as $produto) {
            foreach ($produto->imagens as $imagem) {
                if (Storage::exists($imagem->url_imagem)) {
                    Storage::delete($imagem->url_imagem);
                }
                $imagem->delete();
            }
            $produto->delete();
        }

        $this->selectedProducts = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', 
            type: 'success',
            message: count($produtos) . ' produtos deletados com sucesso!'
        );
    }

    #[On('delete-product-confirmed')]
    public function deletarProduto($id)
    {
        $produto = Produto::find($id);
        if ($produto) {
            foreach ($produto->imagens as $imagem) {
                if (Storage::exists($imagem->url_imagem)) {
                    Storage::delete($imagem->url_imagem);
                }
                $imagem->delete();
            }
            $produto->delete();
            
            $this->dispatch('notify', 
                type: 'success',
                message: 'Produto deletado com sucesso!'
            );
            
            // Remove from selected products if it was selected
            if (($key = array_search($id, $this->selectedProducts)) !== false) {
                unset($this->selectedProducts[$key]);
                $this->selectedProducts = array_values($this->selectedProducts);
            }
        }
    }

    public function getProdutosProperty()
    {
        return Produto::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoriaId, function ($query) {
                $query->where('id_categoria', $this->categoriaId);
            })
            ->when($this->status !== '', function ($query) {
                $query->where('ativo', $this->status === 'ativo');
            })
            ->with(['categoria', 'imagens'])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function render()
    {
        $categorias = Categoria::where('ativo', true)->orderBy('nome')->get();

        return view('livewire.admin.produto.index', [
            'produtos' => $this->produtos,
            'categorias' => $categorias,
        ]);
    }
}
<?php

namespace App\Livewire\Admin\Categoria;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortField = 'ordem';
    public $sortDirection = 'asc';
    public $selectedCategorias = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'ordem'],
        'sortDirection' => ['except' => 'asc'],
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
            $this->selectedCategorias = $this->categorias->pluck('id_categoria')->toArray();
        } else {
            $this->selectedCategorias = [];
        }
    }

    public function atualizarStatus($id, $status)
    {
        $categoria = Categoria::find($id);
        if ($categoria) {
            $categoria->update(['ativo' => $status === 'ativo']);
            
            $this->dispatch('notify', 
                type: 'success',
                message: 'Status da categoria atualizado com sucesso!'
            );
        }
    }

    public function atualizarOrdem($id, $direcao)
    {
        $categoria = Categoria::find($id);
        $categoriaAtual = $categoria->ordem;

        if ($direcao === 'up' && $categoriaAtual > 1) {
            // Trocar com categoria acima
            $categoriaAcima = Categoria::where('ordem', $categoriaAtual - 1)->first();
            if ($categoriaAcima) {
                $categoriaAcima->update(['ordem' => $categoriaAtual]);
                $categoria->update(['ordem' => $categoriaAtual - 1]);
                
                $this->dispatch('notify', 
                    type: 'success',
                    message: 'Ordem da categoria atualizada!'
                );
            }
        } elseif ($direcao === 'down') {
            // Trocar com categoria abaixo
            $categoriaAbaixo = Categoria::where('ordem', $categoriaAtual + 1)->first();
            if ($categoriaAbaixo) {
                $categoriaAbaixo->update(['ordem' => $categoriaAtual]);
                $categoria->update(['ordem' => $categoriaAtual + 1]);
                
                $this->dispatch('notify', 
                    type: 'success',
                    message: 'Ordem da categoria atualizada!'
                );
            }
        }
    }

    #[On('delete-selected-categories-confirmed')]
    public function deletarSelecionados()
    {
        if (empty($this->selectedCategorias)) {
            $this->dispatch('notify', 
                type: 'warning',
                message: 'Selecione pelo menos uma categoria para deletar.'
            );
            return;
        }

        $categorias = Categoria::whereIn('id_categoria', $this->selectedCategorias)->get();
        
        foreach ($categorias as $categoria) {
            // Verificar se há produtos associados
            $produtosCount = Produto::where('id_categoria', $categoria->id_categoria)->count();
            
            if ($produtosCount > 0) {
                $this->dispatch('notify', 
                    type: 'error',
                    message: "A categoria '{$categoria->nome}' possui {$produtosCount} produto(s) associado(s). Não é possível deletar."
                );
                return;
            }

            // Deletar imagem se existir
            if ($categoria->imagem_url && Storage::exists($categoria->imagem_url)) {
                Storage::delete($categoria->imagem_url);
            }

            $categoria->delete();
        }

        $this->selectedCategorias = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', 
            type: 'success',
            message: count($categorias) . ' categoria(s) deletada(s) com sucesso!'
        );
    }

    #[On('delete-category-confirmed')]
    public function deletarCategoria($id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Categoria não encontrada!'
            );
            return;
        }

        // Verificar se há produtos associados
        $produtosCount = Produto::where('id_categoria', $categoria->id_categoria)->count();
        
        if ($produtosCount > 0) {
            $this->dispatch('notify', 
                type: 'error',
                message: "A categoria '{$categoria->nome}' possui {$produtosCount} produto(s) associado(s). Não é possível deletar."
            );
            return;
        }

        // Deletar imagem se existir
        if ($categoria->imagem_url && Storage::exists($categoria->imagem_url)) {
            Storage::delete($categoria->imagem_url);
        }

        $categoria->delete();

        $this->dispatch('notify', 
            type: 'success',
            message: 'Categoria deletada com sucesso!'
        );
    }

    public function getCategoriasProperty()
    {
        return Categoria::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== '', function ($query) {
                $query->where('ativo', $this->status === 'ativo');
            })
            ->withCount('produtos')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getEstatisticasProperty()
    {
        $totalCategorias = Categoria::count();
        $categoriasAtivas = Categoria::where('ativo', true)->count();
        $categoriasComProdutos = Categoria::has('produtos')->count();
        $totalProdutosCategorizados = Produto::whereNotNull('id_categoria')->count();

        return [
            'totalCategorias' => $totalCategorias,
            'categoriasAtivas' => $categoriasAtivas,
            'categoriasComProdutos' => $categoriasComProdutos,
            'totalProdutosCategorizados' => $totalProdutosCategorizados,
        ];
    }

    public function render()
    {
        return view('livewire.admin.categoria.index', [
            'categorias' => $this->categorias,
            'estatisticas' => $this->estatisticas,
        ]);
    }
}
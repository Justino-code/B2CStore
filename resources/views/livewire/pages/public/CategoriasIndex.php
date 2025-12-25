<?php
// app/Livewire/Public/CategoriasIndex.php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Cache;

class CategoriasIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $ordenarPor = 'nome_az';
    public $itensPorPagina = 12;
    public $categoriasAtivas = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'ordenarPor' => ['except' => 'nome_az'],
        'itensPorPagina' => ['except' => 12],
    ];

    public function mount()
    {
        // Carregar todas as categorias ativas com contagem
        $this->categoriasAtivas = Cache::remember('categorias_ativas_com_contagem', 3600, function () {
            return Categoria::withCount(['produtos' => function($query) {
                $query->where('ativo', true)
                      ->where('estoque', '>', 0);
            }])
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();
        });
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'ordenarPor'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Categoria::withCount(['produtos' => function($query) {
            $query->where('ativo', true)
                  ->where('estoque', '>', 0);
        }])
        ->where('ativo', true)
        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('nome', 'like', '%' . $this->search . '%')
                  ->orWhere('descricao', 'like', '%' . $this->search . '%');
            });
        });

        // Aplicar ordenação
        $query = $this->aplicarOrdenacao($query);

        $categorias = $query->paginate($this->itensPorPagina);

        // Carregar produtos em destaque para cada categoria (opcional)
        $categoriasComProdutos = $categorias->map(function ($categoria) {
            $categoria->produtos_destaque = Cache::remember('categoria_destaque_' . $categoria->id_categoria, 300, function () use ($categoria) {
                return Produto::with(['imagens' => function($q) {
                        $q->where('principal', true);
                    }])
                    ->where('id_categoria', $categoria->id_categoria)
                    ->where('ativo', true)
                    ->where('estoque', '>', 0)
                    ->where('destaque', true)
                    ->limit(4)
                    ->get();
            });
            return $categoria;
        });

        return view('livewire.pages.public.categorias-index', [
            'categorias' => $categoriasComProdutos,
            'totalCategorias' => $categorias->total(),
        ]);
    }

    private function aplicarOrdenacao($query)
    {
        return match($this->ordenarPor) {
            'nome_az' => $query->orderBy('nome'),
            'nome_za' => $query->orderBy('nome', 'desc'),
            'mais_produtos' => $query->orderBy('produtos_count', 'desc'),
            'menos_produtos' => $query->orderBy('produtos_count'),
            'ordem_crescente' => $query->orderBy('ordem'),
            'ordem_decrescente' => $query->orderBy('ordem', 'desc'),
            default => $query->orderBy('nome'),
        };
    }

    public function getTotalProdutosPorCategoria($categoriaId)
    {
        return Cache::remember('total_produtos_categoria_' . $categoriaId, 300, function () use ($categoriaId) {
            return Produto::where('id_categoria', $categoriaId)
                ->where('ativo', true)
                ->where('estoque', '>', 0)
                ->count();
        });
    }
}
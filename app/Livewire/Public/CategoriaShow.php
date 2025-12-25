<?php
// app/Livewire/Public/CategoriaShow.php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;
use App\Models\{
    Categoria,
    Produto,
    Marca,
};

class CategoriaShow extends Component
{
    use WithPagination;

    public $categoria;
    public $slug;
    public $search = '';
    public $marcaId = '';
    public $precoMin = 0;
    public $precoMax = 10000;
    public $ordenarPor = 'mais_recentes';
    public $itensPorPagina = 12;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'marcaId' => ['except' => ''],
        'precoMin' => ['except' => 0],
        'precoMax' => ['except' => 10000],
        'ordenarPor' => ['except' => 'mais_recentes'],
        'itensPorPagina' => ['except' => 12],
    ];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->carregarCategoria();
        
        // Buscar preço máximo para esta categoria
        $precoMaximo = Cache::remember('preco_maximo_categoria_' . $this->categoria->id_categoria, 3600, function () {
            return Produto::where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->max('preco') ?? 10000;
        });
        
        $this->precoMax = min($precoMaximo, 10000);
    }

    private function carregarCategoria()
    {
        $this->categoria = Cache::remember('categoria_' . $this->slug, 3600, function () {
            return Categoria::withCount(['produtos' => function($query) {
                $query->ativos()->comEstoque();
            }])
            ->where('slug', $this->slug)
            ->where('ativo', true)
            ->firstOrFail();
        });
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'marcaId', 'precoMin', 'precoMax', 'ordenarPor', 'itensPorPagina'])) {
            $this->resetPage();
        }
    }

    public function limparFiltros()
    {
        $this->search = '';
        $this->marcaId = '';
        $this->precoMin = 0;
        
        // Resetar para o preço máximo real da categoria
        $precoMaximo = Cache::remember('preco_maximo_categoria_' . $this->categoria->id_categoria, 3600, function () {
            return Produto::where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->max('preco') ?? 10000;
        });
        
        $this->precoMax = min($precoMaximo, 10000);
        $this->ordenarPor = 'mais_recentes';
        $this->resetPage();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Filtros limpos com sucesso!'
        );
    }

    public function addToCart($produtoId)
    {
        $this->dispatch('add-to-cart', produtoId: $produtoId);
    }

    public function addToFavorites($produtoId)
    {
        if (auth()->check()) {
            auth()->user()->favoritos()->toggle($produtoId);
            $this->dispatch('notify', 
                type: 'success',
                message: 'Produto atualizado nos favoritos!'
            );
        } else {
            $this->dispatch('notify',
                type: 'warning',
                message: 'Faça login para adicionar aos favoritos!'
            );
        }
    }

    public function render()
    {
        // Buscar marcas disponíveis para esta categoria
        $marcas = Cache::remember('marcas_categoria_' . $this->categoria->id_categoria, 300, function () {
            return Marca::whereHas('produtos', function($query) {
                $query->where('id_categoria', $this->categoria->id_categoria)
                      ->ativos()
                      ->comEstoque();
            })
            ->withCount(['produtos' => function($query) {
                $query->where('id_categoria', $this->categoria->id_categoria)
                      ->ativos()
                      ->comEstoque();
            }])
            ->ativo()
            ->having('produtos_count', '>', 0)
            ->orderBy('nome')
            ->get();
        });

        // Query de produtos
        $query = Produto::where('id_categoria', $this->categoria->id_categoria)
            ->ativos()
            ->comEstoque()
            ->with(['imagens' => function($q) {
                $q->where('principal', true);
            }, 'marca'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->marcaId, function ($query) {
                $query->where('id_marca', $this->marcaId);
            })
            ->whereBetween('preco', [$this->precoMin, $this->precoMax]);

        // Aplicar ordenação
        $query = $this->aplicarOrdenacao($query);

        $produtos = $query->paginate($this->itensPorPagina);

        // Produtos em destaque desta categoria
        $produtosDestaque = Cache::remember('produtos_destaque_categoria_' . $this->categoria->id_categoria, 300, function () {
            return Produto::with(['imagens' => function($q) {
                    $q->where('principal', true);
                }])
                ->where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->comEstoque()
                ->where('destaque', true)
                ->limit(6)
                ->get();
        });

        return view('livewire.pages.public.categoria-show', [
            'produtos' => $produtos,
            'marcas' => $marcas,
            'produtosDestaque' => $produtosDestaque,
            'totalProdutos' => $this->categoria->produtos_count,
            'precoMinimoDisponivel' => Cache::remember('preco_minimo_categoria_' . $this->categoria->id_categoria, 300, function () {
                return Produto::where('id_categoria', $this->categoria->id_categoria)
                    ->ativos()
                    ->comEstoque()
                    ->min('preco') ?? 0;
            }),
            'precoMaximoDisponivel' => $this->precoMax,
        ])
        ->layout('components.layouts.public');
    }

    private function aplicarOrdenacao($query)
    {
        return match($this->ordenarPor) {
            'mais_recentes' => $query->orderBy('created_at', 'desc'),
            'preco_menor' => $query->orderBy('preco'),
            'preco_maior' => $query->orderBy('preco', 'desc'),
            'nome_az' => $query->orderBy('nome'),
            'nome_za' => $query->orderBy('nome', 'desc'),
            'mais_vendidos' => $query->orderBy('vendidos', 'desc'),
            'mais_avaliados' => $query->orderBy('rating_medio', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }
}
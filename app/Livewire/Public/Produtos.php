<?php
// app/Livewire/Public/Produtos.php

namespace App\Livewire\Public;

use Livewire\{
    Component,
    WithPagination
};

use App\Models\{
    Produto,
    Categoria,
    Marca,
};

use App\Traits\{
    HasCartActions,
    HasFavorites,
};

use Illuminate\Support\Facades\Cache;

class Produtos extends Component
{
    use WithPagination, HasCartActions, HasFavorites;

    public $search = '';
    public $categoriaId = '';
    public $marcaId = '';
    public $precoMin = 0;
    public $precoMax = 10000;
    public $ordenarPor = 'mais_recentes';
    public $viewMode = 'grid'; // grid ou list
    public $itensPorPagina = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoriaId' => ['except' => ''],
        'marcaId' => ['except' => ''],
        'precoMin' => ['except' => 0],
        'precoMax' => ['except' => 10000],
        'ordenarPor' => ['except' => 'mais_recentes'],
        'viewMode' => ['except' => 'grid'],
        'itensPorPagina' => ['except' => 12],
    ];

    public function mount()
    {
        // Buscar preço máximo real dos produtos
        $precoMaximo = Cache::remember('preco_maximo_produtos', 3600, function () {
            return Produto::ativos()->max('preco') ?? 10000;
        });

        $this->precoMax = min($precoMaximo, 10000);
    }

    public function updated($property)
    {
        // Resetar para primeira página quando filtrar
        if (in_array($property, ['search', 'categoriaId', 'marcaId', 'precoMin', 'precoMax', 'ordenarPor'])) {
            $this->resetPage();
        }
    }

    public function limparFiltros()
    {
        $this->search = '';
        $this->categoriaId = '';
        $this->marcaId = '';
        $this->precoMin = 0;
        $this->precoMax = 10000;
        $this->ordenarPor = 'mais_recentes';
        $this->resetPage();
    }

    public function render()
    {
        // Buscar filtros disponíveis
        $filtros = $this->getFiltrosDisponiveis();

        // Query principal
        $query = Produto::ativos()
            ->comEstoque()
            ->with(['imagens' => function($q) {
                $q->where('principal', true);
            }, 'categoria', 'marca'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoriaId, function ($query) {
                $query->where('id_categoria', $this->categoriaId);
            })
            ->when($this->marcaId, function ($query) {
                $query->where('id_marca', $this->marcaId);
            })
            ->whereBetween('preco', [$this->precoMin, $this->precoMax]);

        // Aplicar ordenação
        $query = $this->aplicarOrdenacao($query);

        // Paginar resultados
        $produtos = $query->paginate($this->itensPorPagina);

        return view('livewire.pages.public.produtos', [
            'produtos' => $produtos,
            'categorias' => $filtros['categorias'],
            'marcas' => $filtros['marcas'],
            'totalProdutos' => $filtros['total'],
            'precoMinimoDisponivel' => $filtros['preco_min'],
            'precoMaximoDisponivel' => $filtros['preco_max'],
        ])
        ->layout('components.layouts.public');
    }

    private function getFiltrosDisponiveis()
    {
        return Cache::remember('filtros_produtos_' . md5(json_encode([
            $this->search,
            $this->categoriaId,
            $this->marcaId
        ])), 300, function () {

            $queryBase = Produto::ativos()->comEstoque();

            // Aplicar filtros atuais para contagens corretas
            $queryBase->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%');
                });
            });

            return [
                'categorias' => Categoria::withCount(['produtos' => function($query) use ($queryBase) {
                    $query->mergeConstraintsFrom($queryBase);
                }])
                ->ativas()
                ->having('produtos_count', '>', 0)
                ->orderBy('nome')
                ->get(),

                'marcas' => Marca::withCount(['produtos' => function($query) use ($queryBase) {
                    $query->mergeConstraintsFrom($queryBase);
                }])
                ->having('produtos_count', '>', 0)
                ->orderBy('nome')
                ->get(),

                'total' => $queryBase->count(),
                'preco_min' => $queryBase->min('preco') ?? 0,
                'preco_max' => $queryBase->max('preco') ?? 10000,
            ];
        });
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

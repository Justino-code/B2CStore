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

use App\Traits\{
    HasCartActions,
    HasFavorites,
};

class CategoriaShow extends Component
{
    use WithPagination, HasCartActions, HasFavorites;

    public $categoria;
    public $slug;
    public $search = '';
    public $marcaId = '';
    public $precoMin = 0;
    public $precoMax = 10000;
    public $ordenarPor = 'mais_recentes';
    public $itensPorPagina = 12;
    
    // Novas propriedades para o filtro responsivo
    public $mobileFiltersOpen = false;
    public $contadorFiltrosAtivos = 0;
    
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
        try {
             $this->carregarCategoria();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('unauthorized');
        }
        
        // Buscar preço máximo para esta categoria
        $precoMaximo = Cache::remember('preco_maximo_categoria_' . $this->categoria->id_categoria, 3600, function () {
            return Produto::where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->max('preco') ?? 10000;
        });
        
        $this->precoMax = min($precoMaximo, 10000);
        
        // Calcular contador inicial de filtros ativos
        $this->calcularContadorFiltros();
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

    // Computed property para verificar se há filtros ativos
    public function getFiltrosAtivosProperty()
    {
        return $this->search || 
               $this->marcaId || 
               $this->precoMin > 0 || 
               $this->precoMax < $this->getPrecoMaximoDisponivel();
    }

    // Método para calcular o contador de filtros ativos
    private function calcularContadorFiltros()
    {
        $this->contadorFiltrosAtivos = 0;
        
        if ($this->search) {
            $this->contadorFiltrosAtivos++;
        }
        
        if ($this->marcaId) {
            $this->contadorFiltrosAtivos++;
        }
        
        $precoMaximoDisponivel = $this->getPrecoMaximoDisponivel();
        if ($this->precoMin > 0 || $this->precoMax < $precoMaximoDisponivel) {
            $this->contadorFiltrosAtivos++;
        }
    }

    // Método auxiliar para obter o preço máximo disponível
    private function getPrecoMaximoDisponivel()
    {
        return Cache::remember('preco_maximo_categoria_' . $this->categoria->id_categoria, 3600, function () {
            return Produto::where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->comEstoque()
                ->max('preco') ?? 10000;
        });
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'marcaId', 'precoMin', 'precoMax', 'ordenarPor', 'itensPorPagina'])) {
            $this->resetPage();
            
            // Atualizar contador de filtros
            $this->calcularContadorFiltros();
            
            // Fechar filtro móvel após aplicar mudanças
            if ($property !== 'ordenarPor' && $property !== 'itensPorPagina') {
                $this->mobileFiltersOpen = false;
            }
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
        
        // Resetar contador
        $this->contadorFiltrosAtivos = 0;
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Filtros limpos com sucesso!'
        );
    }

    // Método para limpar apenas o filtro de preço
    public function limparPrecoFiltro()
    {
        $precoMaximo = $this->getPrecoMaximoDisponivel();
        $this->precoMin = 0;
        $this->precoMax = $precoMaximo;
        $this->resetPage();
        
        $this->calcularContadorFiltros();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Filtro de preço removido!'
        );
    }

    // Método para alternar o filtro móvel
    public function toggleMobileFilters()
    {
        $this->mobileFiltersOpen = !$this->mobileFiltersOpen;
    }

    // Método para aplicar filtros no mobile
    public function aplicarFiltrosMobile()
    {
        $this->mobileFiltersOpen = false;
        $this->calcularContadorFiltros();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Filtros aplicados!'
        );
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

        // Calcular preço mínimo disponível
        $precoMinimoDisponivel = Cache::remember('preco_minimo_categoria_' . $this->categoria->id_categoria, 300, function () {
            return Produto::where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->comEstoque()
                ->min('preco') ?? 0;
        });

        // Calcular preço máximo disponível
        $precoMaximoDisponivel = Cache::remember('preco_maximo_categoria_' . $this->categoria->id_categoria, 300, function () {
            return Produto::where('id_categoria', $this->categoria->id_categoria)
                ->ativos()
                ->comEstoque()
                ->max('preco') ?? 10000;
        });

        return view('livewire.pages.public.categoria-show', [
            'produtos' => $produtos,
            'marcas' => $marcas,
            'produtosDestaque' => $produtosDestaque,
            'totalProdutos' => $this->categoria->produtos_count,
            'precoMinimoDisponivel' => $precoMinimoDisponivel,
            'precoMaximoDisponivel' => $precoMaximoDisponivel,
            'filtrosAtivos' => $this->filtrosAtivos,
            'contadorFiltrosAtivos' => $this->contadorFiltrosAtivos,
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
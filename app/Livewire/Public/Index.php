<?php
namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\{
    Categoria,
    Produto,
    Banner,
    Review,
    Usuario,
};

use App\Traits\{
    HasCartActions,
    HasFavorites,
};

use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    use HasCartActions, HasFavorites;

    public function clientesSatisfeitos(){
        $totalClientes = Usuario::where('role', 'cliente')->count();
        $totalReviews = Review::count();

        $reviewsPositivas = Review::where('rating', '>=', 3)->count();

        if ($totalReviews > 0) {
            $taxaSatisfacao = $reviewsPositivas / $totalReviews;
        } else {
            $taxaSatisfacao = 0;
        }
        
        $clientesSatisfeitosEstimados = $totalClientes * $taxaSatisfacao;

        return $clientesSatisfeitosEstimados;
    }

    public function estrelas(){
        $totalReviews = Review::count();
        
        if ($totalReviews > 0) {
            $mediaEstrelas = Review::avg('rating');
        } else {
            $mediaEstrelas = 0;
        }

        return $mediaEstrelas;

    }

    public function render()
    {
        // Buscar dados com cache para performance
        $dados = Cache::remember('homepage_data', 3600, function () {
            return [
                'banners' => Banner::ativo()->orderBy('ordem')->get(),
                'categorias' => Categoria::withCount(['produtos' => function($query) {
                    $query->where('ativo', true);
                }])
                ->where('ativo', true)
                ->orderBy('ordem')
                ->limit(8)
                ->get(),
                'destaques' => Produto::where('destaque', true)
                    ->where('ativo', true)
                    ->with(['imagens' => function($q) {
                        $q->where('principal', true);
                    }])
                    ->limit(8)
                    ->get(),
                'promocoes' => Produto::whereNotNull('preco_promocional')
                    ->where('ativo', true)
                    ->with(['imagens' => function($q) {
                        $q->where('principal', true);
                    }])
                    ->limit(8)
                    ->get(),
                'novidades' => Produto::where('ativo', true)
                    ->with(['imagens' => function($q) {
                        $q->where('principal', true);
                    }])
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get(),
                
                'clientesSatisfeitos' => $this->clientesSatisfeitos(),
                'estrelas' => $this->estrelas(),
            ];
        });

        return view('livewire.pages.public.index', $dados)
        ->layout('components.layouts.public');
    }
}
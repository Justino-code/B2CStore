<?php
namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Banner;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
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
            ];
        });

        return view('livewire.pages.public.index', $dados)
        ->layout('components.layouts.public');
    }
}
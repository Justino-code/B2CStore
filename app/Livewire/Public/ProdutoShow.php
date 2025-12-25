<?php
// app/Livewire/Public/ProdutoShow.php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Produto;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public')]
class ProdutoShow extends Component
{
    public $produto;
    public $slug;
    public $quantidade = 1;
    public $imagemSelecionada;
    public $variacaoSelecionada = null;
    public $reviews;
    public $ratingMedio = 0;
    public $totalReviews = 0;
    public $reviewsStats = [];
    public $showReviewModal = false;
    public $produtosRelacionados = [];
    
    // Review form - apenas para usuários logados
    public $reviewRating = 5;
    public $reviewComentario = '';

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->carregarProduto();
        $this->carregarReviews();
        $this->carregarProdutosRelacionados();
        
        if ($this->produto->imagens->isNotEmpty()) {
            $this->imagemSelecionada = $this->produto->imagens->first()->url_imagem;
        }
    }

    private function carregarProduto()
    {
        $cacheKey = 'produto_' . $this->slug;
        
        $this->produto = Cache::remember($cacheKey, 3600, function () {
            return Produto::with([
                'categoria',
                'marca',
                'imagens' => function($query) {
                    $query->orderBy('principal', 'desc')
                          ->orderBy('ordem');
                }
            ])
            ->where('slug', $this->slug)
            ->where('ativo', true)
            ->firstOrFail();
        });
    }

    private function carregarReviews()
    {
        $cacheKey = 'reviews_produto_' . $this->produto->id_produto;
        
        $this->reviews = Cache::remember($cacheKey, 300, function () {
            return Review::with(['usuario' => function($query) {
                    $query->select('id_usuario', 'nome', 'email', 'avatar_url');
                }])
                ->where('id_produto', $this->produto->id_produto)
                ->where('aprovado', true)
                ->orderBy('created_at', 'desc')
                ->limit(15)
                ->get();
        });

        $this->totalReviews = Review::where('id_produto', $this->produto->id_produto)
            ->where('aprovado', true)
            ->count();
        
        $this->ratingMedio = Review::where('id_produto', $this->produto->id_produto)
            ->where('aprovado', true)
            ->avg('rating') ?? 0;
            
        $this->calcularStatsReviews();
    }

    private function calcularStatsReviews()
    {
        $this->reviewsStats = [
            'total' => $this->totalReviews,
            'positivas' => $this->reviews->where('rating', '>=', 4)->count(),
            'neutras' => $this->reviews->where('rating', 3)->count(),
            'negativas' => $this->reviews->where('rating', '<=', 2)->count(),
            'distribuicao' => []
        ];

        for ($rating = 5; $rating >= 1; $rating--) {
            $count = $this->reviews->where('rating', $rating)->count();
            $percentage = $this->totalReviews > 0 ? ($count / $this->totalReviews) * 100 : 0;
            
            $this->reviewsStats['distribuicao'][] = [
                'rating' => $rating,
                'count' => $count,
                'percentage' => $percentage
            ];
        }
    }

    private function carregarProdutosRelacionados()
    {
        $cacheKey = 'produtos_relacionados_' . $this->produto->id_produto;
        
        $this->produtosRelacionados = Cache::remember($cacheKey, 300, function () {
            return Produto::with(['imagens' => function($q) {
                    $q->where('principal', true);
                }])
                ->where('id_categoria', $this->produto->id_categoria)
                ->where('id_produto', '!=', $this->produto->id_produto)
                ->where('ativo', true)
                ->where('estoque', '>', 0)
                ->inRandomOrder()
                ->limit(8)
                ->get();
        });
    }

    public function incrementarQuantidade()
    {
        if ($this->quantidade < $this->produto->estoque) {
            $this->quantidade++;
        }
    }

    public function decrementarQuantidade()
    {
        if ($this->quantidade > 1) {
            $this->quantidade--;
        }
    }

    public function selecionarImagem($urlImagem)
    {
        $this->imagemSelecionada = $urlImagem;
    }

    public function selecionarVariacao($variacao)
    {
        $this->variacaoSelecionada = $variacao;
    }

    public function addToCart()
    {
        if ($this->produto->estoque <= 0) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Este produto está esgotado.'
            );
            return;
        }

        if ($this->quantidade > $this->produto->estoque) {
            $this->dispatch('notify', 
                type: 'warning',
                message: 'Quantidade solicitada excede o estoque disponível.'
            );
            return;
        }

        $this->dispatch('add-to-cart', 
            produtoId: $this->produto->id_produto,
            quantidade: $this->quantidade,
            variacao: $this->variacaoSelecionada
        );

        $this->dispatch('notify', 
            type: 'success',
            message: 'Produto adicionado ao carrinho!'
        );
    }

    public function addToFavorites()
    {
        if (auth()->check()) {
            auth()->user()->favoritos()->toggle($this->produto->id_produto);
            
            $isFavorito = auth()->user()->favoritos->contains($this->produto->id_produto);
            $mensagem = $isFavorito ? 'Produto adicionado aos favoritos!' : 'Produto removido dos favoritos!';
            
            $this->dispatch('notify', 
                type: 'success',
                message: $mensagem
            );
        } else {
            $this->dispatch('notify',
                type: 'warning',
                message: 'Faça login para adicionar aos favoritos!'
            );
        }
    }

    public function openReviewModal()
    {
        if (!auth()->check()) {
            $this->dispatch('notify',
                type: 'warning',
                message: 'Faça login para avaliar produtos!'
            );
            return;
        }
        
        $this->showReviewModal = true;
    }

    public function submitReview()
    {
        // Verifica se o usuário está logado
        if (!auth()->check()) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Você precisa estar logado para enviar uma avaliação.'
            );
            return;
        }

        $this->validate([
            'reviewRating' => 'required|integer|min:1|max:5',
            'reviewComentario' => 'required|string|min:10|max:1000',
        ]);

        $reviewData = [
            'id_produto' => $this->produto->id_produto,
            'id_usuario' => auth()->id(),
            'rating' => $this->reviewRating,
            'comentario' => $this->reviewComentario,
            'aprovado' => false,
        ];

        Review::create($reviewData);

        Cache::forget('reviews_produto_' . $this->produto->id_produto);

        $this->resetReviewForm();

        $this->dispatch('notify', 
            type: 'success',
            message: 'Avaliação enviada com sucesso! Ela será publicada após aprovação.'
        );

        $this->carregarReviews();
    }

    private function resetReviewForm()
    {
        $this->reviewRating = 5;
        $this->reviewComentario = '';
        $this->showReviewModal = false;
    }

    public function render()
    {
        return view('livewire.pages.public.produto-show', [
            'produto' => $this->produto,
            'reviews' => $this->reviews,
            'produtosRelacionados' => $this->produtosRelacionados,
            'ratingMedio' => $this->ratingMedio,
            'totalReviews' => $this->totalReviews,
            'reviewsStats' => $this->reviewsStats,
        ]);
    }
}
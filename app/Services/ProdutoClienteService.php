<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Favorito;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProdutoClienteService
{
    /**
     * Adiciona ou remove um produto dos favoritos do usuário (toggle)
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @return array
     */
    public function alternarFavorito(int $usuarioId, int $produtoId): array
    {
        try {
            // Verifica se já está nos favoritos
            $favoritoExistente = Favorito::doUsuario($usuarioId)
                ->where('id_produto', $produtoId)
                ->first();

            if ($favoritoExistente) {
                // Remove dos favoritos
                $favoritoExistente->delete();
                
                return [
                    'sucesso' => true,
                    'acao' => 'removido',
                    'esta_nos_favoritos' => false,
                    'favorito' => null
                ];
            }

            // Cria novo favorito
            $favorito = Favorito::create([
                'id_usuario' => $usuarioId,
                'id_produto' => $produtoId,
            ]);

            return [
                'sucesso' => true,
                'acao' => 'adicionado',
                'esta_nos_favoritos' => true,
                'favorito' => $favorito
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao alternar favorito', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'erro' => $e->getMessage()
            ]);
            
            return [
                'sucesso' => false,
                'acao' => 'erro',
                'esta_nos_favoritos' => $this->produtoEstaNosFavoritos($usuarioId, $produtoId),
                'erro' => $e->getMessage()
            ];
        }
    }

    /**
     * Adiciona um produto aos favoritos do usuário (apenas adiciona)
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @return Favorito|null
     */
    public function adicionarAosFavoritos(int $usuarioId, int $produtoId): ?Favorito
    {
        try {
            // Verifica se já está nos favoritos
            $favoritoExistente = Favorito::doUsuario($usuarioId)
                ->where('id_produto', $produtoId)
                ->first();

            if ($favoritoExistente) {
                return $favoritoExistente; // Já está favoritado
            }

            // Cria novo favorito
            $favorito = Favorito::create([
                'id_usuario' => $usuarioId,
                'id_produto' => $produtoId,
            ]);

            return $favorito;
        } catch (\Exception $e) {
            Log::error('Erro ao adicionar produto aos favoritos', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'erro' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Remove um produto dos favoritos do usuário
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @return bool
     */
    public function removerDosFavoritos(int $usuarioId, int $produtoId): bool
    {
        try {
            $removido = Favorito::doUsuario($usuarioId)
                ->where('id_produto', $produtoId)
                ->delete();

            return $removido > 0;
        } catch (\Exception $e) {
            Log::error('Erro ao remover produto dos favoritos', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'erro' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Verifica se um produto está nos favoritos do usuário
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @return bool
     */
    public function produtoEstaNosFavoritos(int $usuarioId, int $produtoId): bool
    {
        return Favorito::doUsuario($usuarioId)
            ->where('id_produto', $produtoId)
            ->exists();
    }

    /**
     * Cria uma nova avaliação para um produto
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @param int $rating
     * @param string|null $comentario
     * @param bool $aprovadoAutomaticamente Se true, a review é aprovada automaticamente
     * @return Review|null
     */
    public function criarReview(
        int $usuarioId,
        int $produtoId,
        int $rating,
        ?string $comentario = null,
        bool $aprovadoAutomaticamente = false
    ): ?Review {
        try {
            // Valida o rating
            if ($rating < 1 || $rating > 5) {
                throw new \InvalidArgumentException('Rating deve estar entre 1 e 5');
            }

            // Verifica se o usuário já avaliou este produto
            $reviewExistente = Review::where('id_usuario', $usuarioId)
                ->where('id_produto', $produtoId)
                ->first();

            if ($reviewExistente) {
                // Atualiza a review existente
                $reviewExistente->update([
                    'rating' => $rating,
                    'comentario' => $comentario,
                    'aprovado' => $aprovadoAutomaticamente
                ]);
                return $reviewExistente;
            }

            // Cria nova review
            $review = Review::create([
                'id_usuario' => $usuarioId,
                'id_produto' => $produtoId,
                'rating' => $rating,
                'comentario' => $comentario,
                'aprovado' => $aprovadoAutomaticamente
            ]);

            return $review;
        } catch (\Exception $e) {
            Log::error('Erro ao criar review', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'erro' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Aprova uma review
     *
     * @param int $reviewId
     * @return bool
     */
    public function aprovarReview(int $reviewId): bool
    {
        try {
            $review = Review::findOrFail($reviewId);
            $review->aprovar();
            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao aprovar review', [
                'review_id' => $reviewId,
                'erro' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Remove uma review
     *
     * @param int $reviewId
     * @return bool
     */
    public function removerReview(int $reviewId): bool
    {
        try {
            return Review::where('id_review', $reviewId)->delete() > 0;
        } catch (\Exception $e) {
            Log::error('Erro ao remover review', [
                'review_id' => $reviewId,
                'erro' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Obtém reviews de um produto com opções de filtro
     *
     * @param int $produtoId
     * @param bool $apenasAprovadas
     * @param int|null $minRating
     * @param int $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obterReviewsDoProduto(
        int $produtoId,
        bool $apenasAprovadas = true,
        ?int $minRating = null,
        int $limite = 10
    ): \Illuminate\Database\Eloquent\Collection {
        $query = Review::where('id_produto', $produtoId);

        if ($apenasAprovadas) {
            $query->aprovados();
        }

        if ($minRating) {
            $query->porRating($minRating);
        }

        return $query->recentes($limite)->get();
    }

    /**
     * Obtém os produtos favoritos de um usuário
     *
     * @param int $usuarioId
     * @param int $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obterFavoritosDoUsuario(
        int $usuarioId,
        int $limite = 20
    ): \Illuminate\Database\Eloquent\Collection {
        return Favorito::with(['produto'])
            ->doUsuario($usuarioId)
            ->recentes($limite)
            ->get()
            ->pluck('produto')
            ->filter(); // Remove nulls
    }

    /**
     * Obtém estatísticas de um produto
     *
     * @param int $produtoId
     * @return array
     */
    public function obterEstatisticasProduto(int $produtoId): array
    {
        try {
            $reviews = Review::where('id_produto', $produtoId)
                ->aprovados()
                ->get();

            $totalReviews = $reviews->count();
            $mediaRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
            $totalFavoritos = Favorito::where('id_produto', $produtoId)->count();

            return [
                'total_reviews' => $totalReviews,
                'media_rating' => round($mediaRating, 1),
                'total_favoritos' => $totalFavoritos,
                'distribuicao_rating' => $this->calcularDistribuicaoRating($reviews),
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao obter estatísticas do produto', [
                'produto_id' => $produtoId,
                'erro' => $e->getMessage()
            ]);
            return [
                'total_reviews' => 0,
                'media_rating' => 0,
                'total_favoritos' => 0,
                'distribuicao_rating' => [],
            ];
        }
    }

    /**
     * Calcula a distribuição dos ratings
     *
     * @param \Illuminate\Database\Eloquent\Collection $reviews
     * @return array
     */
    private function calcularDistribuicaoRating(\Illuminate\Database\Eloquent\Collection $reviews): array
    {
        $distribuicao = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        foreach ($reviews as $review) {
            $rating = $review->rating;
            if (isset($distribuicao[$rating])) {
                $distribuicao[$rating]++;
            }
        }

        $total = $reviews->count();
        if ($total > 0) {
            foreach ($distribuicao as $rating => $count) {
                $distribuicao[$rating] = [
                    'quantidade' => $count,
                    'percentual' => round(($count / $total) * 100, 1)
                ];
            }
        }

        return $distribuicao;
    }

    /**
     * Obtém a review de um usuário para um produto específico
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @return Review|null
     */
    public function obterReviewDoUsuario(int $usuarioId, int $produtoId): ?Review
    {
        return Review::where('id_usuario', $usuarioId)
            ->where('id_produto', $produtoId)
            ->first();
    }

    /**
     * Obtém todos os favoritos do usuário com dados do produto
     *
     * @param int $usuarioId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obterFavoritosComProduto(int $usuarioId): \Illuminate\Database\Eloquent\Collection
    {
        return Favorito::with([
            'produto' => function ($query) {
                $query->with(['imagens', 'categoria'])
                    ->select('id_produto', 'nome', 'slug', 'preco', 'preco_promocional', 'estoque', 'id_categoria');
            }
        ])
        ->doUsuario($usuarioId)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    /**
     * Remove todos os favoritos do usuário
     *
     * @param int $usuarioId
     * @return int Número de favoritos removidos
     */
    public function removerTodosFavoritos(int $usuarioId): int
    {
        try {
            return Favorito::doUsuario($usuarioId)->delete();
        } catch (\Exception $e) {
            Log::error('Erro ao remover todos os favoritos', [
                'usuario_id' => $usuarioId,
                'erro' => $e->getMessage()
            ]);
            return 0;
        }
    }
}
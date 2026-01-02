<?php

namespace Tests\Unit\Services;

use App\Services\ProdutoClienteService;
use Tests\TestCase;

class ProdutoClienteServiceTest extends TestCase
{
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProdutoClienteService();
    }

    public function test_adicionar_aos_favoritos()
    {
        // Exemplo de uso
        $usuarioId = 1;
        $produtoId = 10;
        
        $favorito = $this->service->adicionarAosFavoritos($usuarioId, $produtoId);
        
        $this->assertNotNull($favorito);
        $this->assertEquals($usuarioId, $favorito->id_usuario);
        $this->assertEquals($produtoId, $favorito->id_produto);
    }

    public function test_criar_review()
    {
        $usuarioId = 1;
        $produtoId = 10;
        $rating = 5;
        $comentario = 'Excelente produto!';
        
        $review = $this->service->criarReview($usuarioId, $produtoId, $rating, $comentario);
        
        $this->assertNotNull($review);
        $this->assertEquals($rating, $review->rating);
        $this->assertEquals($comentario, $review->comentario);
    }
}
<?php

namespace App\Services;

use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarrinhoService
{
    /**
     * Obtém ou cria um carrinho para o usuário
     *
     * @param int $usuarioId
     * @return Carrinho
     */
    public function obterCarrinhoUsuario(int $usuarioId): Carrinho
    {
        return Carrinho::firstOrCreate(
            ['id_usuario' => $usuarioId],
            ['id_usuario' => $usuarioId]
        );
    }

    /**
     * Adiciona um produto ao carrinho
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @param int $quantidade
     * @param float|null $precoUnitario Se null, busca do produto
     * @return array
     */
    public function adicionarAoCarrinho(
        int $usuarioId,
        int $produtoId,
        int $quantidade = 1,
        ?float $precoUnitario = null
    ): array {
        try {
            DB::beginTransaction();

            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            // Busca preço do produto se não fornecido
            if ($precoUnitario === null) {
                $produto = Produto::findOrFail($produtoId);
                $precoUnitario = $produto->preco;
            }

            // Verifica se o produto já está no carrinho
            $itemExistente = $carrinho->itens()
                ->where('id_produto', $produtoId)
                ->first();

            if ($itemExistente) {
                // Atualiza quantidade
                $itemExistente->aumentarQuantidade($quantidade);
                $item = $itemExistente;
                $acao = 'atualizado';
            } else {
                // Cria novo item
                $item = CarrinhoItem::create([
                    'id_carrinho' => $carrinho->id_carrinho,
                    'id_produto' => $produtoId,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $precoUnitario
                ]);
                $acao = 'adicionado';
            }

            // Atualiza carrinho
            $carrinho->refresh();

            DB::commit();

            return [
                'sucesso' => true,
                'acao' => $acao,
                'item' => $item,
                'carrinho' => $carrinho,
                'total_itens' => $carrinho->totalItens(),
                'subtotal' => $carrinho->subtotal()
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao adicionar produto ao carrinho', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'quantidade' => $quantidade,
                'erro' => $e->getMessage()
            ]);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível adicionar o produto ao carrinho'
            ];
        }
    }

    /**
     * Remove um produto do carrinho
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @return array
     */
    public function removerDoCarrinho(int $usuarioId, int $produtoId): array
    {
        try {
            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            $removido = $carrinho->itens()
                ->where('id_produto', $produtoId)
                ->delete();

            $carrinho->refresh();

            return [
                'sucesso' => $removido > 0,
                'carrinho' => $carrinho,
                'total_itens' => $carrinho->totalItens(),
                'subtotal' => $carrinho->subtotal()
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao remover produto do carrinho', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'erro' => $e->getMessage()
            ]);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível remover o produto do carrinho'
            ];
        }
    }

    /**
     * Atualiza a quantidade de um produto no carrinho
     *
     * @param int $usuarioId
     * @param int $produtoId
     * @param int $quantidade
     * @return array
     */
    public function atualizarQuantidade(int $usuarioId, int $produtoId, int $quantidade): array
    {
        try {
            if ($quantidade < 1) {
                return $this->removerDoCarrinho($usuarioId, $produtoId);
            }

            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            $item = $carrinho->itens()
                ->where('id_produto', $produtoId)
                ->first();

            if (!$item) {
                return [
                    'sucesso' => false,
                    'erro' => 'Produto não encontrado no carrinho'
                ];
            }

            $item->quantidade = $quantidade;
            $item->save();

            $carrinho->refresh();

            return [
                'sucesso' => true,
                'item' => $item,
                'carrinho' => $carrinho,
                'total_itens' => $carrinho->totalItens(),
                'subtotal' => $carrinho->subtotal()
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar quantidade no carrinho', [
                'usuario_id' => $usuarioId,
                'produto_id' => $produtoId,
                'quantidade' => $quantidade,
                'erro' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao atualizar quantidade no carrinho: '. $e);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível atualizar a quantidade'
            ];
        }
    }

    /**
     * Limpa o carrinho do usuário
     *
     * @param int $usuarioId
     * @return array
     */
    public function limparCarrinho(int $usuarioId): array
    {
        try {
            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            $quantidadeItens = $carrinho->itens()->count();
            $carrinho->itens()->delete();
            $carrinho->refresh();

            return [
                'sucesso' => true,
                'itens_removidos' => $quantidadeItens,
                'carrinho' => $carrinho
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao limpar carrinho', [
                'usuario_id' => $usuarioId,
                'erro' => $e->getMessage()
            ]);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível limpar o carrinho'
            ];
        }
    }

    /**
     * Obtém os detalhes completos do carrinho
     *
     * @param int $usuarioId
     * @return array
     */
    public function obterDetalhesCarrinho(int $usuarioId): array
    {
        try {
            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            // Carrega os itens com os produtos
            $carrinho->load(['itens.produto.imagemPrincipal']);

            $itensFormatados = $carrinho->itens->map(function ($item) {
                return [
                    'id_item' => $item->id_item_carrinho,
                    'produto' => [
                        'id' => $item->produto->id_produto,
                        'nome' => $item->produto->nome,
                        'slug' => $item->produto->slug,
                        'imagem' => $item->produto->imagemPrincipal?->caminho,
                        'preco' => $item->produto->preco,
                    ],
                    'quantidade' => $item->quantidade,
                    'preco_unitario' => $item->preco_unitario,
                    'subtotal' => $item->subtotal(),
                    'disponivel' => $item->produto->estoque >= $item->quantidade
                ];
            });

            return [
                'sucesso' => true,
                'carrinho' => [
                    'id' => $carrinho->id_carrinho,
                    'total_itens' => $carrinho->totalItens(),
                    'subtotal' => $carrinho->subtotal(),
                    'vazio' => $carrinho->vazio(),
                    'itens' => $itensFormatados
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao obter detalhes do carrinho', [
                'usuario_id' => $usuarioId,
                'erro' => $e->getMessage()
            ]);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível obter os detalhes do carrinho'
            ];
        }
    }

    /**
     * Move itens do carrinho para um pedido
     *
     * @param int $usuarioId
     * @param int $pedidoId
     * @return array
     */
    public function moverParaPedido(int $usuarioId, int $pedidoId): array
    {
        try {
            DB::beginTransaction();

            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            if ($carrinho->vazio()) {
                return [
                    'sucesso' => false,
                    'erro' => 'Carrinho vazio'
                ];
            }

            // Aqui você implementaria a lógica para mover os itens para um pedido
            // Por exemplo, criar itens de pedido baseados nos itens do carrinho
            
            // Limpa o carrinho após mover para pedido
            $itensMovidos = $carrinho->itens()->count();
            $carrinho->itens()->delete();
            $carrinho->refresh();

            DB::commit();

            return [
                'sucesso' => true,
                'pedido_id' => $pedidoId,
                'itens_movidos' => $itensMovidos,
                'carrinho' => $carrinho
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao mover carrinho para pedido', [
                'usuario_id' => $usuarioId,
                'pedido_id' => $pedidoId,
                'erro' => $e->getMessage()
            ]);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível processar o pedido'
            ];
        }
    }

    /**
     * Verifica a disponibilidade dos itens no carrinho
     *
     * @param int $usuarioId
     * @return array
     */
    public function verificarDisponibilidade(int $usuarioId): array
    {
        try {
            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            $carrinho->load(['itens.produto']);

            $itensIndisponiveis = [];
            $totalDisponivel = true;

            foreach ($carrinho->itens as $item) {
                if ($item->produto->estoque < $item->quantidade) {
                    $itensIndisponiveis[] = [
                        'produto_id' => $item->id_produto,
                        'nome' => $item->produto->nome,
                        'quantidade_solicitada' => $item->quantidade,
                        'estoque_disponivel' => $item->produto->estoque,
                        'deficit' => $item->quantidade - $item->produto->estoque
                    ];
                    $totalDisponivel = false;
                }
            }

            return [
                'disponivel' => $totalDisponivel,
                'itens_indisponiveis' => $itensIndisponiveis,
                'total_itens' => $carrinho->totalItens(),
                'itens_disponiveis' => $carrinho->totalItens() - count($itensIndisponiveis)
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao verificar disponibilidade do carrinho', [
                'usuario_id' => $usuarioId,
                'erro' => $e->getMessage()
            ]);

            return [
                'disponivel' => false,
                'erro' => 'Não foi possível verificar a disponibilidade'
            ];
        }
    }

    /**
     * Aplica um cupom de desconto ao carrinho
     *
     * @param int $usuarioId
     * @param string $codigoCupom
     * @return array
     */
    public function aplicarCupom(int $usuarioId, string $codigoCupom): array
    {
        try {
            $carrinho = $this->obterCarrinhoUsuario($usuarioId);
            
            // Aqui você implementaria a lógica de validação do cupom
            // Por enquanto, retornamos uma estrutura básica
            $desconto = 10.00; // Exemplo: R10 de desconto
            
            $subtotal = $carrinho->subtotal();
            $totalComDesconto = max(0, $subtotal - $desconto);

            return [
                'sucesso' => true,
                'cupom' => $codigoCupom,
                'desconto_aplicado' => $desconto,
                'subtotal_original' => $subtotal,
                'total_com_desconto' => $totalComDesconto,
                'percentual_desconto' => $subtotal > 0 ? round(($desconto / $subtotal) * 100, 2) : 0
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao aplicar cupom', [
                'usuario_id' => $usuarioId,
                'cupom' => $codigoCupom,
                'erro' => $e->getMessage()
            ]);

            return [
                'sucesso' => false,
                'erro' => 'Não foi possível aplicar o cupom'
            ];
        }
    }

    public function add(
        $usuarioId, 
        $produtoId, 
        int $quantidade = 1,
        ?float $precoUnitario = null):bool{
        return $this->adicionarAoCarrinho($usuarioId, $produtoId, $quantidade, $precoUnitario) ? true : false;
    }
}
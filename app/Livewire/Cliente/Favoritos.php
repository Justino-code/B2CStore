<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\Produto;
use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Services\ProdutoClienteService;
use App\Services\CarrinhoService;

class Favoritos extends Component
{
    public $favoritos;
    public $produtos = [];
    public $carrinhoItens = [];
    public $mostrarModalRemover = false;
    public $favoritoParaRemover = null;

    protected $ProdutoClienteService;
    protected $carrinhoService;

    public function boot(ProdutoClienteService $ProdutoClienteService, CarrinhoService $carrinhoService)
    {
        $this->ProdutoClienteService = $ProdutoClienteService;
        $this->carrinhoService = $carrinhoService;
    }

    public function mount()
    {
        $this->carregarFavoritos();
        $this->carregarItensCarrinho();
    }

    public function carregarFavoritos()
    {
        $this->favoritos = Favorito::where('id_usuario', Auth::id())
            ->with(['produto.imagens'])
            ->orderBy('created_at', 'desc')
            ->get();

        $this->produtos = $this->favoritos->map(function ($favorito) {
            return $favorito->produto;
        });
    }

    public function carregarItensCarrinho()
    {
        $carrinho = Carrinho::where('id_usuario', Auth::id())->first();
        
        if ($carrinho) {
            $this->carrinhoItens = $carrinho->itens->pluck('id_produto')->toArray();
        } else {
            $this->carrinhoItens = [];
        }
    }

    public function adicionarAoCarrinho($produtoId)
    {
        $usuarioId = Auth::id();
        
        // Usar o serviço de carrinho
        $resultado = $this->carrinhoService->adicionarAoCarrinho(
            $usuarioId,
            $produtoId,
            1 // quantidade
        );

        if ($resultado['sucesso']) {
            $this->dispatch('notificar', [
                'tipo' => 'sucesso',
                'mensagem' => $resultado['item']->produto->nome . ' adicionado ao carrinho!'
            ]);
            
            // Atualizar lista de itens no carrinho
            $this->carregarItensCarrinho();
            
            // Disparar evento para atualizar contador no navbar
            $this->dispatch('carrinho-atualizado');
        } else {
            $this->dispatch('notificar', [
                'tipo' => 'erro',
                'mensagem' => $resultado['erro'] ?? 'Não foi possível adicionar ao carrinho.'
            ]);
        }
    }

    public function confirmarRemoverFavorito($favoritoId)
    {
        $this->favoritoParaRemover = $favoritoId;
        $this->mostrarModalRemover = true;
    }

    public function removerFavorito()
    {
        if ($this->favoritoParaRemover) {
            // Usar o serviço ProdutoClienteService
            $resultado = $this->ProdutoClienteService->removerDosFavoritos(
                Auth::id(),
                $this->favoritoParaRemover
            );

            if ($resultado) {
                $this->dispatch('notificar', [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Produto removido dos favoritos!'
                ]);
                
                $this->carregarFavoritos();
            } else {
                $this->dispatch('notificar', [
                    'tipo' => 'erro',
                    'mensagem' => 'Não foi possível remover dos favoritos.'
                ]);
            }
        }
        
        $this->fecharModal();
    }

    public function removerTodosFavoritos()
    {
        $total = Favorito::where('id_usuario', Auth::id())->count();
        
        if ($total > 0) {
            Favorito::where('id_usuario', Auth::id())->delete();
            
            $this->dispatch('notificar', [
                'tipo' => 'sucesso',
                'mensagem' => $total . ' produtos removidos dos favoritos!'
            ]);
            
            $this->carregarFavoritos();
        }
    }

    public function fecharModal()
    {
        $this->mostrarModalRemover = false;
        $this->favoritoParaRemover = null;
    }

    // Método público para verificar se produto está no carrinho
    public function produtoEstaNoCarrinho($produtoId)
    {
        return in_array($produtoId, $this->carrinhoItens);
    }

    public function irParaCarrinho()
    {
        return redirect()->route('cliente.carrinho');
    }

    public function render()
    {
        return view('livewire.cliente.favoritos')
            ->layout('components.layouts.cliente', [
                'titulo' => 'Meus Favoritos - B2CStore'
            ]);
    }
}
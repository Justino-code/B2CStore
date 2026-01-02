<?php
namespace App\Traits;

use App\Services\CarrinhoService;

trait HasCartActions
{
    protected function cartService(): CarrinhoService
    {
        return app(CarrinhoService::class);
    }

    public function addToCart($produtoId)
    {
        try
        {
            if (auth()->check() && auth()->user()->role === 'cliente') {
                $user = auth()->user();

                $this->cartService()->add($user->id_usuario, $produtoId);

                $this->dispatch('notify', 
                    type: 'success',
                    message: 'Produto adicionado ao carrinho!'
                );
            } else {
                if(auth()->check() && auth()->user()->role !== 'cliente'){
                    $this->dispatch('notify',
                        type: 'warning',
                        message: 'Faça login como cliente para adicionar ao carrinho!'
                    );
                } else{
                    $this->dispatch('notify',
                        type: 'warning',
                        message: 'Faça login para adicionar ao carrinho!'
                    );
                }
            }
        }catch(\Throwable $th){
            $this->dispatch('notify',
                    type: 'error',
                    message: 'Nao foi possivel adicionar ao carrinho!'
                );

            dd($th);
        }
    }
}


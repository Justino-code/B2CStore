<?php
namespace App\Traits;

use App\Services\ProdutoClienteService as FavService;

trait HasFavorites
{
    public $isFavorite;
    
    protected function favService(): FavService
    {
        return app(FavService::class);
    }

    public function addToFavorites($produtoId)
    {
        if (auth()->check() && auth()->user()->role === 'cliente') {
            $user = auth()->user();

            try
            {
                $fav = $this->favService()->alternarFavorito($user->id_usuario, $produtoId);
                
                // Dispara evento para atualizar a interface
                $this->dispatch('favorito-atualizado', 
                    produtoId: $produtoId, 
                    acao: $fav['acao']
                );
                
                $this->dispatch('notify', 
                    type: 'success',
                    message: 'Produto '.$fav['acao'].' nos favoritos!'
                );
                
            } catch(\Throwable $th) {
                $this->dispatch('notify',
                    type: 'error',
                    message: 'Nao foi possivel adicionar aos favoritos!'
                );
            }
        } else {
            if(auth()->check() && auth()->user()->role !== 'cliente'){
                $this->dispatch('notify',
                    type: 'warning',
                    message: 'Faça login como cliente para adicionar aos favoritos!'
                );
            }else{
                $this->dispatch('notify',
                    type: 'warning',
                    message: 'Faça login para adicionar aos favoritos!'
                );

            }
        }
    }

    public function isFavorite($produtoId): bool
    {
        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            return false;
        }
        
        return $this->favService()->produtoEstaNosFavoritos(
            auth()->user()->id_usuario, 
            $produtoId
        );
    }
}
<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Public\{
    Index as Home,
    Produtos as CatalogoProdutos,
    ProdutoShow,
};

use App\Livewire\Carrinho\{
    Index as CarrinhoIndex,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('home');

Route::get('/produtos', CatalogoProdutos::class)->name('produtos');

Route::get('/produto/{id}', ProdutoShow::class)->name('produto.show');

Route::get('/carrinho', CarrinhoIndex::class)->name('carrinho');


/*Route::get('/', function(){
    return view('pages.home');
})->name('home');*/

//
Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');

/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
 */
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Public\{
    Index as Home,
    Produtos as CatalogoProdutos,
    ProdutoShow,
    CategoriasIndex,
    CategoriaShow,
    Sobre,

};

use App\Livewire\Carrinho\{
    Index as CarrinhoIndex,
};

use  \App\Livewire\Admin\{
    Dashboard
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('home');

Route::get('/produtos', CatalogoProdutos::class)->name('produtos');

Route::get('/produto/{slug}', ProdutoShow::class)->name('produto.detalhe');


Route::get('/categorias', CategoriasIndex::class)->name('categorias');
Route::get('/categoria/{slug}', CategoriaShow::class)->name('categoria');

Route::get('/sobre', Sobre::class)->name('sobre');
Route::get('/contato', Sobre::class)->name('contato');


Route::get('/carrinho', CarrinhoIndex::class)->name('carrinho');

Route::get('/destaques', function(){})->name('produtos.destaque');
Route::get('/detalhes', function(){})->name('produto.detalhe');
Route::get('/promocao', function(){})->name('produtos.promocao');
Route::get('/novidades', function(){})->name('produtos.novidade');

Route::get('/termos', function(){})->name('terms');
Route::get('/privacidade', function(){})->name('privacy');


Route::get('/test', function(){
    return view('pages.home');
})->name('home');

//
Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/dashboard/admin', Dashboard::class)->name('admin.dashboard');

/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
 */
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


require __DIR__.'/auth.php';

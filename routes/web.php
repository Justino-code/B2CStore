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

use App\Livewire\Admin\{
    Dashboard
};

use App\Livewire\Cliente\{
    Dashboard as ClienteDashboard,
    Carrinho,
    Favoritos,
    Conta,
    Pedidos,
    Cupons,
    Checkout,
};

use App\Livewire\Admin\Produto\{
    Form as ProdutoForm,
    Index as ProdutoIndex,
    Show as ProdutoAdminShow,
};

use App\Livewire\Admin\Pedido\{
    Form as PedidoForm,
    Index as PedidoIndex,
    Show as PedidoShow,
};

use App\Livewire\Admin\Cupom\{
    Form as CupomForm,
    Index as CupomIndex,
    Show as CupomShow,
};

use App\Livewire\Admin\Categoria\{
    Index as CategoriaAdminIndex,
    Form as CategoriaForm,
    Show as CategoriaAdminShow,
};

use App\Livewire\Admin\Cliente\{
    Index as ClienteIndex,
    Form as ClienteForm,
    Show as ClienteShow,
};

use App\Livewire\Admin\Funcionarios\{
    Index as FuncionarioIndex,
    Form as FuncionarioForm,
    Show as FuncionarioShow,
};

use App\Livewire\Admin\Relatorio\{
    Index as RelatorioIndex,
    Form as RelatorioForm,
    Show as RelatorioShow,
};

use App\Livewire\Admin\Perfil\{
    Index as PerfilIndex,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas públicas
Route::get('/', Home::class)->name('home');
Route::fallback(function () {
    return redirect()->route('unauthorized');
});

Route::get('/produtos', CatalogoProdutos::class)->name('produtos');
Route::get('/produto/{slug}', ProdutoShow::class)->name('produto.detalhe');
Route::get('/categorias', CategoriasIndex::class)->name('categorias');
Route::get('/categoria/{slug}', CategoriaShow::class)->name('categoria');
Route::get('/sobre', Sobre::class)->name('sobre');
Route::get('/contato', Sobre::class)->name('contato');
Route::get('/error', function () {
    return view('errors.unauthorized');
})->name('unauthorized');

// Outras rotas públicas...
// [mantenha as outras rotas públicas conforme seu código original]

// Rotas para clientes
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/dashboard', ClienteDashboard::class)->name('dashboard');
        Route::get('/carrinho', Carrinho::class)->name('carrinho');
        Route::get('/favoritos', Favoritos::class)->name('favoritos');
        Route::get('/conta', Conta::class)->name('conta');
        Route::get('/pedidos', Pedidos::class)->name('pedidos');
        Route::get('/cupons', Cupons::class)->name('cupons');
        Route::get('/checkout', Checkout::class)->name('checkout');
    });
});

// ============================================================================
// ROTAS ADMINISTRATIVAS COM PERMISSÕES POR CARGO
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // ========== PERFIL - DISPONÍVEL PARA TODOS OS CARGOS ADMINISTRATIVOS ==========
    Route::middleware(['role:admin,gerente,operador,suporte'])->group(function () {
        Route::get('/perfil', PerfilIndex::class)->name('perfil');
    });

    // ========== DASHBOARD - APENAS ADMIN E GERENTE ==========
    Route::middleware(['role:admin,gerente'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
    });

    // ========== PRODUTOS - APENAS ADMIN E GERENTE ==========
    Route::middleware(['role:admin,gerente'])->prefix('produtos')->name('produtos.')->group(function () {
        Route::get('/', ProdutoIndex::class)->name('index');
        Route::get('/novo', ProdutoForm::class)->name('create');
        Route::get('/{id}/editar', ProdutoForm::class)->name('edit');
        Route::get('/{id}', ProdutoAdminShow::class)->name('show');
    });

    // ========== CATEGORIAS - APENAS ADMIN E GERENTE ==========
    Route::middleware(['role:admin,gerente'])->prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', CategoriaAdminIndex::class)->name('index');
        Route::get('/novo', CategoriaForm::class)->name('create');
        Route::get('/{id}/editar', CategoriaForm::class)->name('edit');
        Route::get('/{id}', CategoriaAdminShow::class)->name('show');
    });

    // ========== PEDIDOS - ADMIN, GERENTE, OPERADOR E SUPORTE ==========
    Route::middleware(['role:admin,gerente,operador,suporte'])->prefix('pedidos')->name('pedidos.')->group(function () {
        Route::get('/', PedidoIndex::class)->name('index');
        Route::get('/{id}', PedidoShow::class)->name('show');
        Route::get('/{id}/editar', PedidoForm::class)->name('edit');
    });

    // ========== CLIENTES - ADMIN, GERENTE, OPERADOR E SUPORTE ==========
    Route::middleware(['role:admin,gerente,operador,suporte'])->prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/', ClienteIndex::class)->name('index');
        Route::get('/{id}', ClienteShow::class)->name('show');
        // Rotas de create/edit podem ser restritas apenas a admin se necessário
        // Route::get('/novo', ClienteForm::class)->name('create');
        // Route::get('/{id}/editar', ClienteForm::class)->name('edit');
    });

    // ========== RELATÓRIOS - APENAS ADMIN E GERENTE ==========
    Route::middleware(['role:admin,gerente'])->prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', RelatorioIndex::class)->name('index');
        Route::get('/novo', RelatorioForm::class)->name('create');
        Route::get('/{relatorio}/editar', RelatorioForm::class)->name('edit');
        Route::get('/{relatorio}', RelatorioShow::class)->name('show');
    });

    // ========== FUNCIONÁRIOS - APENAS ADMIN ==========
    Route::middleware(['role:admin'])->prefix('funcionarios')->name('funcionarios.')->group(function () {
        Route::get('/', FuncionarioIndex::class)->name('index');
        Route::get('/novo', FuncionarioForm::class)->name('create');
        Route::get('/{funcionario}/editar', FuncionarioForm::class)->name('edit');
        Route::get('/{funcionario}', FuncionarioShow::class)->name('show');
    });

    // ========== CUPONS - APENAS ADMIN ==========
    Route::middleware(['role:admin'])->prefix('promocoes')->name('cupons.')->group(function () {
        Route::get('/', CupomIndex::class)->name('index');
        Route::get('/novo', CupomForm::class)->name('create');
        Route::get('/{id}/editar', CupomForm::class)->name('edit');
        Route::get('/{id}', CupomShow::class)->name('show');
    });

    // ========== ROTAS ADICIONAIS QUE PODEM EXISTIR NO SEU SISTEMA ==========
    // Se houver outras rotas administrativas, adicione aqui com as permissões apropriadas
    
});

//Rotas por implentar
Route::get('/destaques', function(){})->name('produtos.destaque');
Route::get('/detalhes', function(){})->name('produto.detalhe');
Route::get('/promocao', function(){})->name('produtos.promocao');
Route::get('/novidades', function(){})->name('produtos.novidade');

Route::get('/avaliacoes', function(){})->name('cliente.avaliacoes');
Route::get('/enderecos', function(){})->name('cliente.enderecos');
Route::get('/seguranca', function(){})->name('cliente.seguranca');

Route::get('/admin/profile', function(){})->name('admin.profile');
Route::get('/admin/settings', function(){})->name('admin.settings');
Route::get('/admin/configuracoes', function(){})->name('admin.configuracoes');

Route::get('/admin/sistema/status', function(){})->name('admin.sistema.status');

Route::get('/termos', function(){})->name('terms');
Route::get('/privacidade', function(){})->name('privacy');


Route::get('/test', function(){
    return view('pages.home');
})->name('home');

require __DIR__.'/auth.php';
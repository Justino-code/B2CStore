# **4. Arquitetura Técnica e Desenvolvimento do Sistema B2CStore Angola**

## **4.1. Arquitetura Geral do Sistema**

### **4.1.1. Visão Geral da Arquitetura Web-First**

O B2CStore segue uma arquitetura monolítica web-first, otimizada para o contexto tecnológico angolano:

```
┌─────────────────────────────────────────────────────────┐
│                    Camada de Apresentação                 │
│                 (Livewire + Blade + Alpine.js)           │
│  ┌───────────────────────────────────────────────────┐  │
│  │  Aplicação Web Responsiva (PWA)                  │  │
│  │  • Frontend Público                              │  │
│  │  • Área do Cliente                              │  │
│  │  • Painel Administrativo                        │  │
│  └───────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────┐
│              Camada de Aplicação (Laravel)              │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│  │ Contro-  │  │  Model   │  │  View    │              │
│  │ llers    │  │  (ORM)   │  │ (Blade)  │              │
│  └──────────┘  └──────────┘  └──────────┘              │
└─────────────────────────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────┐
│                 Camada de Dados                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│  │  MySQL   │  │  Redis   │  │  File    │              │
│  │  Banco   │  │  Cache   │  │ Storage  │              │
│  └──────────┘  └──────────┘  └──────────┘              │
└─────────────────────────────────────────────────────────┘
```

### **4.1.2. Princípios de Design Arquitetural**

**Princípios Adotados para Angola:**
1. **Web-First:** Aplicação web responsiva como único frontend
2. **PWA Capable:** Funcionalidades de Progressive Web App
3. **Offline-First:** Funcionalidade básica sem conexão via Service Workers
4. **Low-Bandwidth Optimized:** Minimização de recursos e cache agressivo
5. **Simple Monolith:** Arquitetura monolítica para reduzir complexidade

## **4.2. Stack Tecnológico**

### **4.2.1. Backend Stack**

**Core Framework:**
- **PHP 8.2:** Performance melhorada, tipagem estrita
- **Laravel 10:** Framework MVC completo
- **Livewire 3:** Componentes reativos full-stack
- **Laravel Breeze:** Scaffolding de autenticação

**Banco de Dados:**
- **MySQL 8.0:** Banco de dados relacional principal
- **Redis 7.0:** Cache, sessões e filas
- **Laravel File System:** Armazenamento local de imagens

### **4.2.2. Frontend Stack**

**Tecnologias Principais:**
- **Blade Templates:** Templating server-side do Laravel
- **Alpine.js 3.0:** Interatividade client-side leve (21KB)
- **Tailwind CSS 3.0:** Sistema de design utilitário
- **Vite 4.0:** Build tool moderno e rápido

**Otimizações Especiais:**
- **Lazy Loading:** Imagens e componentes sob demanda
- **Service Workers:** Cache offline e atualizações em background
- **Critical CSS:** CSS crítico inline para renderização rápida
- **Font Optimization:** Fontes locais para reduzir requisições

### **4.2.3. Infraestrutura**

**Requisitos Mínimos:**
- **PHP:** 8.2+ com OPcache habilitado
- **Servidor Web:** Nginx 1.18+ ou Apache 2.4+
- **Banco de Dados:** MySQL 8.0+ ou MariaDB 10.4+
- **Memória:** 1GB RAM mínimo, 2GB recomendado
- **Storage:** 10GB SSD mínimo

**Otimizações para Angola:**
- **CDN Regional:** Cloudflare com cache em África
- **Compressão:** Gzip/Brotli para todos os assets
- **SSL:** HTTPS obrigatório para todas as páginas
- **Backup Automático:** Diário para servidores locais

## **4.3. Estrutura do Projeto Laravel**

### **4.3.1. Organização dos Diretórios**

```
b2cstore/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Controllers administrativos
│   │   │   ├── Cliente/         # Controllers da área do cliente
│   │   │   └── Public/          # Controllers públicos
│   │   └── Middleware/
│   │       ├── CheckRole.php    # Middleware de verificação de roles
│   │       └── AngolaLocale.php # Middleware de localização
│   ├── Livewire/
│   │   ├── Public/              # Componentes públicos
│   │   ├── Cliente/             # Componentes da área do cliente
│   │   ├── Admin/               # Componentes administrativos
│   │   └── Carrinho/            # Componentes do carrinho
│   ├── Models/
│   │   ├── Usuario.php          # Modelo de usuário com roles
│   │   ├── Produto.php          # Modelo de produto
│   │   ├── Pedido.php           # Modelo de pedido
│   │   └── ...                  # Outros modelos
│   └── Services/
│       ├── Pagamento/
│       │   ├── MpesaService.php # Serviço M-Pesa Angola
│       │   └── CodService.php   # Serviço Cash on Delivery
│       └── Logistica/
│           └── FreteService.php # Cálculo de fretes angolanos
├── resources/
│   ├── views/
│   │   ├── layouts/             # Layouts base
│   │   ├── public/              # Views públicas
│   │   ├── cliente/             # Views da área do cliente
│   │   ├── admin/               # Views administrativas
│   │   └── components/          # Componentes Blade reutilizáveis
│   └── lang/
│       ├── pt/                  # Português (default)
│       ├── pt-ao/               # Português angolano
│       └── kmb/                 # Kimbundu (básico)
└── database/
    ├── migrations/              # Migrations do banco
    └── seeders/                 # Seeders com dados de Angola
```

### **4.3.2. Estrutura de Rotas**

```php
// routes/web.php - Estrutura principal de rotas

// Rotas Públicas
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/produtos', [PublicController::class, 'produtos'])->name('produtos.index');
Route::get('/produto/{slug}', [PublicController::class, 'produtoShow'])->name('produto.show');
Route::get('/categoria/{slug}', [PublicController::class, 'categoria'])->name('categoria.show');

// Autenticação
Route::middleware('guest')->group(function () {
    Route::get('/registrar', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
});

// Área do Cliente
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/dashboard', [ClienteController::class, 'dashboard'])->name('dashboard');
    Route::get('/pedidos', [ClienteController::class, 'pedidos'])->name('pedidos');
    Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});

// Área Administrativa
Route::middleware(['auth', 'check.role:admin,gerente,operador,suporte'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Admin e Gerente
    Route::middleware(['check.role:admin,gerente'])->group(function () {
        Route::resource('/produtos', ProdutoController::class);
        Route::resource('/categorias', CategoriaController::class);
        Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios');
    });
    
    // Todos os roles administrativos
    Route::resource('/pedidos', PedidoController::class);
    Route::resource('/clientes', ClienteController::class);
    
    // Apenas Admin
    Route::middleware(['check.role:admin'])->group(function () {
        Route::resource('/funcionarios', FuncionarioController::class);
        Route::resource('/cupons', CupomController::class);
    });
});
```

## **4.4. Componentes Livewire**

### **4.4.1. Arquitetura dos Componentes**

**Estrutura de Componentes por Módulo:**

```
App\Livewire\
├── Public\
│   ├── HomePage.php           # Página inicial
│   ├── ProdutosGrid.php       # Grid de produtos
│   ├── ProdutoShow.php        # Detalhe do produto
│   └── CategoriaShow.php      # Página de categoria
├── Carrinho\
│   ├── CarrinhoItens.php      # Itens do carrinho
│   ├── AdicionarAoCarrinho.php # Botão add to cart
│   └── CarrinhoResumo.php     # Resumo do carrinho
├── Checkout\
│   ├── CheckoutForm.php       # Formulário de checkout
│   ├── MetodoPagamento.php    # Seleção de pagamento
│   └── ResumoPedido.php       # Resumo do pedido
├── Cliente\
│   ├── DashboardCliente.php   # Dashboard do cliente
│   ├── MeusPedidos.php        # Lista de pedidos
│   └── PerfilCliente.php      # Perfil do cliente
└── Admin\
    ├── DashboardAdmin.php     # Dashboard administrativo
    ├── Produtos\              # Módulo de produtos
    ├── Pedidos\               # Módulo de pedidos
    └── Relatorios\            # Módulo de relatórios
```

### **4.4.2. Exemplo de Componente Otimizado**

**ProdutoShow Component:**
```php
<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Produto;

class ProdutoShow extends Component
{
    public $produto;
    public $quantidade = 1;
    public $variacaoSelecionada;
    
    public function mount($slug)
    {
        // Carregamento otimizado com apenas os dados necessários
        $this->produto = Produto::with(['categoria', 'imagens'])
            ->where('slug', $slug)
            ->where('ativo', true)
            ->firstOrFail();
    }
    
    public function adicionarAoCarrinho()
    {
        // Validação de estoque
        if ($this->produto->estoque < $this->quantidade) {
            $this->dispatch('notificar', [
                'tipo' => 'erro',
                'mensagem' => 'Quantidade indisponível em estoque'
            ]);
            return;
        }
        
        // Adicionar ao carrinho via session
        $carrinho = session()->get('carrinho', []);
        
        $carrinho[$this->produto->id_produto] = [
            'id' => $this->produto->id_produto,
            'nome' => $this->produto->nome,
            'preco' => $this->produto->preco_promocional ?? $this->produto->preco_base,
            'quantidade' => $this->quantidade,
            'imagem' => $this->produto->imagem_principal_url
        ];
        
        session()->put('carrinho', $carrinho);
        
        $this->dispatch('carrinho-atualizado');
        $this->dispatch('notificar', [
            'tipo' => 'sucesso',
            'mensagem' => 'Produto adicionado ao carrinho!'
        ]);
    }
    
    public function render()
    {
        return view('livewire.public.produto-show')
            ->layout('layouts.public');
    }
}
```

## **4.5. Otimizações para o Contexto Angolano**

### **4.5.1. Performance para Baixa Conectividade**

**Cache Estratégico:**
```php
// app/Http/Middleware/CacheStaticAssets.php
public function handle($request, $next)
{
    $response = $next($request);
    
    // Cache de assets estáticos por 1 ano
    if ($request->is('assets/*') || $request->is('images/*')) {
        return $response->header('Cache-Control', 'public, max-age=31536000');
    }
    
    // Cache de páginas públicas por 5 minutos
    if ($request->is('/') || $request->is('produtos') || $request->is('categoria/*')) {
        return $response->header('Cache-Control', 'public, max-age=300');
    }
    
    return $response;
}
```

**Lazy Loading de Imagens:**
```blade
{{-- resources/views/components/imagem-otimizada.blade.php --}}
@props(['src', 'alt', 'lazy' => true, 'width' => null, 'height' => null])

@php
    $classes = $attributes->get('class', '');
    $isLazy = $lazy && !request()->has('nocache');
@endphp

<img 
    {{ $attributes->merge(['class' => $classes]) }}
    @if($isLazy)
        src="{{ asset('images/placeholder.jpg') }}"
        data-src="{{ $src }}"
        loading="lazy"
    @else
        src="{{ $src }}"
    @endif
    alt="{{ $alt }}"
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    onerror="this.src='{{ asset('images/placeholder-error.jpg') }}'"
>
```

### **4.5.2. Localização para Angola**

**Middleware de Localização:**
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class AngolaLocale
{
    public function handle($request, Closure $next)
    {
        // Definir locale baseado em preferência do usuário ou geolocalização
        $locale = $this->determinarLocale($request);
        
        App::setLocale($locale);
        
        // Definir moeda padrão como Kwanza
        config(['app.currency' => 'AOA']);
        config(['app.currency_symbol' => 'Kz']);
        
        // Definir fuso horário de Angola
        config(['app.timezone' => 'Africa/Luanda']);
        
        return $next($request);
    }
    
    private function determinarLocale($request)
    {
        // 1. Verificar preferência do usuário logado
        if (auth()->check() && auth()->user()->preferencia_idioma) {
            return auth()->user()->preferencia_idioma;
        }
        
        // 2. Verificar parâmetro na URL
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, ['pt', 'pt-ao', 'kmb'])) {
                session()->put('locale', $lang);
                return $lang;
            }
        }
        
        // 3. Verificar sessão
        if (session()->has('locale')) {
            return session('locale');
        }
        
        // 4. Default: Português angolano
        return 'pt-ao';
    }
}
```

## **4.6. Sistema de Permissões**

### **4.6.1. Middleware de Verificação de Roles**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Admin tem acesso total
        if ($user->role === 'admin') {
            return $next($request);
        }
        
        // Verificar se usuário tem uma das roles permitidas
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        
        // Redirecionar para página não autorizada
        return redirect()->route('unauthorized')
            ->with('error', 'Você não tem permissão para acessar esta página.');
    }
}
```

### **4.6.2. Configuração das Permissões por Role**

**Roles e Permissões:**
```php
// config/permissions.php
return [
    'roles' => [
        'admin' => [
            'name' => 'Administrador',
            'permissions' => ['*'],
            'menu' => ['dashboard', 'produtos', 'categorias', 'pedidos', 'clientes', 'relatorios', 'funcionarios', 'cupons']
        ],
        'gerente' => [
            'name' => 'Gerente',
            'permissions' => ['produtos.*', 'categorias.*', 'pedidos.*', 'clientes.*', 'relatorios.*'],
            'menu' => ['dashboard', 'produtos', 'categorias', 'pedidos', 'clientes', 'relatorios']
        ],
        'operador' => [
            'name' => 'Operador',
            'permissions' => ['pedidos.view', 'pedidos.update', 'clientes.view'],
            'menu' => ['pedidos', 'clientes']
        ],
        'suporte' => [
            'name' => 'Suporte',
            'permissions' => ['pedidos.view', 'clientes.view'],
            'menu' => ['pedidos', 'clientes']
        ],
        'cliente' => [
            'name' => 'Cliente',
            'permissions' => ['pedidos.own', 'perfil.own'],
            'menu' => ['dashboard', 'pedidos', 'perfil']
        ]
    ]
];
```

## **4.7. Sistema de Cache Otimizado**

### **4.7.1. Estratégia de Cache por Camada**

**Cache em Memória (Redis):**
```php
// config/cache.php - Configuração para Angola
'redis' => [
    'client' => env('REDIS_CLIENT', 'predis'),
    
    'default' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_DB', 0),
        'persistent' => true, // Conexão persistente para performance
    ],
    
    'cache' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_CACHE_DB', 1),
    ],
],
```

**Cache de Views:**
```bash
# Otimização para produção
php artisan view:cache
php artisan route:cache
php artisan config:cache
```

## **4.8. Monitoramento e Manutenção**

### **4.8.1. Health Checks**

```php
// routes/health.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
        'services' => [
            'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
            'cache' => Cache::get('health_check') === 'ok' ? 'working' : 'failing',
            'storage' => Storage::disk('local')->exists('health.txt') ? 'writable' : 'readonly',
        ]
    ]);
});

Route::get('/metrics', function () {
    // Métricas básicas para monitoramento
    return response()->json([
        'memory_usage' => memory_get_usage(true) / 1024 / 1024 . ' MB',
        'active_users' => Cache::get('active_users', 0),
        'pending_orders' => \App\Models\Pedido::where('status', 'pendente')->count(),
        'system_load' => sys_getloadavg()[0] ?? 0,
    ]);
});
```

### **4.8.2. Logs para Angola**

```php
// config/logging.php - Configuração adaptada
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'slack_errors'],
        'ignore_exceptions' => false,
    ],
    
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14, // Manter logs por 2 semanas
    ],
    
    'angola_specific' => [
        'driver' => 'daily',
        'path' => storage_path('logs/angola/transactions.log'),
        'level' => 'info',
        'days' => 30, // Logs de transações por 30 dias
    ],
],
```

## **4.9. Backup e Recovery**

### **4.9.1. Estratégia de Backup**

**Backup Diário:**
```bash
#!/bin/bash
# backup-daily.sh
DATE=$(date +%Y%m%d)
BACKUP_DIR="/backups/b2cstore"

# Backup do banco de dados
mysqldump -u [user] -p[password] b2cstore > $BACKUP_DIR/db-$DATE.sql

# Backup das imagens
tar -czf $BACKUP_DIR/images-$DATE.tar.gz storage/app/public/products

# Backup dos logs
tar -czf $BACKUP_DIR/logs-$DATE.tar.gz storage/logs

# Manter apenas últimos 7 backups
find $BACKUP_DIR -type f -mtime +7 -delete
```

**Recovery Simples:**
```php
// app/Console/Commands/RestoreBackup.php
public function handle()
{
    $this->info('Restaurando backup do B2CStore...');
    
    // Restaurar banco de dados
    Artisan::call('db:wipe');
    $backupFile = $this->argument('file');
    DB::unprepared(file_get_contents($backupFile));
    
    // Restaurar imagens
    Artisan::call('storage:link');
    
    $this->info('Backup restaurado com sucesso!');
}
```

## **Referências**

Laravel Documentation. (2023). *Laravel 10.x - Full-Stack Framework*. Laravel LLC.

Tailwind CSS. (2023). *Utility-First CSS Framework*. Tailwind Labs.

Alpine.js. (2023). *Minimal Framework for Composing JavaScript Behavior*. Alpine.js Collective.

Livewire. (2023). *Full-Stack Framework for Laravel*. Caleb Porzio.

---

*Próxima parte: "5. Implementação e Desenvolvimento por Fases"*
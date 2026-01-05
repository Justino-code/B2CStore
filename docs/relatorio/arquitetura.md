# **4. ENGENHARIA DE SOFTWARE**

## **4.1. Arquitetura do Sistema**

### **4.1.1. Visão Geral da Arquitetura**
O B2CStore segue uma arquitetura **MVC (Model-View-Controller)** implementada através do framework Laravel, com separação clara de responsabilidades entre camadas de apresentação, lógica de negócio e persistência de dados. A arquitetura foi escolhida por oferecer:

- **Manutenibilidade:** Separação clara de responsabilidades
- **Testabilidade:** Componentes isolados facilitam testes unitários
- **Escalabilidade:** Possibilidade de adicionar microsserviços futuramente
- **Produtividade:** Laravel fornece convenções que aceleram o desenvolvimento

### **4.1.2. Diagrama de Arquitetura**

```
┌─────────────────────────────────────────────────────────────┐
│                    Camada de Apresentação                    │
│  ┌─────────────┐  ┌─────────────┐  ┌───────────────────┐  │
│  │   Blade     │  │  Livewire   │  │    Alpine.js      │  │
│  │ Templates   │  │ Components  │  │ (Interatividade)  │  │
│  └─────────────┘  └─────────────┘  └───────────────────┘  │
│           ↓               ↓                 ↓              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Tailwind CSS (Estilos)                  │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                               ↓
┌─────────────────────────────────────────────────────────────┐
│                    Camada de Aplicação                      │
│  ┌─────────────┐  ┌─────────────┐  ┌───────────────────┐  │
│  │ Controllers │←→│   Services  │←→│   Repositories    │  │
│  │  (Laravel)  │  │  (Lógica)   │  │  (Persistência)   │  │
│  └─────────────┘  └─────────────┘  └───────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                               ↓
┌─────────────────────────────────────────────────────────────┐
│                    Camada de Persistência                   │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                  MySQL Database                       │  │
│  │  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌─────────┐ │  │
│  │  │ Usuários │ │ Produtos │ │ Pedidos  │ │ Outras  │ │  │
│  │  │          │ │          │ │          │ │ Tabelas │ │  │
│  │  └──────────┘ └──────────┘ └──────────┘ └─────────┘ │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                               ↓
┌─────────────────────────────────────────────────────────────┐
│                    Camada de Infraestrutura                 │
│  ┌─────────────┐  ┌─────────────┐  ┌───────────────────┐  │
│  │   Storage   │  │   Cache     │  │     Queue         │  │
│  │  (Imagens)  │  │   (Redis)   │  │   (Jobs)          │  │
│  └─────────────┘  └─────────────┘  └───────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## **4.2. Tecnologias e Ferramentas**

### **4.2.1. Stack Tecnológico Completo**

| **Camada**         | **Tecnologia**          | **Versão** | **Propósito**                                                                 |
|--------------------|-------------------------|------------|-------------------------------------------------------------------------------|
| **Backend**        | PHP                     | ≥ 8.2      | Linguagem principal do servidor                                              |
|                    | Laravel                 | ≥ 10.x     | Framework MVC para desenvolvimento rápido e estruturado                       |
|                    | Livewire                | ≥ 3.x      | Componentes reativos no PHP (simula SPA sem JavaScript pesado)               |
| **Frontend**       | Alpine.js               | ≥ 3.x      | Interatividade leve no cliente                                                |
|                    | Tailwind CSS            | ≥ 3.x      | Framework CSS utilitário para design responsivo                              |
|                    | Vite                    | ≥ 4.x      | Build tool para assets (substitui Webpack)                                   |
| **Banco de Dados** | MySQL                   | ≥ 8.0      | Sistema de gerenciamento de banco de dados relacional                         |
|                    | Laravel Eloquent ORM    | -          | Mapeamento objeto-relacional para interação com banco                        |
| **Cache**          | Redis                   | ≥ 7.x      | Cache de sessões, views e queries frequentes                                 |
| **Servidor**       | Nginx/Apache            | -          | Servidor web                                                                 |
|                    | Supervisor              | -          | Gerenciamento de processos (queues)                                          |
| **Ferramentas**    | Composer                | ≥ 2.x      | Gerenciador de dependências PHP                                              |
|                    | Node.js + npm           | ≥ 18.x     | Gerenciador de dependências JavaScript e execução do Vite                    |
|                    | Git                     | -          | Controle de versão                                                           |

### **4.2.2. Justificativa das Escolhas Tecnológicas**

1. **Laravel:** Framework maduro com ecossistema robusto, documentação excelente e comunidade ativa. Ideal para projetos acadêmicos e profissionais.

2. **Livewire + Alpine.js:** Combinação que permite criar interfaces ricas sem a complexidade de frameworks JavaScript pesados como React ou Vue, mantendo a simplicidade do desenvolvimento em PHP.

3. **Tailwind CSS:** Acelera o desenvolvimento frontend através de classes utilitárias, facilita a criação de designs responsivos e suporta nativamente dark mode.

4. **MySQL:** Banco relacional confiável, bem suportado pelo Laravel, com bom desempenho para operações de e-commerce.

## **4.3. Padrões de Projeto Aplicados**

### **4.3.1. Padrões Estruturais**
- **Repository Pattern:** Separa a lógica de acesso a dados dos controllers
- **Service Layer:** Encapsula regras de negócio complexas
- **DTOs (Data Transfer Objects):** Transferência de dados entre camadas
- **View Models:** Prepara dados para as views

### **4.3.2. Padrões Comportamentais**
- **Observer:** Para eventos como "pedido criado", "estoque alterado"
- **Strategy:** Para diferentes métodos de cálculo de frete
- **Factory:** Para criação de diferentes tipos de usuários/roles

### **4.3.3. Padrões Criacionais**
- **Service Container:** Injeção de dependências do Laravel
- **Singleton:** Para serviços como carrinho de compras

## **4.4. Design System e Componentes**

### **4.4.1. Sistema de Design**
Baseado nos documentos `design.md`, `design_admin.md` e `design_cliente.md`, o sistema implementa:

1. **Atomic Design:** Componentes construídos de átomos → moléculas → organismos → templates → páginas
2. **Design Tokens:** Cores, tipografia, espaçamento definidos centralmente
3. **Componentes Reutilizáveis:** Botões, cards, inputs, modais padronizados

### **4.4.2. Componentes Principais**

```php
// Exemplo de componente Livewire
class ProductCard extends Component
{
    public $product;
    public $inCart = false;
    
    public function addToCart()
    {
        // Lógica para adicionar ao carrinho
        $this->inCart = true;
        $this->emit('cartUpdated');
    }
    
    public function render()
    {
        return view('livewire.product-card');
    }
}
```

### **4.4.3. Suporte a Dark/Light Mode**
Implementado via:
1. **Tailwind CSS:** Classes `dark:` para estilos específicos
2. **Alpine.js:** Alternância dinâmica com `x-data`
3. **LocalStorage:** Persistência da preferência do usuário

```javascript
// Toggle de tema com Alpine.js
<div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
     x-init="$watch('darkMode', val => {
         localStorage.setItem('darkMode', val);
         document.documentElement.classList.toggle('dark', val);
     })"
     :class="{ 'dark': darkMode }">
</div>
```

## **4.5. Estrutura de Diretórios do Projeto**

```
b2cstore/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Auth/
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   └── ProductController.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Livewire/
│   │   ├── CartCounter.php
│   │   ├── ProductFilter.php
│   │   └── ThemeToggle.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── Cart.php
│   ├── Providers/
│   ├── Services/
│   │   ├── CartService.php
│   │   ├── PaymentService.php
│   │   └── ShippingService.php
│   └── View/
│       └── Components/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       ├── admin/
│       ├── auth/
│       ├── cart/
│       ├── checkout/
│       └── products/
├── routes/
│   ├── web.php
│   ├── admin.php
│   └── api.php
├── storage/
├── tests/
├── vendor/
├── .env
├── composer.json
└── package.json
```

## **4.6. Modelo de Dados (Baseado em `modelo_de_dados.md`)**

### **4.6.1. Principais Entidades e Relacionamentos**

```php
// Exemplo de Modelo Eloquent
class Product extends Model
{
    protected $primaryKey = 'id_produto';
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_categoria');
    }
    
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_produto');
    }
    
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'carrinho_itens', 
                   'id_produto', 'id_carrinho')
                   ->withPivot('quantidade', 'preco_unitario');
    }
}
```

### **4.6.2. Migrations e Seeders**
- **Migrations:** Definem estrutura do banco de dados
- **Seeders:** Populam dados de teste (produtos, usuários, categorias)
- **Factories:** Geram dados fictícios para testes

```bash
# Comandos para setup do banco
php artisan migrate
php artisan db:seed
php artisan storage:link
```

## **4.7. Segurança e Performance**

### **4.7.1. Medidas de Segurança**
1. **CSRF Protection:** Tokens em todos os formulários
2. **SQL Injection Prevention:** Eloquent ORM com parameter binding
3. **XSS Protection:** Blade templating escapa automaticamente
4. **Authentication:** Laravel Sanctum/Breeze para autenticação segura
5. **Authorization:** Gates e Policies para controle de acesso baseado em roles
6. **Input Validation:** Form Requests do Laravel

### **4.7.2. Otimizações de Performance**
1. **Eager Loading:** Prevenção de N+1 queries
2. **Cache:** Redis para queries frequentes
3. **Queue:** Processamento assíncrono de emails, imagens
4. **Lazy Loading:** Imagens carregadas sob demanda
5. **Pagination:** Limitação de resultados por página

## **4.8. Testes e Qualidade**

### **4.8.1. Estratégia de Testes**
- **Unit Tests:** PHPUnit para testar models, services
- **Feature Tests:** Testes de endpoints e fluxos completos
- **Browser Tests:** Laravel Dusk para testes de UI
- **Performance Tests:** Testes de carga com ferramentas externas

### **4.8.2. Integração Contínua (CI)**
Configuração básica com GitHub Actions:

```yaml
# .github/workflows/tests.yml
name: Tests
on: [push, pull_request]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: vendor/bin/phpunit
```

## **4.9. Implantação e DevOps**

### **4.9.1. Ambiente de Produção**
- **Servidor:** Ubuntu 22.04 LTS
- **Web Server:** Nginx + PHP-FPM
- **Database:** MySQL 8.0 com replicação
- **Cache:** Redis
- **Queue:** Supervisor para gerenciar workers

### **4.9.2. Deployment Process**
```bash
# Script de deploy simplificado
git pull origin main
composer install --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart php8.2-fpm
```

## **4.10. Métricas Técnicas (SRE)**

| **Métrica**          | **Alvo**       | **Monitoramento**                  |
|----------------------|----------------|------------------------------------|
| **Uptime**           | 99.5%          | Uptime Robot                       |
| **Response Time**    | < 200ms        | New Relic / Laravel Telescope      |
| **Error Rate**       | < 0.1%         | Bugsnag / Sentry                   |
| **DB Connections**   | < 80% uso      | MySQL Monitoring                   |
| **Storage Growth**   | Alerta > 80%   | Server Monitoring                  |
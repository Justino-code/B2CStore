# Loja B2C Escolar

## **Descrição do Projeto**

Este projeto é uma **loja online B2C (Business to Consumer)** criada como atividade escolar. O objetivo é permitir que uma única empresa venda produtos diretamente para consumidores finais, oferecendo funcionalidades como navegação de catálogo, carrinho de compras, checkout e histórico de pedidos.

O projeto é desenvolvido utilizando **PHP (Laravel) no backend**, **Livewire e Alpine.js para interatividade**, e **Tailwind CSS** para um design moderno e responsivo.

---

## **Funcionalidades**

### **Frontend**

* **Página Inicial:** destaques de produtos em promoção, categorias e banners.
* **Catálogo de Produtos:** listagem de produtos por categoria, pesquisa e filtros simples.
* **Detalhes do Produto:** imagens, descrição, preço, opções (como tamanho ou cor), botão “Adicionar ao Carrinho”.
* **Carrinho de Compras:** visualização de produtos adicionados, atualização de quantidade, cálculo de subtotal e total.
* **Checkout:** formulário para endereço, método de pagamento e confirmação do pedido.
* **Histórico de Pedidos:** consulta de pedidos anteriores e status.
* **Cadastro/Login:** registro de usuários, login e recuperação de senha.
* **Responsividade:** interface adaptada para desktop e dispositivos móveis.

### **Backend**

* **Gerenciamento de Produtos:** CRUD de produtos, categorias, imagens e controle de estoque.
* **Gerenciamento de Pedidos:** criação, atualização de status (pendente, pago, enviado, entregue).
* **Gestão de Usuários:** autenticação, perfil, histórico de pedidos.
* **Pagamentos Simulados:** para fins escolares, os pagamentos podem ser confirmados manualmente.
* **Segurança:** validação de formulários, proteção de rotas, CSRF/XSS.

### **Funcionalidades Extras**

* Filtros dinâmicos de produtos (Livewire + Alpine.js).
* Validação de estoque em tempo real.
* Notificações simples para ações do usuário.
* Dark mode opcional com Tailwind + Alpine.js.
* Upload de imagens via Laravel Storage.

---

## **Modelo de Dados**

**Tabelas principais:**

* **users:** id, name, email, password, address, created_at, updated_at
* **products:** id, name, description, price, stock, category_id, image_path, created_at, updated_at
* **categories:** id, name, description, created_at, updated_at
* **carts:** id, user_id, created_at, updated_at
* **cart_items:** id, cart_id, product_id, quantity, price, created_at, updated_at
* **orders:** id, user_id, total, status, payment_method, created_at, updated_at
* **order_items:** id, order_id, product_id, quantity, price, created_at, updated_at

---

## **Fluxo de Uso**

```
[Usuário] 
    |
    |---> [Página Inicial / Catálogo de Produtos] 
                |
                |---> [Página de Produto Individual] 
                            |
                            |---> Adiciona ao [Carrinho]
                                        |
                                        |---> [Carrinho de Compras] 
                                                    |
                                                    |---> Ajusta Quantidade / Remove Item
                                                    |
                                                    |---> Vai para [Checkout]
                                                                |
                                                                |---> Insere Endereço / Seleciona Pagamento
                                                                |
                                                                |---> Confirma Pedido ---> [Orders] / [Order Items]
                                                                                   |
                                                                                   |---> Status do Pedido (Pendente, Pago, Enviado, Entregue)
                                                                                   |
                                                                                   |---> [Histórico de Pedidos] (usuário logado)
```

---

## **Tecnologias Utilizadas**

* **Backend:** PHP >= 8.2 + Laravel >= 10
* **Frontend:** Livewire, Alpine.js
* **Estilo:** Tailwind CSS
* **Banco de Dados:** MySQL ou SQLite
* **Autenticação:** Laravel Breeze ou Jetstream (opcional)
* **Armazenamento de Imagens:** Laravel Storage (local)

---

## **Instalação e Configuração**

1. Clone o repositório:

```bash
git clone <URL_DO_REPOSITORIO>
```

2. Acesse a pasta do projeto:

```bash
cd nome-do-projeto
```

3. Instale dependências via Composer:

```bash
composer install
```

4. Configure o arquivo `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

* Ajuste os parâmetros do banco de dados (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5. Execute as migrations:

```bash
php artisan migrate
```

6. (Opcional) Popule o banco com seeders:

```bash
php artisan db:seed
```

7. Inicie o servidor local:

```bash
php artisan serve
```

8. Acesse o site em:

```
http://127.0.0.1:8000
```

---

## **Licença**

Projeto escolar - uso educacional apenas.
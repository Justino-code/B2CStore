## **Escopo do Projeto: Loja B2C Escolar**

### 1. **Objetivo do Projeto**

Criar uma **loja online simples** onde uma única empresa vende produtos diretamente para consumidores finais. O site permitirá navegar pelo catálogo, adicionar produtos ao carrinho, finalizar compras e acompanhar pedidos.

---

### 2. **Funcionalidades Principais**

#### **2.1. Frontend (Interface do Usuário)**

* **Página inicial:** destaque para produtos em promoção, categorias e banners.
* **Página de produtos:** lista de produtos por categoria, filtros simples (preço, categoria), pesquisa.
* **Página de detalhe do produto:** imagens, descrição, preço, opções (tamanho, cor), botão “Adicionar ao Carrinho”.
* **Carrinho de compras:** visualizar produtos adicionados, atualizar quantidade, calcular subtotal, frete e total.
* **Checkout:** formulário para endereço, seleção de método de pagamento, resumo do pedido.
* **Histórico de pedidos:** usuário logado pode ver pedidos anteriores e status.
* **Cadastro/Login:** registro de usuários, login, recuperação de senha.
* **Responsividade:** uso do Tailwind + Alpine.js para comportamento dinâmico e design moderno.

#### **2.2. Backend**

* **Gerenciamento de produtos:** CRUD de produtos, categorias, imagens, estoque.
* **Gerenciamento de pedidos:** criação, atualização do status (pendente, pago, enviado, entregue).
* **Gestão de usuários:** autenticação, perfil, histórico de pedidos.
* **Pagamentos:** integração simulada (para projeto escolar, pode ser “pagamento confirmado” manual).
* **Segurança:** proteção de rotas, validação de formulários, proteção contra CSRF/XSS.

---

### 3. **Modelo de Dados (Banco de Dados)**

#### **3.1. Tabelas principais**

1. **users**

```text
id, name, email, password, address, created_at, updated_at
```

2. **products**

```text
id, name, description, price, stock, category_id, image_path, created_at, updated_at
```

3. **categories**

```text
id, name, description, created_at, updated_at
```

4. **carts**

```text
id, user_id, created_at, updated_at
```

5. **cart_items**

```text
id, cart_id, product_id, quantity, price, created_at, updated_at
```

6. **orders**

```text
id, user_id, total, status, payment_method, created_at, updated_at
```

7. **order_items**

```text
id, order_id, product_id, quantity, price, created_at, updated_at
```

---

### 4. **Funcionalidades Avançadas (Extras)**

* Sistema de **filtros dinâmicos de produtos** (Livewire + Alpine.js).
* Validação de estoque em tempo real antes de adicionar ao carrinho.
* Notificações simples (alertas de produto adicionado, pedido concluído).
* **Dark mode** com Tailwind + Alpine.js (opcional para deixar moderno).
* Upload de imagens para produtos usando Laravel Storage.

---

### 5. **Arquitetura e Fluxo**

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

**Fluxo resumido:**

1. Usuário navega pelo catálogo → escolhe produtos.
2. Adiciona produtos ao carrinho.
3. No carrinho, revisa itens → vai para checkout.
4. Checkout cria pedido → registra em `orders` e `order_items`.
5. Usuário acompanha status → histórico de pedidos.

---

### 6. **Tecnologias**

* **Backend:** PHP > 8.2 + Laravel >=10
* **Frontend:** Livewire (componentes reativos), Alpine.js (interatividade leve)
* **Estilo:** Tailwind CSS
* **Banco de dados:** MySQL ou SQLite (para escola)
* **Autenticação:** Laravel Breeze ou Jetstream (opcional para Livewire)
* **Armazenamento de imagens:** Laravel Storage (local)

# Modelo de Dados

Esta seção descreve a estrutura do banco de dados utilizado na Loja B2C Escolar, com tabelas em português, campos, tipos, relacionamentos e exemplos de uso.

---

## **Tabelas Principais**

### 1. Usuarios

* **Descrição:** Armazena informações dos usuários (clientes).
* **Campos:**

  * `id` (int, PK)
  * `nome` (string)
  * `email` (string, único)
  * `senha` (string, hash)
  * `endereco` (text)
  * `criado_em` (timestamp)
  * `atualizado_em` (timestamp)
* **Exemplo de uso:** Obter todos os pedidos de um usuário:

```php
$usuario = Usuario::find(1);
$pedidos = $usuario->pedidos;
```

### 2. Categorias

* **Descrição:** Categorias para organizar produtos.
* **Campos:**

  * `id` (int, PK)
  * `nome` (string)
  * `descricao` (text, opcional)
  * `criado_em`, `atualizado_em`
* **Relacionamento:** Uma `Categoria` tem muitos `Produtos`.

### 3. Produtos

* **Descrição:** Produtos disponíveis na loja.
* **Campos:**

  * `id` (int, PK)
  * `nome` (string)
  * `descricao` (text)
  * `preco` (decimal)
  * `estoque` (int)
  * `categoria_id` (FK → categorias.id)
  * `caminho_imagem` (string)
  * `criado_em`, `atualizado_em`
* **Relacionamento:** Pertence a uma `Categoria` e pode aparecer em vários `ItensCarrinho` ou `ItensPedido`.

### 4. Carrinhos

* **Descrição:** Carrinho de compras temporário de cada usuário.
* **Campos:**

  * `id` (int, PK)
  * `usuario_id` (FK → usuarios.id)
  * `criado_em`, `atualizado_em`
* **Relacionamento:** Um `Carrinho` tem muitos `ItensCarrinho`.

### 5. ItensCarrinho

* **Descrição:** Itens adicionados ao carrinho.
* **Campos:**

  * `id` (int, PK)
  * `carrinho_id` (FK → carrinhos.id)
  * `produto_id` (FK → produtos.id)
  * `quantidade` (int)
  * `preco` (decimal, preço do produto no momento da adição)
  * `criado_em`, `atualizado_em`
* **Exemplo de uso:** Atualizar a quantidade de um item no carrinho:

```php
$itemCarrinho = ItemCarrinho::find(1);
$itemCarrinho->quantidade = 3;
$itemCarrinho->save();
```

### 6. Pedidos

* **Descrição:** Pedidos realizados pelos usuários.
* **Campos:**

  * `id` (int, PK)
  * `usuario_id` (FK → usuarios.id)
  * `total` (decimal)
  * `status` (enum: pendente, pago, enviado, entregue)
  * `metodo_pagamento` (string)
  * `criado_em`, `atualizado_em`
* **Relacionamento:** Um `Pedido` tem muitos `ItensPedido`.

### 7. ItensPedido

* **Descrição:** Produtos que fazem parte de um pedido.
* **Campos:**

  * `id` (int, PK)
  * `pedido_id` (FK → pedidos.id)
  * `produto_id` (FK → produtos.id)
  * `quantidade` (int)
  * `preco` (decimal, preço unitário no momento da compra)
  * `criado_em`, `atualizado_em`
* **Exemplo de uso:** Listar produtos de um pedido:

```php
$pedido = Pedido::find(1);
foreach ($pedido->itens as $item) {
    echo $item->produto->nome . ' x' . $item->quantidade;
}
```

---

## **Relacionamentos Principais**

* `Usuario` → `Carrinho` → `ItensCarrinho` → `Produtos`
* `Usuario` → `Pedidos` → `ItensPedido` → `Produtos`
* `Categoria` → `Produtos`
* `Produto` → `ItensCarrinho` / `ItensPedido`

---

## **Observações**

* Os campos `criado_em` e `atualizado_em` são preenchidos automaticamente pelo Laravel.
* O campo `preco` em `ItensCarrinho` e `ItensPedido` registra o valor no momento da transação, evitando inconsistências caso o preço do produto seja alterado posteriormente.
* Todos os relacionamentos são definidos usando **Eloquent ORM**, facilitando consultas e manipulações de dados.

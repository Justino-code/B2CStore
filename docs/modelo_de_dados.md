# 🗄️ **Modelo de Dados — B2CStore**

Documentação completa das tabelas, seus campos, tipos e descrições seguindo a nomenclatura **`id_nomeDaEntidade`**.

---

# 1. Tabela: `usuarios`

### **Descrição Geral**

Armazena os dados de todos os usuários cadastrados no sistema, incluindo clientes e administradores.

### **Campos**

| Campo                 | Tipo                    | Obrigatório | Descrição                       |
| --------------------- | ----------------------- | ----------- | ------------------------------- |
| `id_usuario`          | BIGINT                  | Sim         | Identificador único do usuário. |
| `nome`                | VARCHAR(150)            | Sim         | Nome completo do usuário.       |
| `email`               | VARCHAR(150)            | Sim         | E-mail único para autenticação. |
| `email_verificado_em` | TIMESTAMP               | Não         | Quando o e-mail foi verificado. |
| `senha`               | VARCHAR(255)            | Sim         | Senha criptografada.            |
| `telefone`            | VARCHAR(20)             | Não         | Número de telefone.             |
| `endereco`            | TEXT                    | Não         | Endereço completo.              |
| `role`                | ENUM('cliente','admin') | Sim         | Tipo de usuário.                |
| `criado_em`           | TIMESTAMP               | Sim         | Data de criação.                |
| `atualizado_em`       | TIMESTAMP               | Sim         | Última atualização.             |

### **Relacionamentos**

* 1 usuário → N pedidos
* 1 usuário → 1 carrinho
* 1 usuário → N reviews
* 1 usuário → N favoritos

---

# 2. Tabela: `categorias`

### **Descrição Geral**

Armazena todas as categorias disponíveis na loja.

### **Campos**

| Campo           | Tipo         | Obrigatório | Descrição                         |
| --------------- | ------------ | ----------- | --------------------------------- |
| `id_categoria`  | BIGINT       | Sim         | Identificador único da categoria. |
| `nome`          | VARCHAR(100) | Sim         | Nome da categoria.                |
| `descricao`     | TEXT         | Não         | Descrição detalhada da categoria. |
| `criado_em`     | TIMESTAMP    | Sim         | Data de criação.                  |
| `atualizado_em` | TIMESTAMP    | Sim         | Última atualização.               |

### **Relacionamentos**

* 1 categoria → N produtos

---

# 📌 3. Tabela: `produtos`

### **Descrição Geral**

Produtos disponíveis para venda.

### **Campos**

| Campo           | Tipo          | Obrigatório | Descrição                       |
| --------------- | ------------- | ----------- | ------------------------------- |
| `id_produto`    | BIGINT        | Sim         | Identificador único do produto. |
| `id_categoria`  | BIGINT        | Sim         | Categoria do produto.           |
| `nome`          | VARCHAR(200)  | Sim         | Nome do produto.                |
| `descricao`     | TEXT          | Não         | Descrição detalhada.            |
| `preco`         | DECIMAL(10,2) | Sim         | Preço atual.                    |
| `estoque`       | INT           | Sim         | Quantidade disponível.          |
| `imagem_url`    | VARCHAR(255)  | Não         | URL da imagem.                  |
| `criado_em`     | TIMESTAMP     | Sim         | Data de criação.                |
| `atualizado_em` | TIMESTAMP     | Sim         | Última atualização.             |

### **Relacionamentos**

* 1 produto → N itens do carrinho
* 1 produto → N itens do pedido
* 1 produto → N reviews
* 1 produto → N favoritos

---

# 4. Tabela: `carrinhos`

### **Descrição Geral**

Cada usuário possui um único carrinho ativo.

### **Campos**

| Campo           | Tipo      | Obrigatório | Descrição                  |
| --------------- | --------- | ----------- | -------------------------- |
| `id_carrinho`   | BIGINT    | Sim         | Identificador do carrinho. |
| `id_usuario`    | BIGINT    | Sim         | Dono do carrinho.          |
| `criado_em`     | TIMESTAMP | Sim         | Criação.                   |
| `atualizado_em` | TIMESTAMP | Sim         | Última atualização.        |

### **Relacionamentos**

* 1 carrinho → N itens_carrinho
* 1 carrinho → 1 usuário

---

# 5. Tabela: `carrinho_itens`

### **Descrição Geral**

Itens adicionados ao carrinho.

### **Campos**

| Campo              | Tipo          | Obrigatório | Descrição                |
| ------------------ | ------------- | ----------- | ------------------------ |
| `id_item_carrinho` | BIGINT        | Sim         | Identificador único.     |
| `id_carrinho`      | BIGINT        | Sim         | Carrinho relacionado.    |
| `id_produto`       | BIGINT        | Sim         | Produto adicionado.      |
| `quantidade`       | INT           | Sim         | Quantidade do item.      |
| `preco_unitario`   | DECIMAL(10,2) | Sim         | Preço na data da adição. |
| `criado_em`        | TIMESTAMP     | Sim         | Data de criação.         |
| `atualizado_em`    | TIMESTAMP     | Sim         | Atualização.             |

### **Relacionamentos**

* 1 item → 1 carrinho
* 1 item → 1 produto

---

# 6. Tabela: `pedidos`

### **Descrição Geral**

Pedidos finalizados pelos usuários.

### **Campos**

| Campo              | Tipo                                          | Obrigatório | Descrição                  |
| ------------------ | --------------------------------------------- | ----------- | -------------------------- |
| `id_pedido`        | BIGINT                                        | Sim         | Identificador do pedido.   |
| `id_usuario`       | BIGINT                                        | Sim         | Usuário que fez o pedido.  |
| `total`            | DECIMAL(10,2)                                 | Sim         | Total da compra.           |
| `status`           | ENUM('pendente','pago','enviado','cancelado') | Sim         | Estado do pedido.          |
| `endereco_entrega` | TEXT                                          | Sim         | Endereço final de entrega. |
| `criado_em`        | TIMESTAMP                                     | Sim         | Criação.                   |
| `atualizado_em`    | TIMESTAMP                                     | Sim         | Atualização.               |

### **Relacionamentos**

* 1 pedido → N itens do pedido
* 1 pedido → 1 pagamento
* 1 usuário → N pedidos

---

# 7. Tabela: `pedido_itens`

### **Descrição Geral**

Itens incluídos no pedido finalizado.

### **Campos**

| Campo            | Tipo          | Obrigatório | Descrição                    |
| ---------------- | ------------- | ----------- | ---------------------------- |
| `id_item_pedido` | BIGINT        | Sim         | Identificador.               |
| `id_pedido`      | BIGINT        | Sim         | Pedido vinculado.            |
| `id_produto`     | BIGINT        | Sim         | Produto comprado.            |
| `quantidade`     | INT           | Sim         | Quantidade adquirida.        |
| `preco_unitario` | DECIMAL(10,2) | Sim         | Preço do produto no momento. |
| `criado_em`      | TIMESTAMP     | Sim         | Criação.                     |

### **Relacionamentos**

* 1 item_pedido → 1 pedido
* 1 item_pedido → 1 produto

---

# 8. Tabela: `pagamentos`

### **Descrição Geral**

Registra cada pagamento realizado.

### **Campos**

| Campo          | Tipo                                    | Obrigatório | Descrição                 |
| -------------- | --------------------------------------- | ----------- | ------------------------- |
| `id_pagamento` | BIGINT                                  | Sim         | Identificador.            |
| `id_pedido`    | BIGINT                                  | Sim         | Pedido pago.              |
| `metodo`       | ENUM('cartao','paypal','transferencia') | Sim         | Método de pagamento.      |
| `status`       | ENUM('pendente','pago','falhou')        | Sim         | Situação do pagamento.    |
| `valor`        | DECIMAL(10,2)                           | Sim         | Valor pago.               |
| `transacao_id` | VARCHAR(255)                            | Não         | ID externo de referência. |
| `criado_em`    | TIMESTAMP                               | Sim         | Criação.                  |

### **Relacionamentos**

* 1 pagamento → 1 pedido

---

# 9. Tabela: `reviews`

### **Descrição Geral**

Avaliações feitas pelos usuários nos produtos.

### **Campos**

| Campo        | Tipo      | Obrigatório | Descrição             |
| ------------ | --------- | ----------- | --------------------- |
| `id_review`  | BIGINT    | Sim         | Identificador.        |
| `id_produto` | BIGINT    | Sim         | Produto avaliado.     |
| `id_usuario` | BIGINT    | Sim         | Usuário que avaliou.  |
| `rating`     | INT       | Sim         | Nota de 1 a 5.        |
| `comentario` | TEXT      | Não         | Comentário adicional. |
| `criado_em`  | TIMESTAMP | Sim         | Criação.              |

### **Relacionamentos**

* 1 review → 1 produto
* 1 review → 1 usuário

---

# 10. Tabela: `favoritos`

### **Descrição Geral**

Produtos marcados como favoritos pelos usuários.

### **Campos**

| Campo         | Tipo      | Obrigatório | Descrição           |
| ------------- | --------- | ----------- | ------------------- |
| `id_favorito` | BIGINT    | Sim         | Identificador.      |
| `id_usuario`  | BIGINT    | Sim         | Usuário.            |
| `id_produto`  | BIGINT    | Sim         | Produto favoritado. |
| `criado_em`   | TIMESTAMP | Sim         | Data de criação.    |

### **Relacionamentos**

* 1 favorito → 1 usuário
* 1 favorito → 1 produto

---

# ⭐ 11. **Resumo dos Relacionamentos (ER)**

```
usuarios (1)------(1) carrinhos
usuarios (1)------(N) pedidos
usuarios (1)------(N) reviews
usuarios (1)------(N) favoritos

categorias (1)----(N) produtos

produtos (1)------(N) carrinho_itens
produtos (1)------(N) pedido_itens
produtos (1)------(N) reviews
produtos (1)------(N) favoritos

carrinhos (1)-----(N) carrinho_itens

pedidos (1)-------(N) pedido_itens
pedidos (1)-------(1) pagamentos
```
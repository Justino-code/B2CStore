# Fluxo de Uso

Esta seção descreve o passo a passo das ações do usuário e do administrador na Loja B2C Escolar, desde a navegação até a finalização de pedidos.

---

## **1. Usuário – Navegação e Compra**

1. **Página Inicial**

   * O usuário visualiza destaques de produtos, banners e categorias.
   * Pode clicar em uma categoria ou produto específico.

2. **Catálogo de Produtos**

   * Lista todos os produtos disponíveis.
   * Permite filtrar por categoria, preço ou nome.
   * Cada produto possui botão **“Ver Detalhes”**.

3. **Detalhes do Produto**

   * Mostra imagens, descrição, preço, opções (ex.: tamanho, cor).
   * Botão **“Adicionar ao Carrinho”** disponível.
   * Validações:

     * Verifica estoque disponível.
     * Exibe mensagem caso não haja quantidade suficiente.

4. **Carrinho de Compras**

   * Mostra todos os produtos adicionados.
   * Permite:

     * Atualizar quantidade
     * Remover itens
     * Visualizar subtotal e total
   * Botão **“Finalizar Compra”** leva ao checkout.

5. **Checkout**

   * Formulário para inserir:

     * Endereço de entrega
     * Método de pagamento
   * Botão **“Confirmar Pedido”**
   * Validações:

     * Campos obrigatórios
     * Estoque suficiente para cada item
     * Atualização do status do pedido para “Pendente”

6. **Confirmação e Histórico de Pedidos**

   * Após a confirmação:

     * Pedido é registrado em `orders` e `order_items`.
     * Usuário visualiza detalhes do pedido e status.
   * O usuário pode consultar todos os pedidos anteriores em **Histórico de Pedidos**.

---

## **2. Carrinho e Checkout – Fluxo Interno**

* Quando um usuário adiciona um produto:

  1. Verifica se o usuário já possui um `Cart`.
  2. Cria ou atualiza um `CartItem`.
  3. Calcula subtotal e total em tempo real.
  4. No checkout:

     * Cria `Order` com status “Pendente”.
     * Cria `OrderItems` correspondentes aos itens do carrinho.
     * Esvazia o carrinho após a compra.

---

## **3. Administração – Gestão de Produtos e Pedidos**

1. **Produtos**

   * Adicionar, editar ou remover produtos.
   * Gerenciar categorias e imagens.
   * Atualizar estoque em tempo real.

2. **Pedidos**

   * Visualizar pedidos de todos os usuários.
   * Alterar status (Pendente → Pago → Enviado → Entregue).
   * Conferir detalhes de cada pedido.

3. **Usuários**

   * Visualizar lista de usuários.
   * Consultar histórico de pedidos.

---

## **Observações**

* Todos os fluxos possuem validação de dados via Laravel (Request/Livewire validation).
* O sistema é responsivo, então os fluxos funcionam em desktop e mobile.
* Notificações simples podem alertar o usuário sobre alterações no pedido ou problemas no carrinho.
* O fluxo pode ser extendido com pagamentos reais ou integração com gateways, mas neste projeto usamos pagamentos simulados.
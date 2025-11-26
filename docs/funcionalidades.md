# Funcionalidades Detalhadas

Esta seção descreve todas as funcionalidades implementadas no projeto da Loja B2C Escolar, tanto no frontend quanto no backend, incluindo funcionalidades extras e detalhes de implementação.

---

## **Frontend**

### 1. Página Inicial

* **O que faz:** Exibe destaques de produtos em promoção, banners e categorias principais.
* **Objetivo:** Atrair a atenção do usuário e facilitar o acesso rápido às seções mais importantes.
* **Tecnologias envolvidas:** Tailwind CSS para o layout responsivo, Alpine.js para interatividade de banners e sliders.

### 2. Catálogo de Produtos

* **O que faz:** Lista todos os produtos disponíveis, com filtros por categoria, preço e pesquisa por nome.
* **Objetivo:** Permitir que o usuário encontre produtos rapidamente.
* **Tecnologias:** Livewire para atualização dinâmica sem recarregar a página, Tailwind CSS para o layout.

### 3. Detalhes do Produto

* **O que faz:** Mostra informações detalhadas do produto, incluindo imagens, descrição, preço e opções (como tamanho ou cor).
* **Objetivo:** Ajudar o usuário a tomar decisões de compra mais informadas.
* **Tecnologias:** Tailwind CSS e Livewire para atualizar informações dinamicamente (ex.: variações de produto).

### 4. Carrinho de Compras

* **O que faz:** Exibe os produtos adicionados, permite alterar quantidades ou remover itens, e calcula subtotal e total.
* **Objetivo:** Facilitar a gestão da compra antes do checkout.
* **Tecnologias:** Livewire para atualizar o carrinho em tempo real, Alpine.js para animações e feedback visual.

### 5. Checkout

* **O que faz:** Permite ao usuário inserir endereço, escolher método de pagamento e confirmar o pedido.
* **Objetivo:** Concluir a compra de forma segura e prática.
* **Tecnologias:** Laravel para validação de formulários, Livewire para envio de dados sem recarregar, Tailwind CSS para design responsivo.

### 6. Histórico de Pedidos

* **O que faz:** Exibe todos os pedidos realizados pelo usuário logado, incluindo status e detalhes.
* **Objetivo:** Dar visibilidade sobre compras passadas e status de entrega.
* **Tecnologias:** Laravel para consulta ao banco, Tailwind CSS para apresentação clara.

### 7. Cadastro / Login

* **O que faz:** Permite criação de conta, login, logout e recuperação de senha.
* **Objetivo:** Autenticar usuários e proteger áreas restritas do sistema.
* **Tecnologias:** Laravel Breeze/Jetstream para autenticação pronta, Livewire para formulários interativos.

### 8. Responsividade e Dark Mode

* **O que faz:** O layout se adapta a diferentes tamanhos de tela e pode alternar entre modo claro e escuro.
* **Objetivo:** Melhor experiência em dispositivos móveis e opções de visualização.
* **Tecnologias:** Tailwind CSS + Alpine.js para alternância do tema em tempo real.

---

## **Backend**

### 1. Gerenciamento de Produtos

* **O que faz:** CRUD completo de produtos, incluindo imagens, descrição, preço e estoque.
* **Objetivo:** Permitir que o administrador gerencie os produtos da loja.
* **Tecnologias:** Laravel Eloquent para banco de dados, Laravel Storage para imagens.

### 2. Gerenciamento de Pedidos

* **O que faz:** Criação e atualização de pedidos, controle de status (pendente, pago, enviado, entregue).
* **Objetivo:** Monitorar e gerenciar as vendas de forma eficiente.
* **Tecnologias:** Laravel, Eloquent e relacionamentos entre tabelas orders e order_items.

### 3. Gestão de Usuários

* **O que faz:** Registro, autenticação e gerenciamento de perfil do usuário.
* **Objetivo:** Controlar acesso e histórico de cada cliente.
* **Tecnologias:** Laravel Authentication, Eloquent ORM.

### 4. Pagamentos Simulados

* **O que faz:** Para fins educacionais, o pagamento pode ser confirmado manualmente pelo administrador.
* **Objetivo:** Simular o fluxo de pagamento sem integrar gateways externos.
* **Tecnologias:** Laravel, Livewire para atualização do status do pagamento em tempo real.

### 5. Segurança

* **O que faz:** Proteção contra formulários inválidos, CSRF, XSS e validação de dados.
* **Objetivo:** Garantir integridade e segurança da aplicação.
* **Tecnologias:** Laravel Validation, Middleware, Proteção CSRF automática.

---

## **Funcionalidades Extras**

* **Filtros dinâmicos de produtos:** Usuário pode filtrar por categorias e faixa de preço sem recarregar a página (Livewire + Alpine.js).
* **Validação de estoque em tempo real:** Impede que o usuário adicione mais produtos ao carrinho do que o disponível.
* **Notificações simples:** Feedback para ações como adicionar ao carrinho ou finalizar pedido.
* **Upload de imagens:** Imagens de produtos são armazenadas via Laravel Storage, podendo ser exibidas dinamicamente.
* **Dark mode:** Alternância entre tema claro e escuro sem recarregar a página.

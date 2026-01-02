# **Design System e Wireframes da Área Administrativa do Sistema (B2C eCommerce) - Gerenciamento de Loja**

A **área administrativa** do sistema para a **gerência de loja** no **B2C eCommerce** foi projetada para ser **intuitiva**, **eficiente** e **focada na produtividade**, permitindo que os administradores gerenciem todos os aspectos da loja de forma simples, com um design **limpo**, **responsivo** e fácil de navegar. O sistema é preparado para ser implementado com **modos Dark e Light**, utilizando componentes reutilizáveis e um layout responsivo para diferentes dispositivos.

---

## 1. **Paleta de Cores**

| Elemento                | Light Mode               | Dark Mode                        |
| ----------------------- | ------------------------ | -------------------------------- |
| Fundo da página         | #F3F4F6 (cinza claro)    | #111827 (cinza escuro)           |
| Texto                   | #111827 (preto)          | #F3F4F6 (cinza claro)            |
| Cards / Cards de Tabela | #FFFFFF (branco)         | #1F2937 (cinza escuro)           |
| Botões primários        | Azul (#1D4ED8)           | Azul claro ou gradiente adaptado |
| Botões secundários      | Cinza claro / hover azul | Cinza escuro / hover azul claro  |
| Navbar / Footer         | Branco / Cinza claro     | Cinza escuro / Preto             |
| Inputs / Bordas         | Cinza claro              | Cinza escuro (#374151)           |

---

## 2. **Tipografia**

* Fonte: **Inter, sans-serif**
* Títulos: **bold**
* Subtítulos: **semibold**
* Texto padrão: **regular**
* Ajustes de cor baseados no modo ativo (dark/light)

---

## 3. **Componentes principais**

| Componente           | Padrão Light                                                  | Padrão Dark                                 |
| -------------------- | ------------------------------------------------------------- | ------------------------------------------- |
| Botões               | Rounded-md, hover com transição de cor, padding px-4 py-2     | Mesmos estilos, cores adaptadas             |
| Cards de produto     | Shadow-md, padding consistente, fundo branco                  | Shadow-md, fundo escuro (#1F2937)           |
| Inputs / Formulários | Rounded-md, border-gray-300, focus:ring azul                  | Bordas adaptadas, fundo escuro, texto claro |
| Navbar               | Sticky top, fundo branco, links escuros                       | Fundo escuro, links claros                  |
| Footer               | Fundo cinza claro, textos escuros                             | Fundo cinza escuro, textos claros           |
| Layout               | Grid responsivo (`grid-cols-1 sm:grid-cols-2 lg:grid-cols-4`) | Mesma estrutura, cores adaptadas            |

---

## 4. **Telas do sistema**

### 4.1 **Dashboard (Visão Geral da Loja)**

* **Objetivo**: Apresentar uma visão geral rápida e organizada das informações mais relevantes para a gestão da loja.
* **Componentes**:

  * **Saudação personalizada** (exemplo: "Bem-vindo, [Nome do Administrador]!").
  * **Resumo de vendas recentes** (total de vendas, produtos vendidos).
  * **Status de pedidos** (Em andamento, Enviado, Concluído, Cancelado).
  * **Resumo financeiro** (receita, pagamentos, saldo).
  * **Notificações de promoções ou eventos**.
  * Links rápidos para: **Gestão de Produtos**, **Pedidos**, **Promoções**, **Relatórios**.

---

### 4.2 **Gestão de Produtos**

* **Objetivo**: Permitir ao administrador adicionar, editar ou remover produtos da loja.
* **Componentes**:

  * Lista de produtos com nome, preço, estoque, categoria.
  * Botão **Adicionar Produto** para cadastrar novos itens.
  * Filtros para busca (por nome, categoria, preço).
  * Opção para **editar** ou **remover** cada produto.
  * **Visualização rápida** do produto (imagem, descrição, variações).
  * Opção de **definir status** de produto (disponível, esgotado, em promoção).

---

### 4.3 **Gestão de Pedidos**

* **Objetivo**: Permitir ao administrador acompanhar o status dos pedidos realizados pelos clientes.
* **Componentes**:

  * Lista de pedidos com ID, nome do cliente, status, data do pedido e valor total.
  * Filtros de pesquisa (por status de pedido, data, valor).
  * Detalhes de cada pedido (produtos, endereço de entrega, pagamento).
  * Botões de **atualização de status** do pedido (Em processamento, Enviado, Concluído, Cancelado).
  * Opção de **emitir nota fiscal** ou **gerar comprovante de envio**.

---

### 4.4 **Gestão de Estoque**

* **Objetivo**: Permitir ao administrador gerenciar o estoque de produtos, realizando ajustes e visualizando quantidades disponíveis.
* **Componentes**:

  * Lista de produtos com quantidades disponíveis e valores de estoque.
  * Filtros para facilitar a busca por produto e categoria.
  * Opção para **ajustar estoque manualmente** (entrada ou saída de produtos).
  * Relatório de **movimentação de estoque** (entrada/saída, compras pendentes).

---

### 4.5 **Promoções e Cupons**

* **Objetivo**: Permitir a criação e gestão de promoções e cupons de desconto.
* **Componentes**:

  * Lista de promoções ativas e suas condições.
  * Botão **Criar Promoção** (definir tipo, desconto, validade).
  * Opções para editar ou **desativar promoções**.
  * **Gestão de cupons de desconto** (criação, distribuição e expiração).
  * Relatório de **performance das promoções**.

---

### 4.6 **Relatórios**

* **Objetivo**: Gerar relatórios sobre vendas, produtos, clientes e outros aspectos do desempenho da loja.
* **Componentes**:

  * Relatórios de vendas por período (diário, semanal, mensal).
  * Relatórios de produtos mais vendidos, com opção de exportar para Excel.
  * Relatórios financeiros (entradas, saídas, lucros).
  * Relatórios de desempenho de promoções.

---

## 5. **Wireframe padrão de página**

```
--------------------------------
| Navbar (Logo + Menu + Perfil) |
--------------------------------
| Saudação + Resumo da Loja     |
--------------------------------
| Gráficos / Relatórios de Vendas |
--------------------------------
| Gestão de Produtos / Pedidos  |
--------------------------------
| Filtro de Pedidos e Estoque   |
--------------------------------
| Footer (Links / Contato)       |
--------------------------------
```

* **Cards, botões e inputs** seguem o padrão **dark/light**.
* **Layout responsivo** para uma experiência de uso eficiente em diferentes dispositivos.
* **Componentes reutilizáveis** para garantir a consistência visual e funcional.

---

## 6. **Suporte Dark / Light**

* Implementação via **Tailwind CSS (`dark:`)** + **Alpine.js** para alternância de tema.
* **Alternância dinâmica** entre os modos (Dark/Light), com preferência salva no **localStorage**.
* Todos os componentes respeitam o modo ativo, incluindo:

  * Navbar, Footer, Cards, Botões, Inputs, Relatórios, Tabelas.

---

## 7. **Benefícios do padrão**

* **Consistência visual e funcional**: O design proporciona uma interface organizada e intuitiva para o administrador da loja.
* **Design responsivo**: Adaptável a qualquer dispositivo, facilitando o gerenciamento em smartphones e desktops.
* **Facilidade de manutenção**: Componentes reutilizáveis que tornam a manutenção e a escalabilidade do sistema mais ágeis.
* **Experiência eficiente**: Todos os dados importantes para a gestão da loja estão acessíveis de forma rápida e organizada.

---

## 8. **Níveis de Acesso (Roles)**

### 8.1 **Administrador (Admin)**

* **Permissões**:

  * Acesso total ao sistema: pode gerenciar produtos, pedidos, estoque, promoções e configurações.
  * Gestão de usuários: criar, editar e excluir outros administradores e gerentes.
  * Visualização completa de relatórios financeiros, de vendas e de desempenho.
  * Controle total de configurações do sistema, como métodos de pagamento e envio.

* **Objetivo**: Gerenciar toda a loja e seus aspectos operacionais, garantindo o bom funcionamento e a tomada de decisões estratégicas.

---

### 8.2 **Gerente de Produtos (Product Manager)**

* **Permissões**:

  * Gestão de produtos: pode adicionar, editar e remover produtos da loja.
  * Gestão de categorias e estoque.
  * Visualização de relatórios de produtos (desempenho, estoque baixo, etc.).
  * Adicionar e atualizar imagens de produtos.

* **Objetivo**: Focar na administração do catálogo de produtos e garantir que o estoque esteja sempre atualizado.

---

### 8.3 **Gerente de Pedidos (Order Manager)**

* **Permissões**:

  * Visualizar e ger


enciar pedidos: alterar status de pedidos (Em processamento, Enviado, Concluído, Cancelado).

* Emitir notas fiscais e comprovantes de envio.
* Gerenciar devoluções, trocas e reembolsos.
* Acompanhar e atualizar status de entregas e rastreamento.

- **Objetivo**: Garantir que os pedidos sejam processados de maneira eficiente, com atualizações de status e gestão de entregas.

---

### 8.4 **Suporte ao Cliente (Customer Support)**

* **Permissões**:

  * Visualização de pedidos e interações com clientes.
  * Gestão de devoluções e trocas.
  * Registro de interações e problemas resolvidos com clientes.
  * Acesso limitado a relatórios de pedidos e status.

* **Objetivo**: Oferecer suporte eficiente aos clientes, ajudando-os a resolver questões relacionadas aos seus pedidos.
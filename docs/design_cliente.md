# **Design System e Wireframes do B2CStore - Página do Usuário**

A **página do usuário (cliente)** no **B2CStore** foi projetada para oferecer uma experiência de compra **intuitiva**, **responsiva** e **visualmente agradável**, com foco na simplicidade e eficiência. O design será **consistente**, com suporte a **modos Dark e Light**, utilizando uma paleta de cores moderna e componentes reutilizáveis.

---

## 1. **Paleta de Cores**

| Elemento           | Light Mode               | Dark Mode                        |
| ------------------ | ------------------------ | -------------------------------- |
| Fundo da página    | #F3F4F6 (cinza claro)    | #111827 (cinza escuro)           |
| Texto              | #111827 (preto)          | #F3F4F6 (cinza claro)            |
| Cartões / Cards    | #FFFFFF (branco)         | #1F2937 (cinza escuro)           |
| Botões primários   | Azul (#1D4ED8)           | Azul claro ou gradiente adaptado |
| Botões secundários | Cinza claro / hover azul | Cinza escuro / hover azul claro  |
| Navbar / Footer    | Branco / Cinza claro     | Cinza escuro / Preto             |
| Inputs / Bordas    | Cinza claro              | Cinza escuro (#374151)           |

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

### 4.1 **Dashboard (Visão Geral da Conta)**

* **Objetivo**: Apresentar uma visão rápida e organizada das informações mais relevantes da conta do usuário.
* **Componentes**:

  * Saudação personalizada (exemplo: "Bem-vindo, [Nome do Usuário]!").
  * Resumo de pedidos recentes e status (Em andamento, Enviado, Entregue).
  * Exibição de saldo de pontos ou recompensas (se houver).
  * Notificações de promoções ou novidades.
  * Links rápidos para "Carrinho", "Favoritos", "Perfil" e "Meus Pedidos".

---

### 4.2 **Carrinho de Compras**

* **Objetivo**: Exibir os itens que o usuário está prestes a comprar.
* **Componentes**:

  * Lista de produtos com imagem, nome, preço e quantidade.
  * Opções para alterar quantidade ou remover produtos.
  * Subtotal da compra, valor do frete e total.
  * Botão "Finalizar Compra" (mesmo que a compra ainda não seja funcional no MVP).

---

### 4.3 **Favoritos**

* **Objetivo**: Permitir ao usuário salvar produtos para compra futura.
* **Componentes**:

  * Lista de produtos salvos (nome, imagem, preço).
  * Botão "Adicionar ao Carrinho" para facilitar a compra futura.
  * Botão "Remover dos Favoritos" para excluir itens salvos.

---

### 4.4 **Perfil / Minha Conta**

* **Objetivo**: Permitir ao usuário visualizar e editar suas informações pessoais.
* **Componentes**:

  * Exibição de dados pessoais: nome, e-mail, telefone.
  * Endereço de entrega com opção de editar.
  * Alterar senha (caso necessário).
  * Histórico de interações com a loja (compras, pontos, preferências).

---

### 4.5 **Meus Pedidos (Histórico de Compras)**

* **Objetivo**: Exibir os pedidos passados e seus status.
* **Componentes**:

  * Lista de pedidos com nome dos produtos, quantidade, data e status (Pendente, Enviado, Entregue).
  * Link para detalhes do pedido, com produtos comprados, total pago, status do pagamento e rastreamento de envio (se possível).
  * Botão "Repetir Compra" para facilitar a recompra dos mesmos itens.

---

## 5. **Wireframe padrão de página**

```
--------------------------------
| Navbar (Logo + Menu + Carrinho) |
--------------------------------
| Saudação e Resumo de Pedidos   |
--------------------------------
| Resumo de Pontos e Recomendações |
--------------------------------
| Lista de Produtos Favoritos    |
--------------------------------
| Footer (Links / Contato)        |
--------------------------------
```

* Todos os **cards, botões e inputs** seguem o padrão **dark/light**.
* Layout **responsivo** para garantir uma boa experiência em dispositivos móveis e desktop.
* **Componentes reutilizáveis** como botões, cards e inputs garantem consistência no design.

---

## 6. **Suporte Dark / Light**

* Implementação via **Tailwind CSS (`dark:`)** + **Alpine.js** para alternância de tema.
* **Alternância dinâmica** entre os modos (Dark/Light), com preferência salva no **localStorage**.
* Todos os componentes respeitam o modo ativo, incluindo:

  * Navbar, Footer, Cards, Botões, Inputs, Formulários, Banners, Modais.

---

## 7. **Benefícios do padrão**

* **Consistência visual e funcional**: O design oferece uma experiência de usuário sem fricções, com transições suaves e visuais agradáveis.
* **Design responsivo**: Adaptável a qualquer dispositivo, desde smartphones até desktops.
* **Personalização do tema**: O modo Dark/Light é flexível e ajusta toda a interface do site.
* **Facilidade de manutenção**: O uso de componentes reutilizáveis torna a manutenção e o crescimento do sistema mais fáceis.
* **Experiência de usuário aprimorada**: Oferece uma navegação fluida e simples, com todas as informações importantes à mão.

---

Este documento serve como **referência principal** para o desenvolvimento das páginas do **usuário (cliente)** no **B2CStore**, garantindo **qualidade visual, funcionalidade e consistência** em todas as telas, com foco na **simplicidade** e **eficiência**.

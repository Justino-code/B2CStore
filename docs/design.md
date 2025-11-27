# Design System e Wireframes do B2CStore

O **B2CStore** será uma loja online completa no modelo B2C, com **suporte total a modos Dark e Light**, responsividade, design moderno e consistente. Este documento detalha **todos os componentes, telas e padrões** que serão usados.

---

## 1. Paleta de cores

| Elemento        | Light Mode                        | Dark Mode                       |
|-----------------|----------------------------------|--------------------------------|
| Fundo da página | #F3F4F6 (cinza claro)            | #111827 (cinza escuro)         |
| Texto           | #111827 (preto)                  | #F3F4F6 (cinza claro)          |
| Cartões / Cards | #FFFFFF (branco)                 | #1F2937 (cinza escuro)         |
| Botões primários | Azul (#1D4ED8)                   | Azul claro ou gradiente adaptado|
| Botões secundários | Cinza claro / hover azul        | Cinza escuro / hover azul claro |
| Navbar / Footer | Branco / Cinza claro             | Cinza escuro / Preto            |
| Inputs / Bordas | Cinza claro                       | Cinza escuro (#374151)         |

---

## 2. Tipografia

- Fonte: **Inter, sans-serif**
- Títulos: **bold**
- Subtítulos: **semibold**
- Texto padrão: **regular**
- Ajustes de cor baseados no modo ativo (dark/light)

---

## 3. Componentes principais

| Componente       | Padrão Light                    | Padrão Dark                      |
|-----------------|--------------------------------|---------------------------------|
| Botões           | Rounded-md, hover com transição de cor, padding px-4 py-2 | Mesmos estilos, cores adaptadas |
| Cards de produto | Shadow-md, padding consistente, fundo branco | Shadow-md, fundo escuro (#1F2937) |
| Inputs / Formulários | Rounded-md, border-gray-300, focus:ring azul | Bordas adaptadas, fundo escuro, texto claro |
| Navbar           | Sticky top, fundo branco, links escuros | Fundo escuro, links claros |
| Footer           | Fundo cinza claro, textos escuros | Fundo cinza escuro, textos claros |
| Layout           | Grid responsivo (`grid-cols-1 sm:grid-cols-2 lg:grid-cols-4`) | Mesma estrutura, cores adaptadas |

---

## 4. Telas do sistema

### 4.1 Homepage
- Navbar (Logo + Menu + Carrinho)
- Banner principal promocional
- Destaque de categorias
- Lista de produtos em grid
- Seção de produtos em promoção
- Footer com links, contato e redes sociais

### 4.2 Página de Categoria
- Filtros: preço, categorias, avaliação
- Grid de produtos
- Paginação ou carregamento infinito

### 4.3 Página de Detalhe do Produto
- Imagens do produto (slider)
- Nome, descrição, preço, estoque
- Opções de variações (tamanho, cor)
- Botão “Adicionar ao Carrinho”
- Produtos relacionados / sugestão

### 4.4 Carrinho de Compras
- Lista de produtos adicionados
- Quantidade ajustável
- Subtotal, frete, total
- Botão “Finalizar Compra”

### 4.5 Checkout
- Formulário de endereço completo
- Seleção de método de pagamento (simulado)
- Resumo do pedido
- Botão “Confirmar Pedido”

### 4.6 Login / Cadastro
- Formulários limpos, centralizados
- Recuperação de senha
- Alternância dark/light visível
- Mensagens de erro claras

### 4.7 Histórico de Pedidos
- Lista de pedidos do usuário
- Status do pedido (Pendente, Pago, Enviado, Entregue)
- Detalhes do pedido e produtos comprados

### 4.8 Admin (opcional para escola)
- CRUD de produtos e categorias
- Gestão de pedidos e atualização de status
- Estatísticas: vendas totais, produtos mais vendidos, usuários

### 4.9 Páginas adicionais
- Sobre a loja
- Contato
- Termos e Condições / Política de Privacidade
- Página 404 (não encontrado)

---

## 5. Wireframe padrão de página

```
--------------------------------
| Navbar (Logo + Menu + Carrinho) |
--------------------------------
| Banner / Destaque                |
--------------------------------
| Conteúdo principal (Cards / Form)|
--------------------------------
| Footer (Links / Contato)         |
--------------------------------
```

- Todos os **cards, botões e inputs** seguem o padrão dark/light
- Layout responsivo
- Componentes reutilizáveis e consistentes

---

## 6. Suporte Dark / Light

- Implementado via **Tailwind CSS (`dark:`)** + **Alpine.js**
- Alternância dinâmica pelo usuário
- Preferência salva em **localStorage**
- Todos os componentes respeitam o modo ativo, incluindo:
  - Navbar, Footer, Cards, Botões, Inputs, Forms, Banners, Modais

---

## 7. Benefícios do padrão

- Design consistente e profissional
- Layout moderno e responsivo
- Experiência de usuário melhorada com dark/light mode
- Facilita desenvolvimento e manutenção
- Perfeito para apresentação escolar

---

Este documento servirá como **referência principal** durante todo o desenvolvimento do projeto B2CStore, garantindo **qualidade visual, funcional e consistência** em todas as telas.
````
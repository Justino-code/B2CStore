# **2. ANÁLISE DE NEGÓCIO**

## **2.1. Contexto do Negócio**
O **B2CStore** posiciona-se como uma solução de e-commerce **Business-to-Consumer (B2C)**, onde a empresa atua como vendedor direto ao consumidor final. Este modelo é particularmente relevante no contexto angolano, onde pequenos e médios comerciantes buscam expandir suas operações para o digital, mas enfrentam barreiras técnicas e financeiras para desenvolver plataformas robustas.

O sistema é projetado para ser **white-label**, ou seja, pode ser configurado para diferentes nichos de mercado (moda, eletrônicos, supermercado, etc.), oferecendo flexibilidade para adaptação a diversos segmentos do mercado angolano.

## **2.2. Modelo de Negócio**
| **Componente**            | **Descrição**                                                                 |
|---------------------------|------------------------------------------------------------------------------|
| **Tipo de Receita**       | Venda direta de produtos físicos/digitais                                    |
| **Canais de Venda**       | Website responsivo, potencial integração com marketplaces locais             |
| **Relacionamento**        | Self-service (autoatendimento), suporte via chat/email, fidelização (cupons) |
| **Segmentos de Clientes** | Consumidores finais angolanos com acesso à internet e disposição para compras online |
| **Recursos Principais**   | Plataforma tecnológica, catálogo de produtos, sistema de pagamento simulado  |
| **Atividades-Chave**      | Desenvolvimento, manutenção da plataforma, gestão de catálogo e pedidos     |
| **Parcerias**             | Gateway de pagamento (futuro), serviços de logística, fornecedores          |
| **Estrutura de Custos**   | Hospedagem, domínio, manutenção, marketing digital                          |

## **2.3. Proposta de Valor**
O B2CStore oferece aos seus usuários (consumidores) e administradores (lojistas) os seguintes valores:

### **Para o Consumidor:**
- **Conveniência:** Compras 24/7 de qualquer dispositivo com internet
- **Variedade:** Catálogo organizado por categorias com múltiplos filtros
- **Transparência:** Preços claros, detalhes completos dos produtos e status de pedido em tempo real
- **Experiência Personalizada:** Área do cliente com histórico, favoritos e recomendações
- **Flexibilidade Visual:** Modo claro e escuro conforme preferência do usuário

### **Para o Lojista/Administrador:**
- **Controle Total:** Painel administrativo completo para gestão de produtos, pedidos, estoque e usuários
- **Baixa Barreira de Entrada:** Solução pronta, sem necessidade de grande investimento em desenvolvimento
- **Escalabilidade:** Arquitetura preparada para crescimento no número de produtos e transações
- **Insights:** Relatórios básicos de vendas e desempenho de produtos
- **Segurança:** Sistema com autenticação, validação de dados e proteção contra vulnerabilidades comuns

## **2.4. Processos de Negócio Mapeados**

### **Processo Principal: Venda Online**
```
Cliente navega → Seleciona produto → Adiciona ao carrinho → Finaliza compra (checkout) 
→ Pagamento (simulado) → Confirmação → Processamento pelo administrador → Envio → Entrega
```

### **Subprocessos Críticos:**
1. **Gestão de Catálogo:** Adição/edição/remoção de produtos e categorias
2. **Processamento de Pedidos:** Atualização de status (pendente → pago → enviado → entregado)
3. **Gestão de Estoque:** Controle de disponibilidade e alertas de baixo estoque
4. **Suporte ao Cliente:** Resolução de dúvidas, trocas e devoluções

## **2.5. Regras de Negócio Identificadas**

1. **Estoque:** Não é possível comprar quantidade superior à disponível em estoque
2. **Preços:** O preço promocional substitui o preço normal quando aplicável
3. **Cupons:** Aplicáveis apenas se o pedido atingir valor mínimo e dentro do prazo de validade
4. **Pedidos:** Apenas usuários autenticados podem finalizar compras
5. **Pagamentos:** No MVP, pagamentos são simulados com confirmação manual pelo administrador
6. **Frete:** Cálculo baseado em peso/dimensões (a ser implementado em fase posterior)
7. **Reviews:** Apenas clientes que compraram o produto podem avaliá-lo
8. **Níveis de Acesso:** Administradores, gerentes e suporte possuem permissões diferenciadas

## **2.6. Métricas de Sucesso (KPIs)**

| **KPI**                     | **Descrição**                                  | **Meta**                     |
|-----------------------------|-----------------------------------------------|------------------------------|
| Taxa de Conversão           | % de visitantes que realizam uma compra       | 2-3% (média e-commerce)     |
| Ticket Médio                | Valor médio por pedido                        | A definir conforme nicho     |
| Taxa de Abandono do Carrinho| % de carrinhos não finalizados                | < 70%                        |
| Tempo de Processamento      | Tempo entre pedido e envio                    | < 24h                       |
| Satisfação do Cliente       | Baseado em reviews e avaliações               | Média ≥ 4.0 (escala 1-5)    |
| Disponibilidade do Sistema  | Uptime da plataforma                          | > 99.5%                      |

## **2.7. Riscos de Negócio Identificados**

| **Risco**                     | **Impacto** | **Probabilidade** | **Mitigação**                              |
|-------------------------------|-------------|-------------------|--------------------------------------------|
| Falha no sistema de pagamento | Alto        | Médio             | Implementação de fallback manual           |
| Ataques cibernéticos          | Alto        | Médio             | Segurança reforçada, backups regulares     |
| Competição de marketplaces    | Médio       | Alta              | Diferenciação por nicho e atendimento      |
| Logística deficiente          | Alto        | Alta (em Angola)  | Parcerias com múltiplas transportadoras    |
| Alterações regulatórias       | Médio       | Baixa             | Monitoramento contínuo do marco legal      |
| Variação cambial              | Médio       | Alta              | Preços em Kwanza, revisão periódica        |

## **2.8. Considerações para o Mercado Angolano**

1. **Conectividade:** Design otimizado para baixa largura de banda (imagens comprimidas, lazy loading)
2. **Pagamentos:** Preparado para integração com soluções locais (e.g., Multicaixa, Carteiras Digitais)
3. **Logística:** Campos de endereço adaptados à realidade angolana (bairros, municípios, províncias)
4. **Idioma:** Interface em português, com possibilidade de expansão para línguas nacionais
5. **Confiança:** Sistema de reviews e selos de segurança para aumentar credibilidade
6. **Mobile-first:** 68% dos angolanos acessam internet principalmente via smartphone (dados 2023)

---

**Próximo tema a ser desenvolvido: Estudo do Mercado (Angola)**  
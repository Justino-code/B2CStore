# Tecnologias Utilizadas

Esta seção lista todas as tecnologias, frameworks e ferramentas usadas no projeto, com explicação de como cada uma contribui para o sistema.

---

## **1. Backend**

* **PHP >= 8.2:** Linguagem de programação principal.
* **Laravel >= 10:** Framework PHP para desenvolvimento ágil e estruturado, responsável pelo backend, rotas, controllers, models e segurança.
* **Laravel Breeze ou Jetstream:** Kits de autenticação prontos para Laravel (opcional).

---

## **2. Frontend**

* **Livewire:** Permite criar componentes reativos no Laravel sem depender de frameworks JS pesados.
* **Alpine.js:** Biblioteca JavaScript minimalista para interatividade e dinamismo no frontend.
* **Tailwind CSS:** Framework CSS utilitário que facilita criar layouts responsivos e modernos.
* **Dark Mode:** Implementado usando Tailwind CSS + Alpine.js para alternar temas.

---

## **3. Banco de Dados**

* **MySQL ou SQLite:** Armazenamento de dados do sistema.
* **Migrations do Laravel:** Para criação e atualização das tabelas de forma automatizada.
* **Seeders:** Para popular dados iniciais (produtos, categorias, usuários de teste).

---

## **4. Armazenamento de Imagens**

* **Laravel Storage:** Para salvar imagens de produtos e assets do sistema de forma organizada.

---

## **5. Ferramentas de Desenvolvimento**

* **Composer:** Gerenciamento de dependências PHP.
* **Node.js + npm:** Para instalar dependências do frontend (Tailwind, Alpine.js, etc.).
* **Git:** Controle de versão do projeto.

---

## **Observações**

* O projeto segue arquitetura MVC do Laravel.
* Toda interação dinâmica no frontend utiliza Livewire e Alpine.js.
* Layout e design seguem boas práticas de responsividade e UX moderno.

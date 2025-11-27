# Instalação e Configuração Detalhada

Este guia fornece instruções completas para configurar o projeto **Loja B2C Escolar** localmente, incluindo backend Laravel e frontend com Vite/Node.js.

---

## **1. Clonar o Repositório**

```bash
git clone https://github.com/Justino-code/B2CStore.git
cd B2CStore
```

---

## **2. Instalar Dependências do Backend**

* Certifique-se de ter **PHP >= 8.2** e **Composer** instalados.

```bash
composer install
```

* Isso irá baixar todas as dependências do Laravel necessárias para o backend.

---

## **3. Configurar Variáveis de Ambiente**

* Copie o arquivo de exemplo `.env.example` para `.env`:

```bash
cp .env.example .env
```

* Gere a chave do aplicativo:

```bash
php artisan key:generate
```

* Configure o banco de dados no arquivo `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

---

## **4. Executar Migrations e Seeders**

* Para criar as tabelas do banco:

```bash
php artisan migrate
```

* Para popular dados iniciais (produtos, categorias, usuários):

```bash
php artisan db:seed
```

---

## **5. Instalar Dependências do Frontend**

* Certifique-se de ter **Node.js >= 18** e **npm** instalados.

```bash
npm install
```

* Isso instalará **Tailwind CSS**, **Alpine.js**, **Vite** e outras dependências de frontend.

---

## **6. Compilar Assets com Vite**

* Para desenvolvimento (watch + hot reload):

```bash
npm run dev
```

* Para produção (minificação e otimização):

```bash
npm run build
```

---

## **7. Iniciar o Servidor Laravel**

```bash
php artisan serve
```

* Acesse o site em:

```
http://127.0.0.1:8000
```

---

## **8. Observações Adicionais**

* Node.js é necessário apenas para compilar e gerenciar os assets do frontend.
* O sistema usa **Laravel Storage** para gerenciar imagens de produtos.
* Os pagamentos são simulados; não há integração real com gateways.
* Certifique-se de configurar permissões corretas para a pasta `storage` e `bootstrap/cache`.
* Para desenvolvimento, é recomendado usar `npm run dev` para ativar hot reload no frontend.

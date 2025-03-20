# 📦 Projeto Laravel + Nuxt.js

Este projeto é uma aplicação web full stack desenvolvida com **Laravel 11** (backend) e **Nuxt.js** (frontend), permitindo a gestão de produtos com autenticação JWT, filtros avançados, exportação para XLSX e armazenamento de imagens no banco de dados.

---

## 🚀 Tecnologias Utilizadas

### Backend (Laravel 11)
- **Laravel 11** (Framework PHP)
- **Eloquent ORM** (Manipulação do banco de dados)
- **JWT Authentication** (Autenticação segura)
- **MySQL** (Banco de dados relacional)
- **Migrations e Seeders** (Gerenciamento do banco de dados)

### Frontend (Nuxt.js)
- **Nuxt.js 3** (Framework Vue.js para SSR e SPA)
- **TailwindCSS** (Estilização)
- **XLSX e FileSaver** (Exportação de dados)

---

## 📌 Funcionalidades

### ✅ Backend (API Laravel)
- CRUD completo de produtos
- Autenticação de usuários via **JWT**
- Filtros dinâmicos para listagem de produtos

### ✅ Frontend (Nuxt.js)
- Interface moderna e responsiva
- Autenticação e gerenciamento de usuários
- Listagem e filtragem de produtos **(nome, categoria, preço)**
- Exportação de produtos para **Excel (.xlsx)**

---

## 🔧 Configuração e Instalação

### 📌 **1. Clonar o repositório**
```bash
# Clonar o projeto
git clone https://github.com/JoseToitio/desafio-kinsol-tech.git
cd nome-do-repositorio
```

### 📌 **2. Configuração do Backend (Laravel)**
```bash
cd backend
composer install
php artisan key:generate
```

### 📌 **3. Configuração do Banco de Dados**
Crie um banco de dados MySQL e configure o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Execute as migrações e seeders:
```bash
php artisan migrate --seed
```

Gerar a chave JWT para autenticação:
```bash
php artisan jwt:secret
```

Iniciar o servidor Laravel:
```bash
php artisan serve
```

### 📌 **4. Configuração do Frontend (Nuxt.js)**
```bash
cd frontend
npm install
cp .env.example .env
```

Edite o `.env` para apontar para a API Laravel:
```env
NUXT_PUBLIC_API_BASE=http://127.0.0.1:8000/api
```

Iniciar o servidor Nuxt.js:
```bash
npm run dev
```

---

## 🔥 Uso da API

### 📌 **Autenticação (JWT)**
**Registro de usuário:**
```bash
POST /api/register
{
  "name": "Usuário Teste",
  "email": "usuario@email.com",
  "password": "senha123"
}
```

**Login:**
```bash
POST /api/login
{
  "email": "usuario@email.com",
  "password": "senha123"
}
```

**Obter lista de produtos:**
```bash
GET /api/products
```

---

## 📦 Exportação de Produtos para XLSX

Na interface do Nuxt.js, há um botão para **exportar a lista de produtos** para **Excel** usando as bibliotecas `xlsx` e `file-saver`.



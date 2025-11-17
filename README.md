# 🏥 SaaS Clínica - Sistema Multi-tenant de Gestão de Clínicas

**Trabalho Final - Desenvolvimento Web 3**

**Desenvolvido por:**

-   Pedro Otávio Lopes
-   João Pedro Padovan

---

## 📋 Sobre o Projeto

Sistema multi-tenant de gestão de clínicas médicas desenvolvido em Laravel 12, permitindo o gerenciamento completo de múltiplas clínicas, pacientes e consultas com sistema de autorização granular baseado em papéis (Owner e Staff).

### Funcionalidades Principais

-   🔐 **Autenticação** - Login/Registro sem starter kits
-   🏢 **Gestão de Clínicas** - CRUD completo com controle de membros
-   👥 **Gestão de Pacientes** - Cadastro com dados pessoais e histórico
-   📅 **Gestão de Consultas** - Agendamento com status e responsáveis
-   🔒 **Autorização Granular** - Laravel Policies com isolamento multi-tenant

---

## 🛠️ Tecnologias Utilizadas

-   **Laravel 12.x** - Framework PHP
-   **PHP 8.2+** - Linguagem
-   **MySQL 8.0** - Banco de dados
-   **Bootstrap 5.3** - Interface responsiva
-   **Laravel Sail** - Ambiente Docker
-   **Docker Compose** - Orquestração de containers

---

## 📦 Requisitos

-   Docker e Docker Compose
-   Git
-   WSL 2 (Windows) ou Linux/macOS

---

## 🚀 Instalação e Configuração

### 1. Clonar o Repositório

```bash
git clone https://github.com/seu-usuario/saas-clinica-laravel.git
cd saas-clinica-laravel
```

### 2. Instalar Dependências

```bash
composer install
```

### 3. Configurar Ambiente

```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
./vendor/bin/sail artisan key:generate
```

### 4. Configurar .env

Edite o arquivo `.env` e ajuste se necessário:

```env
APP_NAME="SaaS Clínica"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=saas_clinica
DB_USERNAME=sail
DB_PASSWORD=password
```

### 5. Iniciar Aplicação

```bash
# Subir containers Docker
./vendor/bin/sail up -d

# Executar migrations
./vendor/bin/sail artisan migrate

# Popular banco com dados de teste
./vendor/bin/sail artisan db:seed
```

### 6. Acessar Sistema

```
http://localhost
```

---

## 🔑 Credenciais de Teste

### Clínica Santa Maria

**Owner (Proprietário):**

-   Email: `joao@example.com`
-   Senha: `password`

**Staff (Equipe):**

-   Email: `maria@example.com`
-   Senha: `password`

### Clínica São Lucas

**Owner:**

-   Email: `carlos@example.com`
-   Senha: `password`

**Staff:**

-   Email: `ana@example.com`
-   Senha: `password`

---

## 💻 Comandos Úteis

```bash
# Alias para facilitar (opcional)
alias sail='./vendor/bin/sail'

# Iniciar aplicação
sail up -d

# Parar aplicação
sail down

# Ver logs
sail logs -f

# Limpar caches
sail artisan config:clear
sail artisan route:clear
sail artisan cache:clear

# Recriar banco de dados
sail artisan migrate:fresh --seed

# Listar rotas
sail artisan route:list
```

---

## 🔐 Sistema de Autorização

### Papéis

#### 👑 Owner (Proprietário)

-   Acesso completo à sua clínica
-   Pode editar e deletar a clínica
-   Pode gerenciar todos os pacientes e consultas
-   Pode adicionar/remover membros da equipe

#### 👨‍⚕️ Staff (Equipe)

-   Acesso de leitura à clínica
-   **NÃO pode** editar ou deletar a clínica
-   Pode cadastrar pacientes e consultas
-   Pode editar/deletar **apenas suas próprias consultas**
-   **NÃO pode** deletar pacientes

### Isolamento Multi-tenant

-   ✅ Usuários só acessam dados da **sua clínica**
-   ❌ Usuários **não podem** acessar dados de **outras clínicas**
-   ✅ Todas as consultas filtradas automaticamente por organização

---

## 📚 Tecnologias e Conceitos Aplicados

-   **MVC Pattern** - Model-View-Controller
-   **ORM** - Eloquent para relacionamentos
-   **RBAC** - Role-Based Access Control
-   **Multi-tenancy** - Isolamento de dados por organização
-   **Laravel Policies** - Autorização granular
-   **Form Requests** - Validações robustas
-   **Blade Templates** - Views responsivas
-   **Docker** - Containerização com Sail

---

## 🎓 Informações Acadêmicas

**Disciplina:** Sistemas Web 3

**Instituição:** Faculdade Reges de Ribeirão Preto

**Semestre:** 2024.2

**Objetivo:** Desenvolvimento de sistema SaaS multi-tenant com Laravel, aplicando conceitos de autorização, validação e arquitetura MVC.

---

## 📄 Licença

Projeto desenvolvido para fins **educacionais** como Trabalho Final da disciplina de Desenvolvimento Web 3.

---

**Última atualização:** Novembro 2024

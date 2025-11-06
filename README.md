# 🏥 SaaS Clínica - Sistema Multi-tenant de Gestão Clínica

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

Sistema SaaS multi-tenant para gestão de clínicas médicas desenvolvido com Laravel 12. Projeto acadêmico da disciplina de Desenvolvimento Web II focado em **autorização multi-tenant com Laravel Policies**.

---

## 📋 Sobre o Projeto

Aplicação SaaS que permite múltiplas clínicas operarem de forma isolada no mesmo sistema. Implementa autorização robusta baseada em papéis (Owner/Staff) com controle granular de permissões usando Laravel Policies.

### 🎯 Funcionalidades Principais

- **Multi-tenancy:** Isolamento completo de dados entre clínicas
- **Gestão de Clínicas:** CRUD com controle de membros (Owner/Staff)
- **Cadastro de Pacientes:** Dados básicos vinculados à clínica
- **Agendamento de Consultas:** Sistema completo com status e responsável
- **Autorização Granular:** Policies para cada tipo de operação
- **Autenticação Manual:** Implementada sem starter kits

---

## 🛠️ Tecnologias

- **Backend:** Laravel 12 (PHP 8.3)
- **Banco de Dados:** MySQL 8.0
- **Frontend:** Blade Templates + Bootstrap 5
- **Containerização:** Docker + Laravel Sail
- **Controle de Versão:** Git + GitHub

---

## 🏗️ Arquitetura

### Entidades Principais
```
Users ←→ Organization_User (pivot) ←→ Organizations
                                           ↓
                                       Patients
                                           ↓
                                     Appointments
```

### Papéis (Roles)

- **Owner:** Controle total da clínica (gerenciar membros, deletar dados)
- **Staff:** Equipe médica (criar/editar consultas e pacientes)

### Políticas de Autorização

| Recurso | Visualizar | Criar | Editar | Deletar |
|---------|------------|-------|--------|---------|
| Organizations | Membro | Autenticado | Owner | Owner |
| Patients | Membro | Staff/Owner | Staff/Owner | Owner |
| Appointments | Membro | Staff/Owner | Owner/Responsável | Owner/Responsável |

---

## 🚀 Setup do Projeto

### Pré-requisitos

- Docker Desktop
- WSL2 (Windows) ou Linux/macOS
- Git

### Instalação

1. **Clone o repositório**
```bash
   git clone https://github.com/seu-usuario/saas-clinica-laravel.git
   cd saas-clinica-laravel
```

2. **Copie o arquivo de ambiente**
```bash
   cp .env.example .env
```

3. **Suba os containers Docker**
```bash
   ./vendor/bin/sail up -d
```

4. **Instale as dependências**
```bash
   ./vendor/bin/sail composer install
```

5. **Gere a chave da aplicação**
```bash
   ./vendor/bin/sail artisan key:generate
```

6. **Execute as migrations**
```bash
   ./vendor/bin/sail artisan migrate
```

7. **Popule o banco com dados de teste**
```bash
   ./vendor/bin/sail artisan db:seed
```

8. **Acesse a aplicação**
   - URL: http://localhost

---

## 👥 Usuários de Teste

Após rodar o seeder, você pode usar:

| Email | Senha | Papel | Clínica |
|-------|-------|-------|---------|
| owner@clinica1.com | password | Owner | Clínica Exemplo 1 |
| staff@clinica1.com | password | Staff | Clínica Exemplo 1 |
| owner@clinica2.com | password | Owner | Clínica Exemplo 2 |

---

## 📁 Estrutura do Projeto
```
app/
├── Enums/              # Role, AppointmentStatus
├── Http/
│   ├── Controllers/    # Lógica de controle
│   ├── Requests/       # Validações (Form Requests)
│   └── Middleware/     # Middleware customizado
├── Models/             # Eloquent Models
└── Policies/           # Autorização (Policies)

database/
├── migrations/         # Estrutura do banco
└── seeders/           # Dados de teste

resources/views/        # Templates Blade
routes/web.php         # Rotas da aplicação
```

---

## 🧪 Comandos Úteis
```bash
# Subir ambiente
./vendor/bin/sail up -d

# Rodar migrations
./vendor/bin/sail artisan migrate

# Limpar e recriar banco
./vendor/bin/sail artisan migrate:fresh --seed

# Acessar MySQL
./vendor/bin/sail mysql

# Logs em tempo real
./vendor/bin/sail logs -f

# Desligar ambiente
./vendor/bin/sail down
```

---

## 👨‍💻 Autor

**Pedro Otavio Lopes da Silva**
- GitHub: https://github.com/pdrlps1
- LinkedIn: https://linkedin.com/in/pedro-otavio-lopes

---

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais como parte da disciplina de Desenvolvimento Web 3.

---

## 🙏 Agradecimentos

- Professor Marcos pela orientação
- Documentação oficial do Laravel
- Comunidade Laravel Brasil

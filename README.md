# 🦺 Gerenciador de EPIs

Sistema web completo para gerenciamento de Equipamentos de Proteção Individual (EPIs) desenvolvido em Laravel 12 com Tailwind CSS.

## 📋 Descrição

O **Gerenciador de EPIs** é uma aplicação web desenvolvida para facilitar o controle e gestão de Equipamentos de Proteção Individual em empresas. O sistema permite o cadastro de colaboradores, EPIs, controle de estoque, registro de entregas e geração de relatórios.

## 🚀 Tecnologias Utilizadas

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade Templates + Tailwind CSS
- **Autenticação:** Laravel Breeze
- **Database:** SQLite (configurável para MySQL/PostgreSQL)
- **Ícones:** Heroicons via Blade UI Kit
- **Build Tools:** Vite

## 📁 Estrutura do Projeto

```
gerenciador-epis-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── CargoController.php
│   │   ├── ColaboradorController.php
│   │   ├── DashboardController.php
│   │   ├── DepartamentoController.php
│   │   ├── EntregaEpiController.php
│   │   ├── EpiController.php
│   │   └── RelatorioController.php
│   └── Models/
│       ├── Cargo.php
│       ├── Colaborador.php
│       ├── Departamento.php
│       ├── EntregaEpi.php
│       ├── Epi.php
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   ├── cargos/
│   │   ├── colaboradores/
│   │   ├── components/
│   │   ├── departamentos/
│   │   ├── entregas/
│   │   ├── epis/
│   │   └── layouts/
│   ├── css/
│   └── js/
└── routes/
    └── web.php
```

## 🎯 Funcionalidades Principais

### 👥 **Gestão de Recursos Humanos**
- **Departamentos:** Cadastro e gerenciamento de departamentos da empresa
- **Cargos:** Cadastro e gerenciamento de cargos/funções
- **Colaboradores:** Gestão completa de colaboradores com vinculação a departamentos e cargos

### 🦺 **Gestão de EPIs**
- **Cadastro de EPIs:** Registro completo com CA, validade, descrição
- **Controle de Estoque:** Monitoramento de quantidades disponíveis
- **Alertas de Estoque:** Notificações para EPIs com estoque baixo
- **Alertas de Validade:** Notificações para CAs próximos do vencimento

### 📦 **Controle de Entregas**
- **Registro de Entregas:** Controle de entregas de EPIs para colaboradores
- **Histórico Completo:** Rastreamento de todas as entregas realizadas
- **Motivos de Entrega:** Registro do motivo da entrega (novo funcionário, substituição, etc.)

### 📊 **Dashboard e Relatórios**
- **Dashboard Executivo:** Visão geral com métricas importantes
- **Alertas Visuais:** Cards com alertas de estoque e validade
- **Últimas Entregas:** Tabela com entregas recentes
- **Estatísticas:** Totais de colaboradores, EPIs e entregas

## 🗄️ **Modelo de Dados**

### Tabelas Principais

#### `users` - Usuários do Sistema
- `id` (PK)
- `name` - Nome do usuário
- `email` - Email único
- `password` - Senha criptografada
- `timestamps`

#### `departamentos` - Departamentos da Empresa
- `id` (PK)
- `nome` - Nome do departamento
- `timestamps`

#### `cargos` - Cargos/Funções
- `id` (PK)
- `nome` - Nome do cargo
- `timestamps`

#### `colaboradores` - Colaboradores da Empresa
- `id` (PK)
- `nome` - Nome completo
- `cpf` - CPF único
- `departamento_id` (FK) - Referência ao departamento
- `cargo_id` (FK) - Referência ao cargo
- `timestamps`

#### `epis` - Equipamentos de Proteção Individual
- `id` (PK)
- `nome` - Nome do EPI
- `descricao` - Descrição detalhada
- `ca` - Certificado de Aprovação
- `validade_ca` - Data de validade do CA
- `quantidade_estoque` - Quantidade em estoque
- `timestamps`

#### `entrega_epis` - Registro de Entregas
- `id` (PK)
- `colaborador_id` (FK) - Referência ao colaborador
- `epi_id` (FK) - Referência ao EPI
- `quantidade_entregue` - Quantidade entregue
- `data_entrega` - Data da entrega
- `motivo` - Motivo da entrega
- `timestamps`

## 🔧 Instalação e Configuração

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js & NPM
- Servidor web (Apache/Nginx)

### Passos de Instalação

1. **Clone o repositório**
```bash
git clone [URL_DO_REPOSITORIO]
cd gerenciador-epis-app
```

2. **Instale as dependências PHP**
```bash
composer install
```

3. **Instale as dependências Node.js**
```bash
npm install
```

4. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o banco de dados**
   - Edite o arquivo `.env` com suas configurações de banco
   - Por padrão, está configurado para SQLite

6. **Execute as migrações**
```bash
php artisan migrate
```

7. **Compile os assets**
```bash
npm run build
# ou para desenvolvimento
npm run dev
```

8. **Inicie o servidor**
```bash
php artisan serve
```

## 👤 Uso do Sistema

### Acesso
1. Acesse `http://localhost:8000`
2. Registre-se ou faça login
3. Navegue pelas funcionalidades através do menu

### Fluxo Recomendado
1. **Cadastre Departamentos** - Crie os departamentos da empresa
2. **Cadastre Cargos** - Defina os cargos/funções
3. **Cadastre Colaboradores** - Registre os funcionários
4. **Cadastre EPIs** - Registre os equipamentos
5. **Registre Entregas** - Controle as entregas realizadas

## 🎨 Interface

- **Design Responsivo:** Funciona perfeitamente em desktop e mobile
- **Tailwind CSS:** Interface moderna e consistente
- **Componentes Reutilizáveis:** Botões, formulários e cards padronizados
- **Alertas Visuais:** Feedback claro para ações do usuário
- **Navegação Intuitiva:** Menu lateral organizado por módulos

## 🔒 Segurança

- **Autenticação:** Sistema completo de login/registro
- **Proteção CSRF:** Tokens em todos os formulários
- **Validação:** Validação robusta em frontend e backend
- **Sanitização:** Dados sanitizados antes da persistência

## 🚧 Roadmap - Funcionalidades Futuras

### 📝 **Sistema de Solicitações (Em Desenvolvimento)**
- **Portal do Colaborador:** Interface para usuários finais solicitarem EPIs
- **Solicitação de EPIs:** Colaboradores podem solicitar EPIs necessários
- **Workflow de Aprovação:** Administradores aprovam/rejeitam solicitações
- **Notificações:** Sistema de notificações em tempo real
- **Status de Solicitação:** Acompanhamento do status das solicitações
- **Histórico de Solicitações:** Rastreamento completo de pedidos

#### Estrutura das Solicitações:
```sql
-- Nova tabela: solicitacao_epis
CREATE TABLE solicitacao_epis (
    id BIGINT PRIMARY KEY,
    colaborador_id BIGINT, -- FK para colaboradores
    epi_id BIGINT,         -- FK para epis
    quantidade_solicitada INT,
    motivo TEXT,
    status ENUM('pendente', 'aprovada', 'rejeitada', 'entregue'),
    observacoes_admin TEXT,
    data_solicitacao TIMESTAMP,
    data_resposta TIMESTAMP,
    admin_responsavel_id BIGINT, -- FK para users
    prioridade ENUM('baixa', 'media', 'alta', 'urgente'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### Fluxo de Solicitação:
1. **Colaborador** acessa portal e solicita EPI
2. **Sistema** valida disponibilidade em estoque
3. **Administrador** recebe notificação da solicitação
4. **Administrador** aprova/rejeita com observações
5. **Colaborador** recebe notificação do status
6. **Entrega** é registrada automaticamente se aprovada

### 📱 **Portal do Colaborador**
- **Dashboard Pessoal:** Interface específica para usuários finais
- **Meus EPIs:** Visualização dos EPIs já recebidos
- **Solicitar EPIs:** Formulário simplificado para solicitações
- **Histórico:** Acompanhamento de todas as solicitações
- **Notificações:** Alertas sobre status das solicitações

### 🔔 **Sistema de Notificações**
- **Notificações em Tempo Real:** WebSockets para notificações instantâneas
- **Email:** Envio automático de emails para eventos importantes
- **Dashboard de Alertas:** Central de notificações no sistema
- **Tipos de Notificação:**
  - Nova solicitação (para admins)
  - Solicitação aprovada/rejeitada (para colaboradores)
  - Estoque baixo (para admins)
  - CA próximo do vencimento (para admins)

### 📊 **Relatórios Avançados**
- **Relatórios de Solicitações:** Análise de pedidos por período
- **Relatórios de Produtividade:** Tempo médio de aprovação
- **Gráficos Interativos:** Charts com dados em tempo real
- **Exportação:** PDF e Excel para relatórios
- **Relatórios Agendados:** Envio automático por email

### 🔧 **Funcionalidades Técnicas**
- **API REST:** Endpoints para integrações externas
- **Sistema de Permissões:** Controle granular de acesso
- **Auditoria:** Log completo de todas as ações
- **Backup Automático:** Sistema de backup da base de dados

### 📋 **Gestão Avançada**
- **Fornecedores:** Cadastro e gestão de fornecedores de EPIs
- **Compras:** Sistema de controle de compras e cotações
- **Manutenção:** Controle de manutenção de EPIs reutilizáveis
- **Devolução:** Sistema de devolução de EPIs

## 🤝 Contribuição

1. Faça um Fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

## 📋 Padrões de Código

- **PSR-12:** Seguir padrões PSR-12 para PHP
- **Convenções Laravel:** Seguir convenções do framework
- **Comentários:** Documentar funções complexas
- **Testes:** Incluir testes para novas funcionalidades

## 📞 Suporte

Para suporte técnico ou dúvidas:
- Abra uma **Issue** no repositório
- Consulte a documentação do Laravel
- Verifique os logs em `storage/logs/`

## 📄 Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo `LICENSE` para detalhes.

---

## 🎯 Status do Projeto

**Versão Atual:** 1.0.0  
**Status:** ✅ Produção  
**Última Atualização:** Julho 2025

### Funcionalidades Implementadas
- ✅ Sistema de Autenticação
- ✅ CRUD Completo para todos os módulos
- ✅ Dashboard com métricas
- ✅ Controle de estoque
- ✅ Alertas de validade e estoque
- ✅ Interface responsiva
- ✅ Relacionamentos entre entidades

### Próximas Entregas
- 🚧 Sistema de Solicitações de EPIs (Q3 2025)
- 📱 Portal do Colaborador (Q3 2025)
- 🔔 Sistema de Notificações (Q4 2025)
- 📊 Relatórios Avançados (Q4 2025)

---

**Desenvolvido com ❤️ usando Laravel e Tailwind CSS**

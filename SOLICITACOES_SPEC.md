# 📋 Sistema de Solicitações de EPIs - Especificação Técnica

## 🎯 Visão Geral

O Sistema de Solicitações de EPIs é uma extensão do Gerenciador de EPIs que permitirá aos colaboradores solicitarem equipamentos através de uma interface dedicada, com workflow de aprovação pelos administradores.

## 👥 Personas e Casos de Uso

### 👤 **Colaborador (Usuário Final)**
- Solicitar EPIs necessários para suas atividades
- Acompanhar status das solicitações
- Visualizar histórico de EPIs recebidos
- Receber notificações sobre aprovações/rejeições

### 👨‍💼 **Administrador**
- Aprovar/rejeitar solicitações
- Visualizar fila de solicitações pendentes
- Gerenciar estoque baseado na demanda
- Gerar relatórios de solicitações

## 🏗️ Arquitetura do Sistema

### 📊 **Novo Modelo de Dados**

```php
// Model: SolicitacaoEpi
class SolicitacaoEpi extends Model
{
    protected $table = 'solicitacao_epis';
    
    protected $fillable = [
        'colaborador_id',
        'epi_id', 
        'quantidade_solicitada',
        'motivo',
        'status',
        'prioridade',
        'observacoes_admin',
        'data_solicitacao',
        'data_resposta',
        'admin_responsavel_id'
    ];
    
    protected $casts = [
        'data_solicitacao' => 'datetime',
        'data_resposta' => 'datetime'
    ];
    
    // Relacionamentos
    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }
    
    public function epi()
    {
        return $this->belongsTo(Epi::class);
    }
    
    public function adminResponsavel()
    {
        return $this->belongsTo(User::class, 'admin_responsavel_id');
    }
}
```

### 🗄️ **Migration da Tabela**

```php
Schema::create('solicitacao_epis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('colaborador_id')->constrained('colaboradores');
    $table->foreignId('epi_id')->constrained('epis');
    $table->integer('quantidade_solicitada');
    $table->text('motivo');
    $table->enum('status', ['pendente', 'aprovada', 'rejeitada', 'entregue'])
          ->default('pendente');
    $table->enum('prioridade', ['baixa', 'media', 'alta', 'urgente'])
          ->default('media');
    $table->text('observacoes_admin')->nullable();
    $table->timestamp('data_solicitacao');
    $table->timestamp('data_resposta')->nullable();
    $table->foreignId('admin_responsavel_id')->nullable()
          ->constrained('users');
    $table->timestamps();
});
```

## 🎛️ **Controllers**

### SolicitacaoEpiController
```php
class SolicitacaoEpiController extends Controller
{
    // Para administradores
    public function index()         // Lista todas solicitações
    public function show($id)       // Detalhes da solicitação
    public function aprovar($id)    // Aprovar solicitação
    public function rejeitar($id)   // Rejeitar solicitação
    
    // Para colaboradores
    public function minhasSolicitacoes()  // Solicitações do usuário logado
    public function create()              // Formulário de nova solicitação
    public function store(Request $request) // Criar nova solicitação
}
```

### PortalColaboradorController
```php
class PortalColaboradorController extends Controller
{
    public function dashboard()     // Dashboard do colaborador
    public function meusEpis()      // EPIs já recebidos
    public function solicitar()     // Página de solicitação
}
```

## 🎨 **Interfaces de Usuário**

### 📱 **Portal do Colaborador**

#### Dashboard do Colaborador
```php
<!-- resources/views/colaborador/dashboard.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header com informações do colaborador -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4">
                <h1>Bem-vindo, {{ auth()->user()->name }}</h1>
                <p>{{ $colaborador->cargo->nome }} - {{ $colaborador->departamento->nome }}</p>
            </div>
        </div>
        
        <!-- Cards de resumo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <div class="bg-blue-500 text-white p-6 rounded-lg">
                <h3>Solicitações Pendentes</h3>
                <p class="text-3xl">{{ $solicitacoesPendentes }}</p>
            </div>
            
            <div class="bg-green-500 text-white p-6 rounded-lg">
                <h3>EPIs Recebidos</h3>
                <p class="text-3xl">{{ $episRecebidos }}</p>
            </div>
            
            <div class="bg-purple-500 text-white p-6 rounded-lg">
                <h3>Última Solicitação</h3>
                <p>{{ $ultimaSolicitacao?->created_at?->format('d/m/Y') ?? 'Nenhuma' }}</p>
            </div>
        </div>
        
        <!-- Ações rápidas -->
        <div class="px-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Ações Rápidas</h2>
                <div class="flex gap-4">
                    <a href="{{ route('colaborador.solicitar') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        🦺 Solicitar EPI
                    </a>
                    <a href="{{ route('colaborador.minhas-solicitacoes') }}" 
                       class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700">
                        📋 Minhas Solicitações
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

#### Formulário de Solicitação
```php
<!-- resources/views/colaborador/solicitar.blade.php -->
<form method="POST" action="{{ route('solicitacoes.store') }}">
    @csrf
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">EPI Necessário</label>
        <select name="epi_id" class="mt-1 block w-full rounded-md border-gray-300">
            @foreach($epis as $epi)
                <option value="{{ $epi->id }}">
                    {{ $epi->nome }} (Estoque: {{ $epi->quantidade_estoque }})
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Quantidade</label>
        <input type="number" name="quantidade_solicitada" min="1" 
               class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Motivo da Solicitação</label>
        <textarea name="motivo" rows="3" 
                  class="mt-1 block w-full rounded-md border-gray-300"
                  placeholder="Ex: Substituição de EPI danificado, novo funcionário, etc."></textarea>
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Prioridade</label>
        <select name="prioridade" class="mt-1 block w-full rounded-md border-gray-300">
            <option value="baixa">Baixa</option>
            <option value="media" selected>Média</option>
            <option value="alta">Alta</option>
            <option value="urgente">Urgente</option>
        </select>
    </div>
    
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        Enviar Solicitação
    </button>
</form>
```

### 👨‍💼 **Interface do Administrador**

#### Fila de Solicitações
```php
<!-- resources/views/admin/solicitacoes/index.blade.php -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @foreach($solicitacoes as $solicitacao)
            <li class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($solicitacao->prioridade === 'urgente')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                    🚨 Urgente
                                </span>
                            @elseif($solicitacao->prioridade === 'alta')
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs">
                                    ⚡ Alta
                                </span>
                            @endif
                        </div>
                        
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">
                                {{ $solicitacao->colaborador->nome }}
                            </h4>
                            <p class="text-sm text-gray-500">
                                Solicitou: {{ $solicitacao->epi->nome }} 
                                (Qtd: {{ $solicitacao->quantidade_solicitada }})
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $solicitacao->data_solicitacao->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button onclick="aprovarSolicitacao({{ $solicitacao->id }})"
                                class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                            ✅ Aprovar
                        </button>
                        <button onclick="rejeitarSolicitacao({{ $solicitacao->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                            ❌ Rejeitar
                        </button>
                    </div>
                </div>
                
                <div class="mt-2">
                    <p class="text-sm text-gray-600">
                        <strong>Motivo:</strong> {{ $solicitacao->motivo }}
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
```

## 🔔 **Sistema de Notificações**

### NotificacaoService
```php
class NotificacaoService
{
    public function novaSolicitacao(SolicitacaoEpi $solicitacao)
    {
        // Notificar administradores
        $admins = User::where('is_admin', true)->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new NovaSolicitacaoNotification($solicitacao));
        }
    }
    
    public function solicitacaoAprovada(SolicitacaoEpi $solicitacao)
    {
        $solicitacao->colaborador->user->notify(
            new SolicitacaoAprovadaNotification($solicitacao)
        );
    }
    
    public function solicitacaoRejeitada(SolicitacaoEpi $solicitacao)
    {
        $solicitacao->colaborador->user->notify(
            new SolicitacaoRejeitadaNotification($solicitacao)
        );
    }
}
```

## 🚀 **Fluxo de Implementação**

### Fase 1: Base Structure (2 semanas)
- [ ] Criar model e migration SolicitacaoEpi
- [ ] Implementar controllers básicos
- [ ] Criar views do portal do colaborador
- [ ] Sistema básico de solicitação

### Fase 2: Workflow de Aprovação (2 semanas)
- [ ] Interface administrativa de aprovação
- [ ] Lógica de aprovação/rejeição
- [ ] Integração com sistema de entregas
- [ ] Validação de estoque

### Fase 3: Notificações (1 semana)
- [ ] Sistema de notificações em tempo real
- [ ] Email notifications
- [ ] Dashboard de alertas

### Fase 4: Relatórios e Métricas (1 semana)
- [ ] Relatórios de solicitações
- [ ] Métricas de tempo de aprovação
- [ ] Dashboard administrativo

## 🔒 **Permissões e Segurança**

### Middleware de Permissões
```php
// Middleware para verificar se é colaborador
class EnsureIsColaborador
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->colaborador) {
            abort(403, 'Acesso negado. Apenas colaboradores podem acessar esta área.');
        }
        
        return $next($request);
    }
}

// Middleware para verificar se é admin
class EnsureIsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem acessar esta área.');
        }
        
        return $next($request);
    }
}
```

### Rotas Protegidas
```php
// Portal do colaborador
Route::middleware(['auth', 'colaborador'])->group(function () {
    Route::get('/colaborador/dashboard', [PortalColaboradorController::class, 'dashboard'])
         ->name('colaborador.dashboard');
    Route::get('/colaborador/solicitar', [SolicitacaoEpiController::class, 'create'])
         ->name('colaborador.solicitar');
    Route::post('/solicitacoes', [SolicitacaoEpiController::class, 'store'])
         ->name('solicitacoes.store');
});

// Área administrativa
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/solicitacoes', [SolicitacaoEpiController::class, 'index'])
         ->name('admin.solicitacoes');
    Route::post('/admin/solicitacoes/{id}/aprovar', [SolicitacaoEpiController::class, 'aprovar'])
         ->name('admin.solicitacoes.aprovar');
});
```

## 📊 **Métricas e KPIs**

### Principais Métricas
- **Tempo médio de aprovação** por solicitação
- **Taxa de aprovação** vs rejeição
- **EPIs mais solicitados** por período
- **Colaboradores que mais solicitam** EPIs
- **Sazonalidade** das solicitações

### Dashboard de Métricas
```php
// Controller para métricas
class MetricasController extends Controller
{
    public function dashboard()
    {
        $dados = [
            'tempo_medio_aprovacao' => $this->getTempoMedioAprovacao(),
            'taxa_aprovacao' => $this->getTaxaAprovacao(),
            'episMaisSolicitados' => $this->getEpisMaisSolicitados(),
            'solicitacoesPorMes' => $this->getSolicitacoesPorMes(),
        ];
        
        return view('admin.metricas.dashboard', $dados);
    }
}
```

---

**Esta especificação técnica serve como guia para a implementação do Sistema de Solicitações de EPIs, garantindo uma experiência fluida tanto para colaboradores quanto para administradores.**

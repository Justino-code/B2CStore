<div x-data="{ activeTab: 'perfil' }" class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detalhes do Funcionário</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Visualize todas as informações do funcionário
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.funcionarios.index') }}" 
                   class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Voltar</span>
                </a>
                
                <a href="{{ route('admin.funcionarios.edit', $funcionario->id_usuario) }}" 
                   class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Editar</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="max-w-6xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <!-- Header do Perfil -->
            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img class="w-40 h-40 rounded-full border-4 border-white dark:border-gray-800 shadow-xl" 
                                 src="{{ $funcionario->avatar_url ? image_url($funcionario->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($funcionario->nome) . '&size=160&color=7F9CF5&background=EBF4FF&bold=true' }}" 
                                 alt="{{ $funcionario->nome }}">
                            
                            <!-- Status -->
                            <div class="absolute bottom-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $funcionario->status === 'ativo' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    @if($funcionario->status === 'ativo')
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Ativo
                                    @else
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Inativo
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Header -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $funcionario->nome }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $funcionario->email }}
                                </p>
                            </div>
                            
                            <div class="mt-4 md:mt-0">
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ $this->getRoleColor($funcionario->role) }}">
                                    {{ $this->getRoleLabel($funcionario->role) }}
                                </span>
                            </div>
                        </div>

                        <!-- Estatísticas Rápidas -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">ID</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    #{{ $funcionario->id_usuario }}
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pedidos</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $funcionario->pedidos_count }}
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Avaliações</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $funcionario->reviews_count }}
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Membro desde</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $funcionario->created_at->format('m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px">
                    <button @click="activeTab = 'perfil'"
                            :class="activeTab === 'perfil' 
                                ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                        Perfil
                    </button>
                    
                    <button @click="activeTab = 'atividades'"
                            :class="activeTab === 'atividades' 
                                ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                        Atividades
                    </button>
                    
                    <button @click="activeTab = 'permissoes'"
                            :class="activeTab === 'permissoes' 
                                ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                        Permissões
                    </button>
                </nav>
            </div>

            <!-- Conteúdo das Tabs -->
            <div class="p-8">
                <!-- Tab: Perfil -->
                <div x-show="activeTab === 'perfil'" x-cloak>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Informações Pessoais -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Informações Pessoais
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nome Completo</p>
                                    <p class="text-gray-900 dark:text-white">{{ $funcionario->nome }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                    <a href="mailto:{{ $funcionario->email }}" 
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ $funcionario->email }}
                                    </a>
                                </div>
                                
                                @if($funcionario->telefone)
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Telefone</p>
                                        <a href="tel:{{ $funcionario->telefone }}" 
                                           class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $funcionario->telefone }}
                                        </a>
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $funcionario->status === 'ativo' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                        {{ $funcionario->status === 'ativo' ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Data de Cadastro</p>
                                    <p class="text-gray-900 dark:text-white">
                                        {{ $funcionario->created_at->format('d/m/Y H:i') }}
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                                            ({{ $funcionario->created_at->diffForHumans() }})
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Endereço
                            </h3>
                            
                            @if($funcionario->tem_endereco)
                                <div class="space-y-4">
                                    @php
                                        $endereco = $funcionario->endereco_array;
                                    @endphp
                                    
                                    @if($endereco['rua'])
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Rua</p>
                                            <p class="text-gray-900 dark:text-white">{{ $endereco['rua'] }}, {{ $endereco['numero'] }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($endereco['bairro'])
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Bairro</p>
                                            <p class="text-gray-900 dark:text-white">{{ $endereco['bairro'] }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($endereco['municipio'])
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Município/Província</p>
                                            <p class="text-gray-900 dark:text-white">
                                                {{ $endereco['municipio'] }}, {{ $endereco['provincia'] }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    @if($endereco['complemento'])
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Complemento</p>
                                            <p class="text-gray-900 dark:text-white">{{ $endereco['complemento'] }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($endereco['referencia'])
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Referência</p>
                                            <p class="text-gray-900 dark:text-white">{{ $endereco['referencia'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                                        Endereço não cadastrado
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab: Atividades -->
                <div x-show="activeTab === 'atividades'" x-cloak>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Últimos Pedidos -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Últimos Pedidos
                            </h3>
                            
                            @if($funcionario->pedidos_count > 0)
                                <div class="space-y-4">
                                    @foreach($funcionario->pedidos()->latest()->take(5)->get() as $pedido)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        Pedido #{{ $pedido->id_pedido }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $pedido->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded {{ $pedido->status === 'entregue' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                                    {{ ucfirst($pedido->status) }}
                                                </span>
                                            </div>
                                            <p class="text-gray-900 dark:text-white">
                                                {{ format_kwanza($pedido->total) }}
                                            </p>
                                        </div>
                                    @endforeach
                                    
                                    @if($funcionario->pedidos_count > 5)
                                        <div class="text-center">
                                            <a href="{{ route('admin.pedidos.index', ['user' => $funcionario->id_usuario]) }}" 
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                                Ver todos os {{ $funcionario->pedidos_count }} pedidos →
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                                        Nenhum pedido realizado
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Últimas Avaliações -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Últimas Avaliações
                            </h3>
                            
                            @if($funcionario->reviews_count > 0)
                                <div class="space-y-4">
                                    @foreach($funcionario->reviews()->latest()->take(5)->get() as $review)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <div class="flex items-center">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $review->created_at->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                                        {{ Str::limit($review->comentario, 100) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                                        Nenhuma avaliação realizada
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab: Permissões -->
                <div x-show="activeTab === 'permissoes'" x-cloak>
                    <div class="max-w-2xl">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            Permissões do Cargo: {{ $this->getRoleLabel($funcionario->role) }}
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Descrição do Cargo -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Descrição do Cargo</h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    @switch($funcionario->role)
                                        @case('admin')
                                            Acesso completo a todas as funcionalidades do sistema. Pode gerenciar todos os usuários, produtos, pedidos e configurações do sistema.
                                            @break
                                        @case('gerente')
                                            Pode gerenciar produtos, pedidos, clientes e funcionários (exceto administradores). Tem acesso a relatórios e análises.
                                            @break
                                        @case('operador')
                                            Pode gerenciar pedidos básicos, atualizar status de pedidos e visualizar produtos. Acesso limitado a configurações.
                                            @break
                                        @case('suporte')
                                            Focado em atendimento ao cliente. Pode visualizar pedidos, clientes e responder a solicitações de suporte.
                                            @break
                                    @endswitch
                                </p>
                            </div>

                            <!-- Permissões Detalhadas -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Permissões Detalhadas</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @php
                                        $permissoes = match($funcionario->role) {
                                            'admin' => [
                                                ['modulo' => 'Dashboard', 'permissao' => 'Acesso Completo'],
                                                ['modulo' => 'Produtos', 'permissao' => 'CRUD Completo'],
                                                ['modulo' => 'Pedidos', 'permissao' => 'CRUD Completo'],
                                                ['modulo' => 'Clientes', 'permissao' => 'CRUD Completo'],
                                                ['modulo' => 'Funcionários', 'permissao' => 'CRUD Completo'],
                                                ['modulo' => 'Relatórios', 'permissao' => 'Acesso Completo'],
                                                ['modulo' => 'Configurações', 'permissao' => 'Acesso Completo'],
                                                ['modulo' => 'Financeiro', 'permissao' => 'Acesso Completo'],
                                            ],
                                            'gerente' => [
                                                ['modulo' => 'Dashboard', 'permissao' => 'Acesso Completo'],
                                                ['modulo' => 'Produtos', 'permissao' => 'CRUD Completo'],
                                                ['modulo' => 'Pedidos', 'permissao' => 'CRUD Completo'],
                                                ['modulo' => 'Clientes', 'permissao' => 'Visualizar/Editar'],
                                                ['modulo' => 'Funcionários', 'permissao' => 'Visualizar/Editar (não admin)'],
                                                ['modulo' => 'Relatórios', 'permissao' => 'Acesso Completo'],
                                                ['modulo' => 'Configurações', 'permissao' => 'Acesso Limitado'],
                                                ['modulo' => 'Financeiro', 'permissao' => 'Acesso Parcial'],
                                            ],
                                            'operador' => [
                                                ['modulo' => 'Dashboard', 'permissao' => 'Acesso Básico'],
                                                ['modulo' => 'Produtos', 'permissao' => 'Visualizar'],
                                                ['modulo' => 'Pedidos', 'permissao' => 'Criar/Visualizar/Atualizar'],
                                                ['modulo' => 'Clientes', 'permissao' => 'Visualizar'],
                                                ['modulo' => 'Funcionários', 'permissao' => 'Sem Acesso'],
                                                ['modulo' => 'Relatórios', 'permissao' => 'Acesso Básico'],
                                                ['modulo' => 'Configurações', 'permissao' => 'Sem Acesso'],
                                                ['modulo' => 'Financeiro', 'permissao' => 'Sem Acesso'],
                                            ],
                                            'suporte' => [
                                                ['modulo' => 'Dashboard', 'permissao' => 'Acesso Básico'],
                                                ['modulo' => 'Produtos', 'permissao' => 'Visualizar'],
                                                ['modulo' => 'Pedidos', 'permissao' => 'Visualizar'],
                                                ['modulo' => 'Clientes', 'permissao' => 'Visualizar/Editar'],
                                                ['modulo' => 'Funcionários', 'permissao' => 'Sem Acesso'],
                                                ['modulo' => 'Relatórios', 'permissao' => 'Acesso Limitado'],
                                                ['modulo' => 'Configurações', 'permissao' => 'Sem Acesso'],
                                                ['modulo' => 'Financeiro', 'permissao' => 'Sem Acesso'],
                                            ],
                                        };
                                    @endphp
                                    
                                    @foreach($permissoes as $permissao)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        {{ $permissao['modulo'] }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $permissao['permissao'] }}
                                                    </p>
                                                </div>
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Status da Conta -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Status da Conta</h4>
                                
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Status Atual</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $funcionario->status === 'ativo' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                            {{ $funcionario->status === 'ativo' ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Último Login</span>
                                        <span class="text-gray-900 dark:text-white">
                                            {{ $funcionario->ultimo_acesso ? $funcionario->ultimo_acesso->format('d/m/Y H:i') : 'Nunca logou' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">IP do Último Login</span>
                                        <span class="text-gray-900 dark:text-white">
                                            {{ $funcionario->ultimo_acesso_ip ?? 'Não disponível' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
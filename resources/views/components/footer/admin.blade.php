{{-- components/footer/admin.blade.php --}}
@php
    // Dados em tempo real - você pode ajustar conforme suas necessidades
    $hoje = now()->format('Y-m-d');
    
    // Dados de pedidos do dia (ajustar conforme seu modelo)
    $pedidosHoje = \App\Models\Pedido::whereDate('created_at', $hoje)
        ->whereNotIn('status', ['cancelado', 'rejeitado'])
        ->count();
    
    $receitaHoje = \App\Models\Pedido::whereDate('created_at', $hoje)
        ->where('status', 'entregue')
        ->sum('total');
    
    // Usuários online (últimos 5 minutos)
    $usuariosOnline = \App\Models\Usuario::where('ultimo_acesso', '>=', now()->subMinutes(5))
        ->count();
    
    // Usuários ativos hoje
    $usuariosAtivosHoje = \App\Models\Usuario::whereDate('ultimo_acesso', $hoje)
        ->count();
    
    // Versão do sistema (buscar de configuração ou banco)
    $versaoSistema = \App\Models\Configuracao::where('chave', 'versao_sistema')->value('valor') ?? '1.0.0';
    
    // Status do sistema (simplificado)
    $memoriaUso = memory_get_usage(true) / 1024 / 1024;
    $memoriaUsoFormatada = number_format($memoriaUso, 2);
    
    // Performance do sistema (simulado)
    $performance = 100;
    if ($memoriaUso > 256) { // Se usar mais de 256MB
        $performance = 80;
    }
    if ($memoriaUso > 512) { // Se usar mais de 512MB
        $performance = 60;
    }
    
    // Cor da performance
    $corPerformance = match(true) {
        $performance >= 80 => 'green',
        $performance >= 60 => 'yellow',
        default => 'red'
    };
    
    // Servidor info
    $servidor = gethostname();
    $phpVersao = PHP_VERSION;
    $laravelVersao = app()->version();
@endphp

<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} B2CStore Admin v{{ $versaoSistema }}
                <span class="text-xs ml-2">(Laravel {{ $laravelVersao }})</span>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Stats Dinâmicos -->
                <div class="flex items-center space-x-4">
                    <!-- Usuários Online -->
                    <div class="flex items-center space-x-1" title="{{ $usuariosOnline }} usuário(s) ativo(s) nos últimos 5 minutos">
                        <div class="w-2 h-2 {{ $usuariosOnline > 0 ? 'bg-green-500' : 'bg-gray-400' }} rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Online: <span class="font-medium {{ $usuariosOnline > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-500' }}">
                                {{ $usuariosOnline }}
                            </span>
                        </span>
                    </div>
                    
                    <!-- Pedidos Hoje -->
                    <div class="flex items-center space-x-1" title="{{ $pedidosHoje }} pedido(s) hoje">
                        <svg class="w-4 h-4 {{ $pedidosHoje > 0 ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Hoje: <span class="font-medium {{ $pedidosHoje > 0 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                                {{ $pedidosHoje }}
                            </span>
                        </span>
                    </div>
                    
                    <!-- Receita Hoje -->
                    <div class="flex items-center space-x-1" title="Receita de pedidos entregues hoje">
                        <svg class="w-4 h-4 {{ $receitaHoje > 0 ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Receita: <span class="font-medium {{ $receitaHoje > 0 ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500' }}">
                                {{ format_kwanza($receitaHoje) }}
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Separator -->
                <div class="hidden md:block h-6 w-px bg-gray-300 dark:bg-gray-600"></div>

                <!-- System Info -->
                <div class="flex items-center space-x-4">
                    <!-- Botão de Tema -->
                    <x-theme-toggle-button />

                    <!-- Link para dashboard de sistema -->
                    <a href="{{ route('admin.sistema.status') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200"
                       title="Ver status completo do sistema">
                        Status
                    </a>

                    <!-- Performance com tooltip -->
                    <div class="flex items-center space-x-1 group relative" 
                         title="Performance do sistema: {{ $performance }}%">
                        <div class="w-2 h-2 rounded-full bg-{{ $corPerformance }}-500"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $performance }}%
                        </span>
                        <!-- Tooltip detalhado -->
                        <div class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                            Memória: {{ $memoriaUsoFormatada }} MB
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server Info Expandida -->
        <div class="mt-2 text-center">
            <div class="inline-flex flex-wrap justify-center items-center gap-x-4 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                <span title="Nome do servidor">
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                    {{ $servidor }}
                </span>
                
                <span title="Memória em uso">
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Mem: {{ $memoriaUsoFormatada }} MB
                </span>
                
                <span title="Versão PHP">
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    PHP: {{ $phpVersao }}
                </span>
                
                <span title="Usuários ativos hoje">
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-6.5a6 6 0 01-6 6"/>
                    </svg>
                    Ativos: {{ $usuariosAtivosHoje }}
                </span>
                
                <!-- Tempo de resposta -->
                @php
                    $tempoInicio = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
                    $tempoResposta = round((microtime(true) - $tempoInicio) * 1000, 2);
                @endphp
                <span title="Tempo de resposta">
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $tempoResposta }}ms
                </span>
            </div>
        </div>
    </div>
</footer>
<div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen"
     x-data="{ 
         showCopySuccess: false,
         copyCode(code) {
             // Método 1: API Clipboard moderna
             if (navigator.clipboard && window.isSecureContext) {
                 navigator.clipboard.writeText(code).then(() => {
                     this.showCopySuccess = true;
                     setTimeout(() => this.showCopySuccess = false, 2000);
                 }).catch(err => {
                     console.error('Erro ao copiar código: ', err);
                     this.fallbackCopyCode(code);
                 });
             } else {
                 // Método 2: Fallback para método antigo
                 this.fallbackCopyCode(code);
             }
         },
         fallbackCopyCode(code) {
             // Criar um textarea temporário
             const textArea = document.createElement('textarea');
             textArea.value = code;
             
             // Tornar invisível
             textArea.style.position = 'fixed';
             textArea.style.left = '-999999px';
             textArea.style.top = '-999999px';
             document.body.appendChild(textArea);
             
             // Selecionar e copiar
             textArea.focus();
             textArea.select();
             
             try {
                 const successful = document.execCommand('copy');
                 if (successful) {
                     this.showCopySuccess = true;
                     setTimeout(() => this.showCopySuccess = false, 2000);
                 } else {
                     this.showManualCopyPrompt(code);
                 }
             } catch (err) {
                 console.error('Fallback falhou: ', err);
                 this.showManualCopyPrompt(code);
             }
             
             // Limpar
             document.body.removeChild(textArea);
         },
         showManualCopyPrompt(code) {
             // Mostrar prompt para copiar manualmente
             const message = `Copie o código: ${code}`;
             prompt('Copie o código:', code);
             
             // Opcional: Mostrar notificação de cópia manual
             this.$dispatch('notify', { 
                 type: 'info', 
                 message: 'Código selecionado. Use Ctrl+C para copiar.' 
             });
         }
     }">
    <!-- Header com ações -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.cupons.index') }}" 
                   class="p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl transition-all duration-200 shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Cupom: {{ $cupom->codigo }}
                        </h1>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 ml-11 mt-1">
                        {{ $cupom->tipo_desconto == 'percentual' ? 'Cupom percentual' : 'Cupom de valor fixo' }}
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <!-- Status -->
                <button wire:click="toggleStatus"
                        class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $this->statusColor }} hover:shadow">
                    <div class="flex items-center gap-2">
                        @if($cupom->ativo && $cupom->valido())
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        @elseif(!$cupom->ativo)
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        @else
                            <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                        @endif
                        <span>{{ $this->statusLabel }}</span>
                    </div>
                </button>

                <!-- Editar -->
                <a href="{{ route('admin.cupons.edit', $cupom->id_cupom) }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2.5 rounded-xl font-medium flex items-center space-x-2 transition-all duration-200 shadow hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Editar</span>
                </a>

                <!-- Deletar -->
                <button wire:click="deletarCupom"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2.5 rounded-xl font-medium flex items-center space-x-2 transition-all duration-200 shadow hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Deletar</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Esquerda - Detalhes do Cupom -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Card Detalhes -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detalhes do Cupom</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Informações Básicas -->
                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Código</label>
                            <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-600">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $cupom->codigo }}</span>
                            </div>
                        </div>
                        
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Tipo de Desconto</label>
                            <div class="flex items-center gap-3">
                                @if($cupom->tipo_desconto == 'percentual')
                                    <div class="p-2 bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="p-2 bg-gradient-to-r from-green-100 to-green-50 dark:from-green-900/30 dark:to-green-800/20 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Valor Fixo' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Valor do Desconto</label>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    @if($cupom->tipo_desconto == 'percentual')
                                        {{ number_format($cupom->valor_desconto, 2) }}%
                                    @else
                                        {{ format_kwanza($cupom->valor_desconto) }}
                                    @endif
                                </p>
                                <span class="text-sm text-gray-500 dark:text-gray-400">de desconto</span>
                            </div>
                        </div>
                    </div>

                    <!-- Condições e Validade -->
                    <div class="space-y-6">
                        @if($cupom->valor_minimo)
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Valor Mínimo</label>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-gradient-to-r from-amber-100 to-amber-50 dark:from-amber-900/30 dark:to-amber-800/20 rounded-lg">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ format_kwanza($cupom->valor_minimo) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Usos</label>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-gradient-to-r from-purple-100 to-purple-50 dark:from-purple-900/30 dark:to-purple-800/20 rounded-lg">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $cupom->usos_atual }} 
                                            @if($cupom->usos_maximos)
                                                <span class="text-gray-500">/ {{ $cupom->usos_maximos }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    @if($cupom->usos_maximos)
                                        <div class="text-sm font-medium px-3 py-1 rounded-full 
                                            {{ $cupom->usos_atual >= $cupom->usos_maximos ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' }}">
                                            {{ number_format($estatisticas['taxaUtilizacao'], 1) }}%
                                        </div>
                                    @endif
                                </div>
                                @if($cupom->usos_maximos)
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" 
                                             style="width: {{ min(100, $estatisticas['taxaUtilizacao']) }}%"></div>
                                    </div>
                                @endif
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    @if($cupom->usos_maximos)
                                        {{ $cupom->usos_maximos - $cupom->usos_atual }} uso(s) restante(s)
                                    @else
                                        Usos ilimitados
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        @if($cupom->validade_inicio || $cupom->validade_fim)
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Validade</label>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-gradient-to-r from-green-100 to-green-50 dark:from-green-900/30 dark:to-green-800/20 rounded-lg">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            @if($cupom->validade_inicio && $cupom->validade_fim)
                                                {{ $cupom->validade_inicio->format('d/m/Y') }} - {{ $cupom->validade_fim->format('d/m/Y') }}
                                            @elseif($cupom->validade_fim)
                                                Até {{ $cupom->validade_fim->format('d/m/Y') }}
                                            @endif
                                        </p>
                                    </div>
                                    @if($cupom->validade_fim)
                                        <div class="flex items-center gap-2">
                                            @if($cupom->validade_fim->isPast())
                                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                <p class="text-xs text-red-600 dark:text-red-400 font-medium">
                                                    Expirado
                                                </p>
                                            @else
                                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    Expira {{ $cupom->validade_fim->diffForHumans() }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Estatísticas -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-purple-100 to-purple-50 dark:from-purple-900/30 dark:to-purple-800/20 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Estatísticas de Uso</h2>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/10 rounded-xl p-5 border border-blue-100 dark:border-blue-800/30 text-center group hover:scale-[1.02] transition-transform duration-200">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $estatisticas['totalUsos'] }}</p>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Total de Usos
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/10 rounded-xl p-5 border border-green-100 dark:border-green-800/30 text-center group hover:scale-[1.02] transition-transform duration-200">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $estatisticas['totalPedidos'] }}</p>
                        <p class="text-sm font-medium text-green-600 dark:text-green-400 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Pedidos
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/10 rounded-xl p-5 border border-amber-100 dark:border-amber-800/30 text-center group hover:scale-[1.02] transition-transform duration-200">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ format_kwanza($estatisticas['valorTotalDescontado']) }}</p>
                        <p class="text-sm font-medium text-amber-600 dark:text-amber-400 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Total Descontado
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/10 rounded-xl p-5 border border-emerald-100 dark:border-emerald-800/30 text-center group hover:scale-[1.02] transition-transform duration-200">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ format_kwanza($estatisticas['valorTotalVendas']) }}</p>
                        <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Vendas Geradas
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card Pedidos Recentes -->
            @if($pedidos->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gradient-to-r from-indigo-100 to-indigo-50 dark:from-indigo-900/30 dark:to-indigo-800/20 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pedidos Recentes</h2>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pedido</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Valor</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Desconto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($pedidos as $pedido)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.pedidos.show', $pedido->id_pedido) }}" 
                                               class="text-sm font-semibold text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $pedido->codigo_pedido }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-900 dark:text-white flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $pedido->usuario->nome ?? 'Cliente' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ format_kwanza($pedido->total) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-semibold text-green-600 dark:text-green-400 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ format_kwanza($pedido->valor_desconto) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Coluna Direita - Informações Adicionais -->
        <div class="space-y-8">
            <!-- Card Código de Uso -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-pink-100 to-pink-50 dark:from-pink-900/30 dark:to-pink-800/20 rounded-lg">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Código de Uso</h2>
                </div>
                
                <div class="text-center space-y-6">
                    <div class="inline-block px-8 py-5 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-[1.02]">
                        <span class="text-3xl font-bold text-white tracking-wider animate-pulse-slow">{{ $cupom->codigo }}</span>
                    </div>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Os clientes podem usar este código no checkout
                    </p>
                    
                    <!-- Success Message -->
                    <div x-show="showCopySuccess" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Código copiado!</span>
                    </div>
                    
                    <button @click="copyCode('{{ $cupom->codigo }}')"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-3 rounded-xl font-medium flex items-center justify-center gap-3 transition-all duration-200 shadow hover:shadow-md transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>Copiar Código</span>
                    </button>
                </div>
            </div>

            <!-- Card Exemplo de Desconto -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-emerald-100 to-emerald-50 dark:from-emerald-900/30 dark:to-emerald-800/20 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Exemplo de Desconto</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-lg">
                        <span class="text-gray-600 dark:text-gray-400">Produto:</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ format_kwanza(1000) }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/10 rounded-lg">
                        <span class="text-gray-600 dark:text-gray-400">Desconto:</span>
                        <span class="font-semibold text-green-600 dark:text-green-400 flex items-center gap-1">
                            @if($cupom->tipo_desconto == 'percentual')
                                -{{ number_format($cupom->valor_desconto, 2) }}%
                            @else
                                -{{ format_kwanza($cupom->valor_desconto) }}
                            @endif
                        </span>
                    </div>
                    
                    @if($cupom->valor_minimo)
                        <div class="flex justify-between items-center p-3 bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/10 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Valor mínimo:</span>
                            <span class="font-semibold text-amber-600 dark:text-amber-400">{{ format_kwanza($cupom->valor_minimo) }}</span>
                        </div>
                    @endif
                    
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                        <div class="flex justify-between items-center p-3 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/10 rounded-lg">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total final:</span>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                @php
                                    $preco = 1000;
                                    $desconto = $cupom->calcularDesconto($preco);
                                    $total = max(0, $preco - $desconto);
                                @endphp
                                {{ format_kwanza($total) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Metadados -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-900/30 dark:to-gray-800/20 rounded-lg">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Metadados</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">ID do Cupom</span>
                        <span class="text-sm font-mono font-medium text-gray-900 dark:text-white">{{ $cupom->id_cupom }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Criado em</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $cupom->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Última atualização</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $cupom->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($cupom->validade_inicio)
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Início da validade</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $cupom->validade_inicio->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
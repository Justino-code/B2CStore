<div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $isEditing ? 'Editar Cupom' : 'Novo Cupom' }}
                    </h1>
                </div>
                <p class="text-gray-600 dark:text-gray-400 ml-11">
                    {{ $isEditing ? 'Atualize as informações do cupom' : 'Crie um novo cupom de desconto' }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.cupons.index') }}" 
                   class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-xl font-medium flex items-center space-x-2 transition-all duration-200 shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Voltar</span>
                </a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="salvar" x-data="{ isSubmitting: false }" x-on:submit="isSubmitting = true">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna Esquerda - Informações do Cupom -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Card Informações Básicas -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informações Básicas</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Código do Cupom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                    <span>Código do Cupom</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <input type="text" 
                                               wire:model.live="codigo"
                                               wire:blur="gerarCodigo"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                               placeholder="Ex: VERÃO20">
                                        @error('codigo') 
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="button"
                                            wire:click="gerarCodigo"
                                            class="px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-medium flex items-center gap-2 transition-all duration-200 shadow hover:shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <span class="hidden sm:inline">Gerar</span>
                                    </button>
                                </div>
                                @error('codigo') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Status do Cupom
                                </label>
                                <div class="flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model.live="ativo"
                                               class="sr-only peer">
                                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-gradient-to-r peer-checked:from-green-500 peer-checked:to-emerald-600"></div>
                                        <div class="ml-4 flex items-center gap-2">
                                            <span class="text-lg font-semibold {{ $ativo ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                {{ $ativo ? 'Ativo' : 'Inativo' }}
                                            </span>
                                            @if($ativo)
                                                <div class="animate-pulse">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Tipo de Desconto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                <span>Tipo de Desconto</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="cursor-pointer group">
                                    <input type="radio" 
                                           wire:model.live="tipo_desconto"
                                           value="percentual"
                                           class="sr-only peer">
                                    <div class="px-6 py-4 text-center rounded-xl border-2 border-gray-200 dark:border-gray-700 peer-checked:border-blue-500 peer-checked:bg-gradient-to-r peer-checked:from-blue-50 peer-checked:to-blue-100 dark:peer-checked:from-blue-900/20 dark:peer-checked:to-blue-800/10 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 group-hover:scale-[1.02]">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-900 dark:text-white">Percentual</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            Ex: 20% de desconto
                                        </p>
                                    </div>
                                </label>
                                
                                <label class="cursor-pointer group">
                                    <input type="radio" 
                                           wire:model.live="tipo_desconto"
                                           value="fixo"
                                           class="sr-only peer">
                                    <div class="px-6 py-4 text-center rounded-xl border-2 border-gray-200 dark:border-gray-700 peer-checked:border-green-500 peer-checked:bg-gradient-to-r peer-checked:from-green-50 peer-checked:to-green-100 dark:peer-checked:from-green-900/20 dark:peer-checked:to-green-800/10 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 group-hover:scale-[1.02]">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-900 dark:text-white">Valor Fixo</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            Ex: 500 AOA de desconto
                                        </p>
                                    </div>
                                </label>
                            </div>
                            @error('tipo_desconto') 
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Valor do Desconto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                    <span>Valor do Desconto</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    @if($tipo_desconto === 'percentual')
                                        <input type="number" 
                                               wire:model.live="valor_desconto"
                                               min="1"
                                               max="100"
                                               step="0.01"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-blue-400"
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 font-medium">%</span>
                                        </div>
                                    @else
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 font-medium">AOA</span>
                                        </div>
                                        <input type="number" 
                                               wire:model.live="valor_desconto"
                                               min="0.01"
                                               step="0.01"
                                               class="w-full pl-14 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-blue-400"
                                               placeholder="0.00">
                                    @endif
                                    @error('valor_desconto') 
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('valor_desconto') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Valor Mínimo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Valor Mínimo (opcional)
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">AOA</span>
                                    </div>
                                    <input type="number" 
                                           wire:model.live="valor_minimo"
                                           min="0"
                                           step="0.01"
                                           class="w-full pl-14 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-blue-400"
                                           placeholder="Sem valor mínimo">
                                    @error('valor_minimo') 
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Apenas para compras acima deste valor
                                </p>
                                @error('valor_minimo') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Validade e Limites -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-purple-100 to-purple-50 dark:from-purple-900/30 dark:to-purple-800/20 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Validade e Limites</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Datas de Validade -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Data de Início (opcional)
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           wire:model.live="validade_inicio"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-purple-400 appearance-none">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('validade_inicio') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Data de Término (opcional)
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           wire:model.live="validade_fim"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-purple-400 appearance-none">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('validade_fim') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Limite de Usos -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Limite de Usos (opcional)
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model.live="usos_maximos"
                                       min="1"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200 group-hover:border-purple-400"
                                       placeholder="Usos ilimitados">
                                @error('usos_maximos') 
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Deixe em branco para usos ilimitados
                            </p>
                            @error('usos_maximos') 
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Prévia e Ações -->
            <div class="space-y-8">
                <!-- Card Prévia -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-amber-100 to-amber-50 dark:from-amber-900/30 dark:to-amber-800/20 rounded-lg">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Prévia do Cupom</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Código -->
                        <div class="text-center">
                            <div class="inline-block px-8 py-4 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-[1.02]">
                                <span class="text-3xl font-bold text-white tracking-wider animate-pulse-slow">
                                    {{ $codigo ?: 'CÓDIGO' }}
                                </span>
                            </div>
                        </div>

                        <!-- Desconto -->
                        <div class="text-center">
                            <span class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                @if($tipo_desconto === 'percentual')
                                    {{ $valor_desconto ? number_format($valor_desconto, 2) . '% OFF' : '0% OFF' }}
                                @else
                                    {{ $valor_desconto ? format_kwanza($valor_desconto) . ' OFF' : '0 AOA OFF' }}
                                @endif
                            </span>
                        </div>

                        <!-- Condições -->
                        <div class="space-y-3">
                            @if($valor_minimo)
                                <div class="flex items-center justify-center gap-2 p-3 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/10 rounded-xl">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Valor mínimo: {{ format_kwanza($valor_minimo) }}
                                    </span>
                                </div>
                            @endif

                            @if($usos_maximos)
                                <div class="flex items-center justify-center gap-2 p-3 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/10 rounded-xl">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $usos_maximos }} uso(s) máximo(s)
                                    </span>
                                </div>
                            @endif

                            @if($validade_inicio && $validade_fim)
                                <div class="flex items-center justify-center gap-2 p-3 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/10 rounded-xl">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($validade_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($validade_fim)->format('d/m/Y') }}
                                    </span>
                                </div>
                            @elseif($validade_fim)
                                <div class="flex items-center justify-center gap-2 p-3 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/10 rounded-xl">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Válido até {{ \Carbon\Carbon::parse($validade_fim)->format('d/m/Y') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Exemplo -->
                        <div class="mt-6 p-5 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-600">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Exemplo de desconto
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Produto:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ format_kwanza(1000) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Desconto:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @if($tipo_desconto === 'percentual')
                                            -{{ $valor_desconto ? number_format($valor_desconto, 2) . '%' : '0%' }}
                                        @else
                                            -{{ $valor_desconto ? format_kwanza($valor_desconto) : '0 AOA' }}
                                        @endif
                                    </span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
                                    <div class="flex justify-between items-center font-bold">
                                        <span class="text-gray-900 dark:text-white">Total final:</span>
                                        <span class="text-lg text-gray-900 dark:text-white">
                                            {{ format_kwanza($this->calcularValorFinal(1000)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Ações -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <div class="space-y-4">
                        <button type="submit"
                                :disabled="isSubmitting"
                                wire:loading.attr="disabled"
                                wire:target="salvar"
                                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 disabled:from-blue-400 disabled:to-blue-500 text-white px-6 py-4 rounded-xl font-semibold flex items-center justify-center space-x-3 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span class="text-lg">
                                <span wire:loading.remove wire:target="salvar">
                                    {{ $isEditing ? 'Atualizar Cupom' : 'Criar Cupom' }}
                                </span>
                                <span wire:loading wire:target="salvar">
                                    <span class="inline-flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Salvando...
                                    </span>
                                </span>
                            </span>
                        </button>

                        <a href="{{ route('admin.cupons.index') }}" 
                           class="w-full bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-700 dark:text-gray-300 px-6 py-4 rounded-xl font-semibold flex items-center justify-center space-x-3 transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Cancelar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .animate-pulse-slow {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
        filter: invert(0.5);
    }
    
    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }
    
    .dark input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }
</style>
@endpush
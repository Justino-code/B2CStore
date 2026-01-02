<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <li>
                    <a href="{{ route('cliente.carrinho') }}" class="hover:text-blue-600">Carrinho</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="{{ $passo === 1 ? 'font-medium text-blue-600' : '' }}">
                        Endereço
                    </span>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="{{ $passo === 2 ? 'font-medium text-blue-600' : '' }}">
                        Pagamento
                    </span>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="{{ $passo === 3 ? 'font-medium text-blue-600' : '' }}">
                        Confirmação
                    </span>
                </li>
            </ol>
        </nav>

        <!-- Alertas -->
        @if($erro)
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-red-800 dark:text-red-200">{{ $erro }}</span>
                </div>
            </div>
        @endif

        @if($sucesso)
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 dark:text-green-200">{{ $sucesso }}</span>
                </div>
            </div>
        @endif

        <!-- Conteúdo dinâmico por passo -->
        @if($passo === 1)
            <!-- Passo 1: Endereços -->
            <form wire:submit.prevent="avancarParaPagamento" class="space-y-8">
                <!-- Endereço de Entrega -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                        Endereço de Entrega
                    </h2>
                    
                    @if($usuario->tem_endereco)
                        <div class="mb-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="usar_endereco_cadastrado" 
                                       class="sr-only peer" checked>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-gray-700 dark:text-gray-300 font-medium">
                                    Usar endereço cadastrado
                                </span>
                            </label>
                            
                            @if($usar_endereco_cadastrado)
                                <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium text-green-800 dark:text-green-300">
                                            Endereço Cadastrado
                                        </span>
                                    </div>
                                    <p class="text-green-700 dark:text-green-400">
                                        {{ $usuario->endereco_formatado ?? 'Sem endereço cadastrado' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Novo Endereço -->
                    <div @class(['space-y-4', 'hidden' => $usar_endereco_cadastrado])>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Rua *
                                </label>
                                <input type="text" wire:model="novo_endereco.rua"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Nome da rua">
                                @error('novo_endereco.rua') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Número *
                                </label>
                                <input type="text" wire:model="novo_endereco.numero"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="123">
                                @error('novo_endereco.numero') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Complemento
                            </label>
                            <input type="text" wire:model="novo_endereco.complemento"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Apto, Bloco, etc.">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bairro *
                            </label>
                            <input type="text" wire:model="novo_endereco.bairro"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Nome do bairro">
                            @error('novo_endereco.bairro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Município *
                                </label>
                                <input type="text" wire:model="novo_endereco.municipio"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Nome do município">
                                @error('novo_endereco.municipio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Província *
                                </label>
                                <input type="text" wire:model="novo_endereco.provincia"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Nome da província">
                                @error('novo_endereco.provincia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ponto de Referência
                            </label>
                            <textarea wire:model="novo_endereco.referencia" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Ex: Próximo ao mercado, casa com portão azul..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        Observações do Pedido
                    </h2>
                    <textarea wire:model="observacoes" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Instruções especiais para entrega, observações, etc."></textarea>
                    @error('observacoes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Botões -->
                <div class="flex justify-between">
                    <a href="{{ route('cliente.carrinho') }}" 
                       class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                        ← Voltar para Carrinho
                    </a>
                    
                    <button type="submit" 
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-300">
                        Continuar para Pagamento →
                    </button>
                </div>
            </form>
            
        @elseif($passo === 2)
            <!-- Passo 2: Pagamento -->
            @include('livewire.cliente.partials.checkout.pagamento')
            
        @elseif($passo === 3)
            <!-- Passo 3: Confirmação -->
            @include('livewire.cliente.partials.checkout.confirmacao')
        @endif

        <!-- Loading -->
        <div wire:loading class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Processando...</p>
        </div>
    </div>
</div>
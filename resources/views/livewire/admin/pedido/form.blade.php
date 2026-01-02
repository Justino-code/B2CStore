<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Atualizar Pedido</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Pedido: {{ $pedido->codigo_pedido }} • Cliente: {{ $pedido->usuario->nome }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pedidos.show', $pedido->id_pedido) }}" 
                   class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="atualizarStatus">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Coluna Esquerda - Status -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Status Atual -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status Atual</h2>
                    
                    <div class="flex items-center space-x-4">
                        <span class="px-4 py-2 rounded-lg text-lg font-medium {{ $statusOptions[$pedido->status]['cor'] }}">
                            {{ $statusOptions[$pedido->status]['label'] }}
                        </span>
                        
                        <div class="text-gray-600 dark:text-gray-400">
                            <div class="text-sm">
                                Última atualização: {{ $pedido->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Novo Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Atualizar Status</h2>
                    
                    <div class="space-y-4">
                        <!-- Seleção de Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Novo Status *
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                @foreach($statusOptions as $valor => $opcao)
                                    @if(in_array($valor, $statusOptions[$pedido->status]['proximos']) || $valor === $pedido->status)
                                        <label class="cursor-pointer">
                                            <input type="radio" 
                                                   wire:model="novoStatus"
                                                   value="{{ $valor }}"
                                                   class="sr-only peer">
                                            <div class="px-4 py-3 text-center rounded-lg border-2 peer-checked:border-blue-500 
                                                {{ $opcao['cor'] }} hover:opacity-90 transition-opacity">
                                                <span class="font-medium">{{ $opcao['label'] }}</span>
                                            </div>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                            @error('novoStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Informações de Envio -->
                        @if(in_array($novoStatus, ['enviado', 'entregue']))
                            <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informações de Envio</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Código de Rastreamento
                                        </label>
                                        <input type="text" 
                                               wire:model="codigoRastreamento"
                                               placeholder="Ex: BR123456789AO"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        @error('codigoRastreamento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Transportadora
                                        </label>
                                        <input type="text" 
                                               wire:model="transportadora"
                                               placeholder="Ex: DHL, FedEx, Correios"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        @error('transportadora') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Previsão de Entrega
                                    </label>
                                    <input type="date" 
                                           wire:model="dataEntregaPrevista"
                                           min="{{ date('Y-m-d') }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    @error('dataEntregaPrevista') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Mensagem Adicional -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mensagem Adicional para o Cliente
                            </label>
                            <textarea wire:model="mensagemAdicional" 
                                      rows="3"
                                      placeholder="Adicione uma mensagem personalizada para o cliente..."
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                            @error('mensagemAdicional') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Card Resumo do Pedido -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Resumo do Pedido</h2>
                    
                    <div class="space-y-3">
                        @foreach($pedido->itens as $item)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="flex-1">
                                    <span class="text-gray-900 dark:text-white">
                                        {{ $item->produto->nome }}
                                    </span>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->quantidade }} x {{ format_kwanza($item->preco_unitario) }}
                                    </div>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($item->preco_unitario * $item->quantidade) }}
                                </span>
                            </div>
                        @endforeach
                        
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900 dark:text-white">Total</span>
                                <span class="text-gray-900 dark:text-white">
                                    {{ format_kwanza($pedido->total) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Configurações e Ações -->
            <div class="space-y-6">
                <!-- Card Notificações -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Notificações</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enviar email ao cliente
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Notificar sobre a mudança de status
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="enviarEmailCliente"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <p class="font-medium mb-1">Email será enviado para:</p>
                            <p class="text-blue-600 dark:text-blue-400">{{ $pedido->usuario->email }}</p>
                            <p class="mt-2">{{ $pedido->usuario->nome }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Informações do Cliente -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Cliente</h2>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full" 
                                 src="{{ $pedido->usuario->avatar_url ? image_url($pedido->usuario->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($pedido->usuario->nome) }}" 
                                 alt="{{ $pedido->usuario->nome }}">
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $pedido->usuario->nome }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $pedido->usuario->email }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-medium mb-1">Endereço de entrega:</p>
                        <p class="whitespace-pre-wrap">{{ $pedido->endereco_entrega }}</p>
                    </div>
                </div>

                <!-- Card Ações -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Atualizar Pedido</span>
                        </button>

                        <a href="{{ route('admin.pedidos.show', $pedido->id_pedido) }}" 
                           class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                            <span>Cancelar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
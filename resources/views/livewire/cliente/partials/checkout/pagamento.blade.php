<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Pagamento do Pedido #{{ $pedido->numero_pedido }}
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">
            Valor total: <span class="font-bold text-blue-600">{{ format_kwanza($pedido->total) }}</span>
        </p>
    </div>

    <div class="p-6">
        <!-- Métodos de Pagamento -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Escolha a forma de pagamento
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($metodos_pagamento as $key => $metodo)
                    <label class="relative">
                        <input type="radio" wire:model="metodo_pagamento" value="{{ $key }}" 
                               class="sr-only peer"
                               wire:loading.attr="disabled">
                        <div class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 
                                    peer-checked:border-blue-500 peer-checked:bg-blue-50 
                                    dark:peer-checked:bg-blue-900/20 hover:border-gray-400">
                            <div class="flex items-center">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 mr-3">
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($metodo['icone'] == 'credit-card')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        @elseif($metodo['icone'] == 'barcode')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">
                                        {{ $metodo['nome'] }}
                                    </h3>
                                    @if(isset($metodo['desconto']))
                                        <p class="text-sm text-green-600 dark:text-green-400">
                                            {{ $metodo['desconto'] }}% de desconto
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Formulário de Pagamento -->
        <form wire:submit.prevent="processarPagamento" class="space-y-6">
            @if($metodo_pagamento == 'cartao_credito')
                <!-- Cartão de Crédito -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                     wire:loading.class="opacity-50"
                     wire:target="numero_cartao,nome_cartao,validade_mes,validade_ano,cvv,parcelas">
                    
                    <!-- Número do Cartão -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número do Cartão
                        </label>
                        <input type="text" 
                               wire:model.debounce.500ms="numero_cartao"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="0000 0000 0000 0000"
                               maxlength="19"
                               wire:loading.attr="disabled">
                        @error('numero_cartao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nome no Cartão -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nome no Cartão
                        </label>
                        <input type="text" 
                               wire:model.debounce.500ms="nome_cartao"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Como está no cartão"
                               wire:loading.attr="disabled">
                        @error('nome_cartao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Validade -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Validade
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <select wire:model.debounce.500ms="validade_mes"
                                    class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    wire:loading.attr="disabled">
                                <option value="">Mês</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                        {{ (int)str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </option>
                                @endfor
                            </select>
                            <select wire:model.debounce.500ms="validade_ano"
                                    class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    wire:loading.attr="disabled">
                                <option value="">Ano</option>
                                @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        @error('validade_mes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @error('validade_ano') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- CVV -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            CVV
                        </label>
                        <input type="text" 
                               wire:model.debounce.500ms="cvv"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="123"
                               maxlength="4"
                               wire:loading.attr="disabled">
                        @error('cvv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Parcelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Parcelas
                    </label>
                    <div class="grid grid-cols-3 md:grid-cols-6 gap-3"
                         wire:loading.class="opacity-50"
                         wire:target="parcelas">
                        @foreach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $numParcelas)
                            <label class="relative">
                                <input type="radio" 
                                       wire:model="parcelas" 
                                       value="{{ $numParcelas }}" 
                                       class="sr-only peer"
                                       wire:loading.attr="disabled">
                                <div class="p-3 border rounded-lg text-center cursor-pointer transition-all duration-200 
                                            peer-checked:border-blue-500 peer-checked:bg-blue-50 
                                            dark:peer-checked:bg-blue-900/20 hover:border-gray-400">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $numParcelas }}x
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ format_kwanza($pedido->total / $numParcelas) }}
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('parcelas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

            @elseif($metodo_pagamento == 'boleto')
                <!-- Boleto Bancário -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-300">
                            Pagamento via Boleto Bancário
                        </h3>
                    </div>
                    <p class="text-yellow-700 dark:text-yellow-400 mb-4">
                        Ao confirmar o pagamento, um boleto será gerado com vencimento para 3 dias úteis.
                        O pedido será processado após a confirmação do pagamento.
                    </p>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-yellow-700 dark:text-yellow-400">Valor Original:</span>
                            <span class="font-medium">{{ format_kwanza($pedido->total) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-yellow-700 dark:text-yellow-400">Desconto (5%):</span>
                            <span class="font-medium text-green-600">- {{ format_kwanza($pedido->total * 0.05) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-yellow-200 dark:border-yellow-800">
                            <span class="text-yellow-800 dark:text-yellow-300">Valor com Desconto:</span>
                            <span>{{ format_kwanza($pedido->total * 0.95) }}</span>
                        </div>
                    </div>
                </div>

            @elseif($metodo_pagamento == 'transferencia')
                <!-- Transferência Bancária -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-300">
                            Pagamento via Transferência Bancária
                        </h3>
                    </div>
                    <p class="text-blue-700 dark:text-blue-400 mb-4">
                        Após confirmar o pedido, você receberá as instruções para realizar a transferência.
                        O pedido será processado após a confirmação do pagamento.
                    </p>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-blue-700 dark:text-blue-400">Valor Original:</span>
                            <span class="font-medium">{{ format_kwanza($pedido->total) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-700 dark:text-blue-400">Desconto (3%):</span>
                            <span class="font-medium text-green-600">- {{ format_kwanza($pedido->total * 0.03) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-blue-200 dark:border-blue-800">
                            <span class="text-blue-800 dark:text-blue-300">Valor com Desconto:</span>
                            <span>{{ format_kwanza($pedido->total * 0.97) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botões de Ação -->
            <div class="flex justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="button" 
                        wire:click="voltarParaEnderecos"
                        wire:loading.attr="disabled"
                        class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    ← Voltar
                </button>
                
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-300 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="processarPagamento">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Finalizar Pagamento
                    </span>
                    <span wire:loading wire:target="processarPagamento">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processando...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
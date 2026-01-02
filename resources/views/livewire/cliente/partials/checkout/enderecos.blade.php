<form wire:submit.prevent="avancarParaPagamento">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna 1: Endereços -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Endereço de Entrega -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Endereço de Entrega
                    </h2>
                    <button type="button" @click="$dispatch('open-modal', { component: 'endereco-form' })"
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                        + Novo Endereço
                    </button>
                </div>
                
                <div class="space-y-4">
                    @forelse($enderecos as $endereco)
                        <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-200">
                            <input type="radio" wire:model="id_endereco_entrega" value="{{ $endereco->id_endereco }}" 
                                   class="mt-1 mr-3" required>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">
                                            {{ $endereco->titulo }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $endereco->logradouro }}, {{ $endereco->numero }}
                                            @if($endereco->complemento)
                                                - {{ $endereco->complemento }}
                                            @endif
                                            <br>
                                            {{ $endereco->bairro }} - {{ $endereco->cidade }}/{{ $endereco->estado }}
                                            <br>
                                            CEP: {{ $endereco->cep }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                        {{ $endereco->tipo }}
                                    </span>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">
                                Nenhum endereço cadastrado
                            </p>
                            <button type="button" @click="$dispatch('open-modal', { component: 'endereco-form' })"
                                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Cadastrar Endereço
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Endereço de Faturamento -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Endereço de Faturamento
                    </h2>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="mesmo_endereco" wire:model.live="mesmo_endereco" 
                               class="sr-only peer" checked>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                            Usar mesmo endereço da entrega
                        </span>
                    </label>
                </div>
                
                <div id="endereco-faturamento" @class(['space-y-4', 'hidden' => $mesmo_endereco])>
                    @foreach($enderecos as $endereco)
                        <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:border-blue-500">
                            <input type="radio" wire:model="id_endereco_faturamento" value="{{ $endereco->id_endereco }}" 
                                   class="mt-1 mr-3" @if($mesmo_endereco) disabled @endif>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900 dark:text-white">
                                    {{ $endereco->titulo }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $endereco->logradouro }}, {{ $endereco->numero }}
                                    <br>
                                    {{ $endereco->bairro }} - {{ $endereco->cidade }}/{{ $endereco->estado }}
                                </p>
                            </div>
                        </label>
                    @endforeach
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
            </div>
        </div>

        <!-- Coluna 2: Resumo -->
        <div class="lg:col-span-1">
            <div class="sticky top-8">
                <!-- Resumo do Pedido -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            Resumo do Pedido
                        </h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <!-- Itens -->
                        <div class="space-y-3 max-h-60 overflow-y-auto">
                            @foreach($carrinho->itens as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 mr-3">
                                            <img src="{{ $item->produto->imagens->first()->url_imagem ?? 'https://via.placeholder.com/150' }}" 
                                                 alt="{{ $item->produto->nome }}"
                                                 class="w-full h-full object-cover rounded">
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ Str::limit($item->produto->nome, 25) }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Quantidade: {{ $item->quantidade }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ format_kwanza(($item->produto->preco_promocional ?? $item->produto->preco) * $item->quantidade) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Totais -->
                        <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($carrinho->subtotal) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Frete</span>
                                @if($carrinho->frete == 0)
                                    <span class="font-medium text-green-600 dark:text-green-400">
                                        Grátis
                                    </span>
                                @else
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ format_kwanza($carrinho->frete) }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($carrinho->desconto > 0)
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Desconto</span>
                                    <span class="font-bold">- {{ format_kwanza($carrinho->desconto) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ format_kwanza($carrinho->total) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Botão Continuar -->
                <button type="submit" 
                        class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors duration-300 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                        @if(!$id_endereco_entrega) disabled @endif>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Continuar para Pagamento
                </button>
                
                <!-- Link Voltar -->
                <div class="mt-4 text-center">
                    <a href="{{ route('carrinho') }}" 
                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                        ← Voltar para o Carrinho
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
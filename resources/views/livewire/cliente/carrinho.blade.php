<div class="container mx-auto px-4 py-8">
    @if(count($itens) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lista de Produtos -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <!-- Cabeçalho da Tabela -->
                    <div class="hidden md:grid grid-cols-12 gap-4 p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="col-span-5">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">PRODUTO</span>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">PREÇO</span>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">QUANTIDADE</span>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">SUBTOTAL</span>
                        </div>
                        <div class="col-span-1 text-right">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400"></span>
                        </div>
                    </div>

                    <!-- Lista de Itens -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($itens as $item)
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                    <!-- Produto -->
                                    <div class="md:col-span-5">
                                        <div class="flex items-center space-x-4">
                                            <!-- Imagem -->
                                            <div class="w-20 h-20 flex-shrink-0">
                                                <img 
                                                    src="{{ $item->produto->imagens->first()->url_imagem ?? 'https://via.placeholder.com/150' }}" 
                                                    alt="{{ $item->produto->nome }}"
                                                    class="w-full h-full object-cover rounded-lg"
                                                >
                                            </div>
                                            
                                            <!-- Nome e Descrição -->
                                            <div>
                                                <a 
                                                    href="{{ route('produto.detalhe', $item->produto->slug) }}"
                                                    class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400"
                                                >
                                                    {{ $item->produto->nome }}
                                                </a>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    SKU: {{ $item->produto->sku }}
                                                </p>
                                                @if($item->produto->estoque < 10)
                                                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">
                                                        Apenas {{ $item->produto->estoque }} unidades em estoque
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preço -->
                                    <div class="md:col-span-2 text-center">
                                        <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">PREÇO</div>
                                        <div class="flex flex-col items-center">
                                            @if($item->produto->preco_promocional)
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                    {{ format_kwanza($item->produto->preco_promocional) }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                                    {{ format_kwanza($item->produto->preco) }}
                                                </span>
                                            @else
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                    {{ format_kwanza($item->produto->preco) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quantidade -->
                                    <div class="md:col-span-2">
                                        <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-2">QUANTIDADE</div>
                                        <div class="flex items-center justify-center">
                                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                                                <button 
                                                    wire:click="atualizarQuantidade({{ $item->id_carrinho_item }}, {{ $item->quantidade - 1 }})"
                                                    class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                                    {{ $item->quantidade <= 1 ? 'disabled' : '' }}
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                
                                                <input 
                                                    type="number" 
                                                    min="1" 
                                                    max="{{ $item->produto->estoque }}"
                                                    value="{{ $item->quantidade }}"
                                                    wire:change="atualizarQuantidade({{ $item->id_carrinho_item }}, $event.target.value)"
                                                    class="w-16 text-center bg-transparent border-0 focus:ring-0 text-gray-900 dark:text-white"
                                                >
                                                
                                                <button 
                                                    wire:click="atualizarQuantidade({{ $item->id_carrinho_item }}, {{ $item->quantidade + 1 }})"
                                                    class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                                    {{ $item->quantidade >= $item->produto->estoque ? 'disabled' : '' }}
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="md:col-span-2 text-center">
                                        <div class="md:hidden text-sm text-gray-500 dark:text-gray-400 mb-1">SUBTOTAL</div>
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ format_kwanza(($item->produto->preco_promocional ?? $item->produto->preco) * $item->quantidade) }}
                                        </span>
                                    </div>

                                    <!-- Remover -->
                                    <div class="md:col-span-1 text-right">
                                        <button 
                                            wire:click="removerItem({{ $item->id_carrinho_item }})"
                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                            title="Remover do carrinho"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botões Ação -->
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                        <button 
                            wire:click="continuarComprando"
                            class="flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Continuar Comprando
                        </button>
                        
                        <button 
                            wire:click="limparCarrinho"
                            wire:confirm="Tem certeza que deseja limpar o carrinho?"
                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                        >
                            Limpar Carrinho
                        </button>
                    </div>
                </div>
            </div>

            <!-- Resumo do Pedido -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Resumo do Pedido</h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ format_kwanza($subtotal) }}
                                </span>
                            </div>

                            <!-- Frete -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Calcular Frete
                                    </label>
                                    <div class="flex space-x-2">
                                        <input 
                                            type="text" 
                                            wire:model="bairroFrete"
                                            placeholder="Digite seu bairro"
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                        <button 
                                            wire:click="calcularFrete"
                                            wire:loading.attr="disabled"
                                            class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 disabled:opacity-50"
                                        >
                                            <span wire:loading.remove>Calcular</span>
                                            <span wire:loading>
                                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        Exemplos: Maianga, Kilamba, Talatona, Viana
                                    </p>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Frete</span>
                                    @if($frete == 0)
                                        <span class="font-medium text-green-600 dark:text-green-400">
                                            Grátis
                                        </span>
                                    @else
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            {{ format_kwanza($frete) }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($subtotal > 0 && $subtotal < 50000)
                                    <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                                        Compre mais {{ format_kwanza(50000 - $subtotal) }} e ganhe frete grátis!
                                    </p>
                                @endif
                            </div>

                            <!-- Cupom -->
                            @if($cupomAplicado)
                                <div class="flex justify-between items-center bg-green-50 dark:bg-green-900 p-3 rounded-lg">
                                    <div>
                                        <span class="text-green-700 dark:text-green-300 font-medium">
                                            Cupom: {{ $cupomAplicado['codigo'] }}
                                        </span>
                                        <p class="text-sm text-green-600 dark:text-green-400">
                                            @if($cupomAplicado['tipo_desconto'] == 'percentual')
                                                {{ $cupomAplicado['valor_desconto'] }}% de desconto
                                            @else
                                                {{ format_kwanza($cupomAplicado['valor_desconto']) }} de desconto
                                            @endif
                                        </p>
                                    </div>
                                    <button 
                                        wire:click="removerCupom"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <div class="flex space-x-2">
                                        <input 
                                            type="text" 
                                            wire:model="cupom"
                                            placeholder="Código do cupom"
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                        <button 
                                            wire:click="aplicarCupom"
                                            class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600"
                                        >
                                            Aplicar
                                        </button>
                                    </div>
                                    @if($erroCupom)
                                        <p class="text-red-500 text-sm mt-2">{{ $erroCupom }}</p>
                                    @endif
                                </div>
                            @endif

                            <!-- Desconto -->
                            @if($desconto > 0)
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Desconto</span>
                                    <span class="font-bold">- {{ format_kwanza($desconto) }}</span>
                                </div>
                            @endif

                            <!-- Total -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ format_kwanza($total) }}
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Em até 12x sem juros
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Botão Finalizar Compra -->
                            <button 
                                wire:click="finalizarCompra"
                                class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors duration-300 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ count($itens) === 0 ? 'disabled' : '' }}
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Finalizar Compra
                            </button>
                            
                            <!-- Segurança -->
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span>Compra segura</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <span>Dados protegidos</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Carrinho Vazio -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-8 text-center">
            <div class="w-24 h-24 mx-auto text-gray-400 mb-6">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Seu carrinho está vazio</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Adicione produtos ao carrinho para continuar com a compra
            </p>
            <div class="space-x-4">
                <a 
                    href="{{ route('home') }}"
                    class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700"
                >
                    Ir para Loja
                </a>
                <a 
                    href="{{ route('cliente.favoritos') }}"
                    class="inline-block px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                >
                    Ver Favoritos
                </a>
            </div>
        </div>
    @endif

    <!-- Modal para Cadastro de Endereço - Versão Angola -->
    @if($mostrarModalEndereco)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Cadastrar Endereço de Entrega
                        </h3>
                        <button 
                            wire:click="$set('mostrarModalEndereco', false)"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Para continuar com a compra, precisamos do seu endereço de entrega.
                    </p>
                    
                    <form wire:submit.prevent="salvarEndereco" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rua/Avenida *
                            </label>
                            <input type="text" wire:model="enderecoForm.rua"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Rua da Independência, Av. 4 de Fevereiro">
                            @error('enderecoForm.rua') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Número/Casa *
                            </label>
                            <input type="text" wire:model="enderecoForm.numero"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: 123, Casa 5, Bloco A">
                            @error('enderecoForm.numero') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bairro *
                            </label>
                            <input type="text" wire:model="enderecoForm.bairro"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Maianga, Kilamba, Talatona, Viana">
                            @error('enderecoForm.bairro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Município *
                            </label>
                            <input type="text" wire:model="enderecoForm.municipio"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Luanda, Benguela, Huambo, Lobito">
                            @error('enderecoForm.municipio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Província *
                            </label>
                            <select wire:model="enderecoForm.provincia"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione a província</option>
                                @foreach($provincias as $provincia)
                                    <option value="{{ $provincia }}">{{ $provincia }}</option>
                                @endforeach
                            </select>
                            @error('enderecoForm.provincia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Complemento (opcional)
                            </label>
                            <input type="text" wire:model="enderecoForm.complemento"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Bloco A, Apt 12, 2º Andar">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ponto de Referência (opcional)
                            </label>
                            <textarea wire:model="enderecoForm.referencia" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Ex: Próximo ao mercado Sagrada Esperança, em frente ao banco BAI"></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button 
                                type="button"
                                wire:click="$set('mostrarModalEndereco', false)"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            >
                                Salvar e Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
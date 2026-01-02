<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header com ações -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.pedidos.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Pedido: {{ $pedido->codigo_pedido }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        {{ $pedido->created_at->format('d/m/Y H:i') }} • 
                        {{ $pedido->itens->count() }} item(s) • 
                        {{ format_kwanza($pedido->total) }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <!-- Status -->
                <div class="relative">
                    <select wire:model="pedido.status" 
                            wire:change="atualizarStatus($event.target.value)"
                            class="appearance-none px-4 py-2 rounded-lg text-sm font-medium 
                                {{ $pedido->status == 'entregue' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                {{ $pedido->status == 'pendente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                {{ $pedido->status == 'cancelado' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                {{ $pedido->status == 'processando' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                {{ $pedido->status == 'enviado' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : '' }}
                                border-0 focus:ring-2 focus:ring-opacity-50">
                        <option value="pendente" {{ $pedido->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="processando" {{ $pedido->status == 'processando' ? 'selected' : '' }}>Em Processamento</option>
                        <option value="enviado" {{ $pedido->status == 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="entregue" {{ $pedido->status == 'entregue' ? 'selected' : '' }}>Entregue</option>
                        <option value="cancelado" {{ $pedido->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Nota Fiscal -->
                <button wire:click="gerarNotaFiscal"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Nota Fiscal</span>
                </button>

                <!-- Reenviar Confirmação -->
                <button wire:click="reenviarConfirmacao"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Reenviar</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna Esquerda - Itens do Pedido -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Itens do Pedido -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Itens do Pedido</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Preço Unitário</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantidade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($pedido->itens as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if($item->produto && $item->produto->imagens->first())
                                                    <img class="h-12 w-12 rounded-md object-cover" 
                                                         src="{{ image_url($item->produto->imagens->first()->url_imagem) }}" 
                                                         alt="{{ $item->produto->nome }}">
                                                @else
                                                    <div class="h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $item->produto->nome ?? 'Produto não encontrado' }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    SKU: {{ $item->produto->sku ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ format_kwanza($item->preco_unitario) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $item->quantidade }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ format_kwanza($item->preco_unitario * $item->quantidade) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Endereço de Entrega -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Endereço de Entrega</h2>
                <div class="prose dark:prose-invert max-w-none">
                    <pre class="whitespace-pre-wrap font-sans text-gray-700 dark:text-gray-300">{{ $pedido->endereco_entrega }}</pre>
                </div>
            </div>
        </div>

        <!-- Coluna Direita - Resumo e Informações -->
        <div class="space-y-6" style="overflow: auto; max-height:600px">
            <!-- Card Resumo do Pedido -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Resumo do Pedido</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                        <span class="text-gray-900 dark:text-white">
                            {{ format_kwanza($pedido->total - $pedido->custo_envio + $pedido->valor_desconto) }}
                        </span>
                    </div>
                    
                    @if($pedido->custo_envio > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Frete</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ format_kwanza($pedido->custo_envio) }}
                            </span>
                        </div>
                    @endif
                    
                    @if($pedido->valor_desconto > 0)
                        <div class="flex justify-between">
                            <span class="text-green-600 dark:text-green-400">Desconto</span>
                            <span class="text-green-600 dark:text-green-400">
                                -{{ format_kwanza($pedido->valor_desconto) }}
                            </span>
                        </div>
                        
                        @if($pedido->cupom)
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Cupom: {{ $pedido->cupom->codigo }}
                            </div>
                        @endif
                    @endif
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ format_kwanza($pedido->total) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Informações do Cliente -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Cliente</h2>
                
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-12 w-12">
                        <img class="h-12 w-12 rounded-full" 
                             src="{{ $pedido->usuario->avatar_url ? image_url($pedido->usuario->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($pedido->usuario->nome) }}" 
                             alt="{{ $pedido->usuario->nome }}">
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $pedido->usuario->nome }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $pedido->usuario->email }}
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    @if($pedido->usuario->telefone)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $pedido->usuario->telefone }}
                        </div>
                    @endif
                    
                    <a href="mailto:{{ $pedido->usuario->email }}" 
                       class="flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Enviar email
                    </a>
                </div>
            </div>

            <!-- Card Informações de Pagamento -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pagamento</h2>
                
                @if($pedido->pagamento)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Método</span>
                            <span class="text-gray-900 dark:text-white capitalize">
                                {{ $pedido->pagamento->metodo }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status</span>
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $pedido->pagamento->status == 'pago' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                {{ $pedido->pagamento->status == 'pendente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                {{ $pedido->pagamento->status == 'falhou' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                {{ $pedido->pagamento->status == 'reembolsado' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}">
                                {{ ucfirst($pedido->pagamento->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Valor</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ format_kwanza($pedido->pagamento->valor) }}
                            </span>
                        </div>
                        
                        @if($pedido->pagamento->transacao_id)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">ID da Transação</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Illuminate\Support\Str::limit($pedido->pagamento->transacao_id, 15) }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Pago em: {{ $pedido->pagamento->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Informações de pagamento não disponíveis.</p>
                @endif
            </div>

            <!-- Card Informações de Envio -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Envio</h2>
                
                <div class="space-y-3">
                    @if($pedido->metodo_envio)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Método</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ $pedido->metodo_envio }}
                            </span>
                        </div>
                    @endif
                    
                    @if($pedido->data_entrega)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Previsão de Entrega</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($pedido->data_entrega)->format('d/m/Y') }}
                            </span>
                        </div>
                    @endif
                    
                    @if($pedido->observacoes)
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Observações</span>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                {{ $pedido->observacoes }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Metadados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Metadados</h2>
                
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Código do Pedido</span>
                        <span class="text-gray-900 dark:text-white">{{ $pedido->codigo_pedido }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">ID do Pedido</span>
                        <span class="text-gray-900 dark:text-white">{{ $pedido->id_pedido }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Criado em</span>
                        <span class="text-gray-900 dark:text-white">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Última atualização</span>
                        <span class="text-gray-900 dark:text-white">{{ $pedido->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
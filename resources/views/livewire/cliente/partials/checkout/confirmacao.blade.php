@php
dd($pedido, $pedido->enderecoEntrega, $enderecoEntrega);
@endphp
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
    <div class="p-8 text-center">
        <!-- Ícone de Sucesso -->
        <div class="w-20 h-20 mx-auto mb-6 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
            <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Pedido Confirmado!
        </h1>
        
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Seu pedido #{{ $pedido->numero_pedido }} foi recebido com sucesso.
        </p>
        
        <!-- Status do Pagamento -->
        @if($pagamentoResultado && isset($pagamentoResultado['pagamento']))
            @php
                $pagamento = $pagamentoResultado['pagamento'];
            @endphp
            
            <div class="max-w-md mx-auto mb-8">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Status do Pagamento:</span>
                        @if($pagamento->status == 'pago')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 font-medium">
                                Pago
                            </span>
                        @elseif($pagamento->status == 'pendente')
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 font-medium">
                                Pendente
                            </span>
                        @endif
                    </div>
                    
                    @if($pagamento->metodo == 'boleto' && $pagamento->detalhes['codigo_boleto'] ?? false)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Boleto Bancário</h4>
                            <div class="bg-white dark:bg-gray-800 p-4 rounded border">
                                <div class="text-center mb-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Código de Barras</div>
                                    <div class="font-mono text-lg tracking-wider">
                                        {{ $pagamento->detalhes['codigo_boleto'] }}
                                    </div>
                                </div>
                                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                                    Vencimento: {{ $pagamento->detalhes['vencimento'] ?? '3 dias úteis' }}
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($pagamento->status == 'pago' && isset($pagamento->detalhes['codigo_autorizacao']))
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Código de Autorização:</span>
                                    <span class="font-medium">{{ $pagamento->detalhes['codigo_autorizacao'] }}</span>
                                </div>
                                @if(isset($pagamento->detalhes['resposta_simulada']['nsu']))
                                    <div class="flex justify-between mt-2">
                                        <span class="text-gray-500 dark:text-gray-400">NSU:</span>
                                        <span class="font-medium">{{ $pagamento->detalhes['resposta_simulada']['nsu'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Informações do Pedido -->
        <div class="max-w-2xl mx-auto mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Resumo -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h3 class="font-medium text-gray-900 dark:text-white mb-4">Resumo do Pedido</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Número:</span>
                            <span class="font-medium">{{ $pedido->numero_pedido }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Data:</span>
                            <span class="font-medium">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total:</span>
                            <span class="font-medium text-blue-600">{{ format_kwanza($pedido->total) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Entrega -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h3 class="font-medium text-gray-900 dark:text-white mb-4">Entrega</h3>
                    @if($pedido->enderecoEntrega)
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $pedido->enderecoEntrega->logradouro }}, {{ $pedido->enderecoEntrega->numero }}<br>
                            {{ $pedido->enderecoEntrega->bairro }}<br>
                            {{ $pedido->enderecoEntrega->cidade }}/{{ $pedido->enderecoEntrega->estado }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Botões de Ação -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('cliente.pedidos') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Ver Meus Pedidos
            </a>
            
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Continuar Comprando
            </a>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 py-8">
    @php
        use Illuminate\Support\Facades\Auth;
        $usuario = Auth::user();
    @endphp

    <!-- Cards de Resumo Rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card Pedidos em Andamento -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pedidos em Andamento</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $pedidosAndamento }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('cliente.pedidos') }}" class="text-blue-600 dark:text-blue-400 text-sm mt-4 block hover:underline">
                Ver todos →
            </a>
        </div>

        <!-- Card Favoritos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Favoritos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalFavoritos }}</p>
                </div>
                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('cliente.favoritos') }}" class="text-blue-600 dark:text-blue-400 text-sm mt-4 block hover:underline">
                Ver favoritos →
            </a>
        </div>

        <!-- Card Carrinho -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Itens no Carrinho</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalCarrinho }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('cliente.carrinho') }}" class="text-blue-600 dark:text-blue-400 text-sm mt-4 block hover:underline">
                Ver carrinho →
            </a>
        </div>

        <!-- Card Pedidos Entregues -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pedidos Entregues</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $pedidosEntregues }}</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('cliente.pedidos') }}?status=entregue" class="text-blue-600 dark:text-blue-400 text-sm mt-4 block hover:underline">
                Ver entregues →
            </a>
        </div>
    </div>

    <!-- Grid Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna 1: Pedidos Recentes -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Pedidos Recentes</h2>
                </div>
                <div class="p-6">
                    @if($pedidosRecentes->count() > 0)
                        <div class="space-y-4">
                            @foreach($pedidosRecentes as $pedido)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            Pedido #{{ $pedido->codigo_pedido }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            @if($pedido->status == 'entregue') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @elseif($pedido->status == 'enviado') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($pedido->status == 'processando') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                            @endif">
                                            {{ ucfirst($pedido->status) }}
                                        </span>
                                        <span class="font-bold text-gray-900 dark:text-white">
                                            {{ format_kwanza($pedido->total) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-4 text-gray-500 dark:text-gray-400">Nenhum pedido realizado ainda</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Ir para loja
                            </a>
                        </div>
                    @endif
                </div>
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('cliente.pedidos') }}" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center justify-center">
                        Ver todos os pedidos
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Coluna 2: Links Rápidos e Promoções -->
        <div class="space-y-6">
            <!-- Links Rápidos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Acesso Rápido</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('cliente.conta') }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Minha Conta</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Editar dados pessoais</p>
                            </div>
                        </a>

                        <a href="{{ route('cliente.favoritos') }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Favoritos</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Produtos salvos</p>
                            </div>
                        </a>

                        <a href="{{ route('cliente.carrinho') }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Carrinho</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Finalizar compra</p>
                            </div>
                        </a>

                        <a href="{{ route('cliente.pedidos') }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Meus Pedidos</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Histórico completo</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Promoções -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-bold">Promoção Especial!</h3>
                        <p class="mt-2 opacity-90">10% de desconto na primeira compra</p>
                        <p class="text-sm opacity-80 mt-1">Use o cupom: BEMVINDO10</p>
                    </div>
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="mt-4 inline-block w-full text-center bg-white text-blue-600 font-bold py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    Aproveitar Oferta
                </a>
            </div>
        </div>
    </div>
</div>
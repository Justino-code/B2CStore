<div class="container mx-auto px-4 py-8">
    <!-- Cabeçalho -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            <svg class="w-8 h-8 inline-block mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
            </svg>
            Meus Favoritos
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Gerencie todos os produtos que você salvou para comprar depois
        </p>
    </div>

    @if(count($favoritos) > 0)
        <!-- Barra de Informações e Controles -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center">
                    <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ count($favoritos) }} produto(s) salvos
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Adicione produtos ao carrinho para ver o total
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <a 
                        href="{{ route('home') }}"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Continuar Comprando
                    </a>
                    
                    <button 
                        wire:click="irParaCarrinho"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Ver Carrinho
                    </button>
                </div>
            </div>
            
            <!-- Ações em Lote -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Selecione os produtos para ações em lote
                        </span>
                    </div>
                    <button 
                        wire:click="removerTodosFavoritos"
                        class="px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors flex items-center text-sm"
                        onclick="return confirm('Tem certeza que deseja remover todos os favoritos?')"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Limpar Tudo
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid de Produtos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($favoritos as $favorito)
                @php
                    $produto = $favorito->produto;
                    $noCarrinho = $this->produtoEstaNoCarrinho($produto->id_produto);
                    $precoAtual = $produto->preco_promocional ?? $produto->preco;
                    $temDesconto = $produto->preco_promocional && $produto->preco_promocional < $produto->preco;
                @endphp
                
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                    <!-- Cabeçalho do Card com Badges -->
                    <div class="relative">
                        @if($temDesconto)
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2.5 py-1 text-xs font-bold bg-red-600 text-white rounded-full">
                                    {{ number_format((($produto->preco - $precoAtual) / $produto->preco) * 100, 0) }}% OFF
                                </span>
                            </div>
                        @endif

                        <!-- Botão Remover Favorito -->
                        <div class="absolute top-3 right-3 z-10">
                            <button 
                                wire:click="confirmarRemoverFavorito({{ $favorito->id_favorito }})"
                                class="p-2 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full shadow-md hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-all transform hover:scale-110"
                                title="Remover dos favoritos"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Imagem do Produto -->
                        <a href="{{ route('produto.detalhe', $produto->slug) }}" class="block">
                            <div class="h-48 bg-gray-100 dark:bg-gray-700 overflow-hidden">
                                <img 
                                    src="{{ $produto->imagens->first()->url_imagem ?? 'https://via.placeholder.com/400x300' }}" 
                                    alt="{{ $produto->nome }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                />
                            </div>
                        </a>
                    </div>

                    <!-- Conteúdo do Card -->
                    <div class="p-4 flex-1 flex flex-col">
                        <!-- Categoria -->
                        <div class="mb-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ $produto->categoria->nome ?? 'Categoria' }}
                            </span>
                        </div>

                        <!-- Nome do Produto -->
                        <a href="{{ route('produto.detalhe', $produto->slug) }}" class="mb-3">
                            <h3 class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 line-clamp-2 h-12 transition-colors">
                                {{ $produto->nome }}
                            </h3>
                        </a>

                        <!-- Preço -->
                        <div class="mt-auto mb-4">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ format_kwanza($precoAtual) }}
                                </span>
                                @if($temDesconto)
                                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                        {{ format_kwanza($produto->preco) }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                em até 12x sem juros
                            </p>
                        </div>

                        <!-- Status do Estoque -->
                        <div class="mb-4">
                            @if($produto->estoque > 0)
                                @if($produto->estoque < 10)
                                    <div class="inline-flex items-center text-amber-600 dark:text-amber-400 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                        <span>Apenas {{ $produto->estoque }} em estoque</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center text-green-600 dark:text-green-400 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Em estoque</span>
                                    </div>
                                @endif
                            @else
                                <div class="inline-flex items-center text-red-600 dark:text-red-400 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <span>Esgotado</span>
                                </div>
                            @endif
                        </div>

                        <!-- Botões de Ação -->
                        <div class="flex gap-2 mt-auto">
                            @if($noCarrinho)
                                <button 
                                    disabled
                                    class="flex-1 py-3 bg-green-600 text-white rounded-lg flex items-center justify-center cursor-not-allowed opacity-75 font-medium"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    No Carrinho
                                </button>
                            @else
                                <button 
                                    wire:click="adicionarAoCarrinho({{ $produto->id_produto }})"
                                    class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ $produto->estoque <= 0 ? 'disabled' : '' }}
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Comprar
                                </button>
                            @endif
                            
                            <button 
                                wire:click="confirmarRemoverFavorito({{ $favorito->id_favorito }})"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center justify-center"
                                title="Remover dos favoritos"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado Vazio -->
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 md:p-12 text-center">
            <div class="w-24 h-24 mx-auto text-gray-400 dark:text-gray-600 mb-6">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Nenhum produto favoritado
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                Você ainda não salvou nenhum produto nos favoritos. Explore nossa loja e salve os produtos que você mais gosta para comprar depois!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a 
                    href="{{ route('home') }}"
                    class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                >
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Explorar Produtos
                </a>
                <a 
                    href="{{ route('categorias') }}"
                    class="inline-block px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                >
                    Ver Categorias
                </a>
            </div>
        </div>
    @endif

    <!-- Modal de Confirmação -->
    @if($mostrarModalRemover)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-2">
                        Remover dos Favoritos
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                        Tem certeza que deseja remover este produto dos seus favoritos?
                    </p>
                    
                    <div class="flex justify-center space-x-3">
                        <button 
                            wire:click="fecharModal"
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            wire:click="removerFavorito"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                        >
                            Sim, Remover
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
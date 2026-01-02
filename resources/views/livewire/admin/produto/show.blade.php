<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header com ações -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.produtos.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $produto->nome }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        SKU: {{ $produto->sku }} | 
                        Categoria: {{ $produto->categoria->nome ?? 'Sem categoria' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <!-- Status -->
                <button wire:click="toggleStatus"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium 
                            {{ $produto->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800' }}">
                    {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                </button>

                <!-- Destaque -->
                <button wire:click="toggleDestaque"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium 
                            {{ $produto->destaque ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 hover:bg-yellow-200 dark:hover:bg-yellow-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800' }}">
                    {{ $produto->destaque ? 'Em Destaque' : 'Sem Destaque' }}
                </button>

                <!-- Editar -->
                <a href="{{ route('admin.produtos.edit', $produto->id_produto) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Editar</span>
                </a>

                <!-- Deletar -->
                <button wire:click="$dispatch('confirm', {
                    title: 'Deletar Produto',
                    text: 'Tem certeza que deseja deletar o produto &quot;{{ addslashes($produto->nome) }}&quot;? Esta ação não pode ser desfeita.',
                    icon: 'warning',
                    confirmButtonText: 'Sim, deletar',
                    cancelButtonText: 'Cancelar',
                    method: 'delete-product-confirmed',
                    params: []
                })"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Deletar</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna Esquerda - Informações -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Imagens -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Imagens do Produto</h2>
                    
                    @if($produto->imagens->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($produto->imagens->sortBy('ordem') as $imagem)
                                <div class="relative group">
                                    <img src="{{ image_url($imagem->url_imagem) }}" 
                                         alt="{{ $produto->nome }}"
                                         class="h-48 w-full object-cover rounded-lg">
                                    
                                    @if($imagem->principal)
                                        <div class="absolute top-2 left-2 px-2 py-1 bg-blue-600 text-white text-xs rounded">
                                            Principal
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">Nenhuma imagem disponível</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Descrição -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Descrição</h2>
                    
                    <div class="prose dark:prose-invert max-w-none">
                        @if($produto->descricao)
                            {!! nl2br(e($produto->descricao)) !!}
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">Nenhuma descrição fornecida.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Reviews -->
            @if($produto->reviews->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Avaliações ({{ $produto->reviews->count() }})</h2>
                        
                        <div class="space-y-4">
                            @foreach($produto->reviews->take(5) as $review)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" 
                                                     src="{{ $review->usuario->avatar_url ? image_url($review->usuario->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($review->usuario->nome) }}" 
                                                     alt="{{ $review->usuario->nome }}">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $review->usuario->nome }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $review->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comentario)
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                            {{ $review->comentario }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Coluna Direita - Estatísticas e Detalhes -->
        <div class="space-y-6">
            <!-- Card Estatísticas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Estatísticas</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Vendas (30 dias)</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $vendasUltimos30Dias }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Estoque Atual</span>
                        <span class="font-bold {{ $produto->estoque < 5 ? 'text-red-600 dark:text-red-400' : ($produto->estoque < 10 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400') }}">
                            {{ $produto->estoque }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Reviews</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $produto->reviews->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Rating Médio</span>
                        <span class="font-bold text-gray-900 dark:text-white">
                            @if($produto->reviews->count() > 0)
                                {{ number_format($produto->reviews->avg('rating'), 1) }}/5
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Detalhes do Produto -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Detalhes do Produto</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Preço</label>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                            {{ format_kwanza($produto->preco) }}
                        </p>
                        @if($produto->preco_promocional)
                            <p class="text-sm text-green-600 dark:text-green-400">
                                Promoção: {{ format_kwanza($produto->preco_promocional) }}
                            </p>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">SKU</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $produto->sku }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Categoria</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $produto->categoria->nome ?? 'Sem categoria' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Peso</label>
                        <p class="mt-1 text-gray-900 dark:text-white">
                            {{ $produto->peso ? $produto->peso . ' kg' : 'Não informado' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dimensões</label>
                        <p class="mt-1 text-gray-900 dark:text-white">
                            {{ $produto->dimensoes ?: 'Não informado' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">URL</label>
                        <a href="{{ url('/produto/' . $produto->slug) }}" 
                           target="_blank"
                           class="mt-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm break-all">
                            {{ url('/produto/' . $produto->slug) }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Histórico de Estoque -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Histórico de Estoque</h2>
                
                <div class="space-y-3">
                    @foreach($estoqueHistorico as $historico)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $historico['data'] }}</span>
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $historico['estoque'] }}</span>
                                @if($loop->last)
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        Atual
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card Metadados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Metadados</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Criado em</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $produto->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Última atualização</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $produto->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">ID do Produto</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $produto->id_produto }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
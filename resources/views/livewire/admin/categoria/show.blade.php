<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header com ações -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.categorias.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $categoria->nome }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Ordem: {{ $categoria->ordem }} • 
                        {{ $estatisticas['totalProdutos'] }} produto(s)
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <!-- Status -->
                <button wire:click="toggleStatus"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium 
                            {{ $categoria->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                    {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                </button>

                <!-- Editar -->
                <a href="{{ route('admin.categorias.edit', $categoria->id_categoria) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Editar</span>
                </a>

                <!-- Deletar -->
                <button wire:click="$dispatch('confirm', {
                    title: 'Deletar Categoria',
                    text: 'Tem certeza que deseja deletar a categoria &quot;{{ addslashes($categoria->nome) }}&quot;? Esta ação não pode ser desfeita.',
                    icon: 'warning',
                    confirmButtonText: 'Sim, deletar',
                    cancelButtonText: 'Cancelar',
                    method: 'delete-category-confirmed',
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
        <!-- Coluna Esquerda - Detalhes da Categoria -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Detalhes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Detalhes da Categoria</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Imagem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Imagem</label>
                        <div class="mt-1">
                            @if($categoria->imagem_url)
                                <img src="{{ image_url($categoria->imagem_url) }}" 
                                     alt="{{ $categoria->nome }}"
                                     class="h-48 w-full object-cover rounded-lg">
                            @else
                                <div class="h-48 w-full bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informações -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nome</label>
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $categoria->nome }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ordem</label>
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $categoria->ordem }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Slug</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">
                                {{ \Illuminate\Support\Str::slug($categoria->nome) }}
                            </p>
                        </div>
                        
                        @if($categoria->descricao)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</label>
                                <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $categoria->descricao }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Produtos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Produtos ({{ $estatisticas['totalProdutos'] }})</h2>
                        
                        <div class="flex items-center space-x-2">
                            <select wire:model.live="filtroProdutos" 
                                    class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                <option value="todos">Todos</option>
                                <option value="ativos">Ativos</option>
                                <option value="inativos">Inativos</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                @if($produtos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortField = 'nome'; sortDirection = sortDirection === 'asc' ? 'desc' : 'asc'">
                                        Produto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortField = 'preco'; sortDirection = sortDirection === 'asc' ? 'desc' : 'asc'">
                                        Preço
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortField = 'estoque'; sortDirection = sortDirection === 'asc' ? 'desc' : 'asc'">
                                        Estoque
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortField = 'ativo'; sortDirection = sortDirection === 'asc' ? 'desc' : 'asc'">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($produtos as $produto)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($produto->imagens->first())
                                                        <img class="h-10 w-10 rounded-md object-cover" 
                                                             src="{{ image_url($produto->imagens->first()->url_imagem) }}" 
                                                             alt="{{ $produto->nome }}">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $produto->nome }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $produto->sku }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ format_kwanza($produto->preco) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium 
                                                {{ $produto->estoque < 5 ? 'text-red-600 dark:text-red-400' : ($produto->estoque < 10 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400') }}">
                                                {{ $produto->estoque }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $produto->ativo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.produtos.show', $produto->id_produto) }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginação -->
                    @if($produtos->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $produtos->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Nenhum produto encontrado</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">
                            Esta categoria não possui produtos associados.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Coluna Direita - Estatísticas e Metadados -->
        <div class="space-y-6">
            <!-- Card Estatísticas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Estatísticas</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total de Produtos</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $estatisticas['totalProdutos'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Produtos Ativos</span>
                        <span class="font-bold text-green-600 dark:text-green-400">{{ $estatisticas['produtosAtivos'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Em Destaque</span>
                        <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ $estatisticas['produtosDestaque'] }}</span>
                    </div>
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-900 dark:text-white">Valor do Estoque</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">
                                {{ format_kwanza($estatisticas['valorTotalEstoque']) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Metadados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Metadados</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">ID da Categoria</span>
                        <span class="text-gray-900 dark:text-white">{{ $categoria->id_categoria }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Criado em</span>
                        <span class="text-gray-900 dark:text-white">{{ $categoria->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Última atualização</span>
                        <span class="text-gray-900 dark:text-white">{{ $categoria->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Card Ações Rápidas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ações Rápidas</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.produtos.create') }}?categoria={{ $categoria->id_categoria }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Adicionar Produto</span>
                    </a>
                    
                    <button onclick="copiarSlug('{{ \Illuminate\Support\Str::slug($categoria->nome) }}')"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>Copiar Slug</span>
                    </button>
                    
                    <a href="{{ url('/categoria/' . \Illuminate\Support\Str::slug($categoria->nome)) }}" 
                       target="_blank"
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Ver na Loja</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    function copiarSlug(slug) {
        navigator.clipboard.writeText(slug).then(() => {
            // Usar sistema de notificações do Livewire
            Livewire.dispatch('notify', {
                type: 'success',
                message: 'Slug copiado para a área de transferência: ' + slug
            });
        }).catch(err => {
            console.error('Erro ao copiar slug: ', err);
            
            // Usar sistema de notificações do Livewire para erro
            Livewire.dispatch('notify', {
                type: 'error',
                message: 'Erro ao copiar slug'
            });
        });
    }
</script>
@endscript
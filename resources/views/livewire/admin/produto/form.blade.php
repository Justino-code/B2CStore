<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $isEditing ? 'Editar Produto' : 'Novo Produto' }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ $isEditing ? 'Atualize as informações do produto' : 'Preencha os dados do novo produto' }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.produtos.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium transition-colors">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="salvar" x-data="{ isSubmitting: false }" x-on:submit="isSubmitting = true">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Coluna Esquerda - Informações Básicas -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Informações Básicas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informações Básicas</h2>
                    
                    <div class="space-y-4">
                        <!-- Nome do Produto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nome do Produto *
                            </label>
                            <input type="text" 
                                   wire:model="nome"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Slug (URL) *
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">
                                    /produto/
                                </span>
                                <input type="text" 
                                       wire:model="slug"
                                       class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            </div>
                            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Descrição
                            </label>
                            <textarea wire:model="descricao" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors"></textarea>
                            @error('descricao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Categoria e SKU -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Categoria *
                                </label>
                                <select wire:model="id_categoria"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nome }}</option>
                                    @endforeach
                                </select>
                                @error('id_categoria') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    SKU *
                                </label>
                                <div class="flex">
                                    <input type="text" 
                                           wire:model="sku"
                                           class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                                    <button type="button"
                                            wire:click="gerarSKU"
                                            class="ml-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg transition-colors">
                                        Gerar
                                    </button>
                                </div>
                                @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Preços -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Preços</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Preço Normal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Preço Normal *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">AOA</span>
                                </div>
                                <input type="number" 
                                       wire:model="preco"
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-16 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            </div>
                            @error('preco') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Preço Promocional -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Preço Promocional
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">AOA</span>
                                </div>
                                <input type="number" 
                                       wire:model="preco_promocional"
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-16 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            </div>
                            @error('preco_promocional') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Card Estoque -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Estoque e Envio</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Estoque -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Estoque *
                            </label>
                            <input type="number" 
                                   wire:model="estoque"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            @error('estoque') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Peso -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Peso (kg)
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model="peso"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">kg</span>
                                </div>
                            </div>
                            @error('peso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Dimensões -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Dimensões (LxAxC)
                            </label>
                            <input type="text" 
                                   wire:model="dimensoes"
                                   placeholder="ex: 30x20x15"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors">
                            @error('dimensoes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Imagens e Configurações -->
            <div class="space-y-6">
                <!-- Card Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status</h2>
                    
                    <div class="space-y-4">
                        <!-- Ativo -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Produto Ativo
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    O produto será visível na loja
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="ativo"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 transition-colors"></div>
                            </label>
                        </div>

                        <!-- Destaque -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Produto em Destaque
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Aparecerá na página inicial
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="destaque"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-yellow-600 transition-colors"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card Imagens -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Imagens do Produto</h2>
                    
                    <!-- Upload de novas imagens -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Adicionar Imagens
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg transition-colors hover:border-blue-500 dark:hover:border-blue-400">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="imagens" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-colors">
                                        <span>Carregar imagens</span>
                                        <input id="imagens" 
                                               wire:model="imagens"
                                               type="file"
                                               multiple
                                               accept="image/*"
                                               class="sr-only">
                                    </label>
                                    <p class="pl-1">ou arraste e solte</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, GIF até 2MB cada
                                </p>
                            </div>
                        </div>
                        @error('imagens.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Prévia das imagens -->
                    @if(count($imagens) > 0 || count($imagensExistentes) > 0)
                        <div class="grid grid-cols-3 gap-2 mt-4">
                            <!-- Imagens existentes -->
                            @foreach($imagensExistentes as $index => $imagem)
                                <div class="relative group">
                                    <img src="{{ image_url($imagem['url']) }}" 
                                         alt="Produto"
                                         class="h-24 w-full object-cover rounded-lg">
                                    
                                    <!-- Indicador de imagem principal -->
                                    @if($imagem['principal'])
                                        <div class="absolute top-1 left-1 px-2 py-1 text-xs bg-blue-600 text-white rounded">
                                            Principal
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay com ações -->
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex flex-col items-center justify-center space-y-1 p-2">
                                        @if(!$imagem['principal'])
                                            <button type="button"
                                                    wire:click="definirImagemPrincipal({{ $index }})"
                                                    class="w-full px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors">
                                                Tornar Principal
                                            </button>
                                        @endif
                                        <button type="button"
                                                wire:click="removerImagem('{{ $imagem['id'] }}')"
                                                class="w-full px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition-colors">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Novas imagens -->
                            @foreach($imagens as $index => $imagem)
                                <div class="relative group">
                                    <img src="{{ $imagem->temporaryUrl() }}" 
                                         alt="Nova imagem"
                                         class="h-24 w-full object-cover rounded-lg">
                                    
                                    <!-- Overlay com ações -->
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <button type="button"
                                                wire:click="removerImagemTemporaria({{ $index }})"
                                                class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition-colors">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Nenhuma imagem adicionada
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Card Ações -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <button type="submit"
                                :disabled="isSubmitting"
                                wire:loading.attr="disabled"
                                wire:target="salvar"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span>
                                <span wire:loading.remove wire:target="salvar">
                                    {{ $isEditing ? 'Atualizar Produto' : 'Criar Produto' }}
                                </span>
                                <span wire:loading wire:target="salvar">
                                    <span class="inline-flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Salvando...
                                    </span>
                                </span>
                            </span>
                        </button>

                        <a href="{{ route('admin.produtos.index') }}" 
                           class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                            <span>Cancelar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@script
<script>
    // Initialize file upload drag and drop
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.querySelector('.border-dashed');
        
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
                dropArea.classList.remove('border-gray-300', 'dark:border-gray-600');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
                dropArea.classList.add('border-gray-300', 'dark:border-gray-600');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                // Trigger file input with dropped files
                const input = document.getElementById('imagens');
                if (input && files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
                
                // Mostrar notificação
                if (files.length > 0) {
                    // Dispara evento para mostrar notificação
                    Livewire.dispatch('notify', {
                        type: 'success',
                        message: `${files.length} imagem(ns) adicionada(s)!`
                    });
                }
            }
        }
    });
</script>
@endscript
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $isEditing ? 'Editar Categoria' : 'Nova Categoria' }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ $isEditing ? 'Atualize as informações da categoria' : 'Preencha os dados da nova categoria' }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.categorias.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium">
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
                        <!-- Nome -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nome da Categoria *
                            </label>
                            <input type="text" 
                                   wire:model="nome"
                                   placeholder="Ex: Eletrônicos, Roupas, Alimentos..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Descrição
                            </label>
                            <textarea wire:model="descricao" 
                                      rows="4"
                                      placeholder="Descreva esta categoria..."
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                            @error('descricao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ordem -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ordem de Exibição *
                                </label>
                                <input type="number" 
                                       wire:model="ordem"
                                       min="1"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('ordem') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Define a posição na lista de categorias
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Imagem -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Imagem da Categoria</h2>
                    
                    <div class="space-y-4">
                        <!-- Upload de Imagem -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Imagem
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="imagem" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Carregar imagem</span>
                                            <input id="imagem" 
                                                   wire:model="imagem"
                                                   type="file"
                                                   accept="image/*"
                                                   class="sr-only">
                                        </label>
                                        <p class="pl-1">ou arraste e solte</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG, GIF até 2MB
                                    </p>
                                </div>
                            </div>
                            @error('imagem') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prévia da Imagem -->
                        @if($imagem || $imagemAtual)
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Prévia
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        @if($imagem)
                                            <img src="{{ $imagem->temporaryUrl() }}" 
                                                 alt="Nova imagem"
                                                 class="h-32 w-32 object-cover rounded-lg">
                                        @elseif($imagemAtual)
                                            <img src="{{ image_url($imagemAtual) }}" 
                                                 alt="Imagem atual"
                                                 class="h-32 w-32 object-cover rounded-lg">
                                        @endif
                                    </div>
                                    <div>
                                        <button type="button"
                                                wire:click="$dispatch('confirm', {
                                                    title: 'Remover Imagem',
                                                    text: 'Tem certeza que deseja remover a imagem desta categoria?',
                                                    icon: 'warning',
                                                    confirmButtonText: 'Sim, remover',
                                                    cancelButtonText: 'Cancelar',
                                                    method: 'confirm-remove-image',
                                                    params: []
                                                })"
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">
                                            Remover Imagem
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Status e Ações -->
            <div class="space-y-6">
                <!-- Card Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status</h2>
                    
                    <div class="space-y-4">
                        <!-- Ativo -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Categoria Ativa
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    A categoria será visível na loja
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="ativo"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card Prévia -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Prévia</h2>
                    
                    <div class="space-y-4">
                        <!-- Card da Categoria -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <!-- Imagem -->
                            <div class="h-32 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                @if($imagem)
                                    <img src="{{ $imagem->temporaryUrl() }}" 
                                         alt="{{ $nome }}"
                                         class="h-full w-full object-cover">
                                @elseif($imagemAtual)
                                    <img src="{{ image_url($imagemAtual) }}" 
                                         alt="{{ $nome }}"
                                         class="h-full w-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Informações -->
                            <div class="p-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $nome ?: 'Nome da Categoria' }}
                                </h3>
                                @if($descricao)
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($descricao, 60) }}
                                    </p>
                                @endif
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Ordem: {{ $ordem }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $ativo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $ativo ? 'Ativa' : 'Inativa' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Informações Técnicas -->
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex justify-between">
                                <span>Slug:</span>
                                <span class="font-mono text-gray-900 dark:text-white">
                                    {{ $nome ? Str::slug($nome) : 'nome-da-categoria' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Ações -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <button type="submit"
                                :disabled="isSubmitting"
                                wire:loading.attr="disabled"
                                wire:target="salvar"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span>
                                <span wire:loading.remove wire:target="salvar">
                                    {{ $isEditing ? 'Atualizar Categoria' : 'Criar Categoria' }}
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

                        <a href="{{ route('admin.categorias.index') }}" 
                           class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
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
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                // Trigger file input with dropped files
                const input = document.getElementById('imagem');
                if (input && files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
                
                // Mostrar notificação
                if (files.length > 0) {
                    // Dispara evento para mostrar notificação
                    Livewire.dispatch('notify', {
                        type: 'success',
                        message: 'Imagem adicionada com sucesso!'
                    });
                }
            }
        }
    });
</script>
@endscript
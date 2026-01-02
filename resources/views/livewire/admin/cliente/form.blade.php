<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $isEditing ? 'Editar Cliente' : 'Novo Cliente' }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ $isEditing ? 'Atualize as informações do cliente' : 'Preencha os dados do novo cliente' }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.clientes.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="salvar">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Coluna Esquerda - Informações Básicas -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Informações Pessoais -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informações Pessoais</h2>
                    
                    <div class="space-y-4">
                        <!-- Nome -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nome Completo *
                            </label>
                            <input type="text" 
                                   wire:model="nome"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email *
                            </label>
                            <input type="email" 
                                   wire:model="email"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Telefone
                            </label>
                            <input type="text" 
                                   wire:model="telefone"
                                   placeholder="+244 123 456 789"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('telefone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Card Endereço -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Endereço</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Endereço Completo
                        </label>
                        <textarea wire:model="endereco" 
                                  rows="4"
                                  placeholder="Rua, número, bairro, cidade, código postal..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('endereco') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Card Senha -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Senha</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nova Senha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $isEditing ? 'Nova Senha (deixe em branco para manter)' : 'Senha *' }}
                            </label>
                            <input type="password" 
                                   wire:model="senha"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('senha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Senha
                            </label>
                            <input type="password" 
                                   wire:model="confirmar_senha"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('confirmar_senha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Avatar e Configurações -->
            <div class="space-y-6">
                <!-- Card Avatar -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Foto do Perfil</h2>
                    
                    <div class="space-y-4">
                        <!-- Upload de Avatar -->
                        <div>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="avatar" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Carregar foto</span>
                                            <input id="avatar" 
                                                   wire:model="avatar"
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
                            @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prévia do Avatar -->
                        @if($avatar || $avatarAtual)
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Prévia
                                </label>
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="relative">
                                        @if($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" 
                                                 alt="Novo avatar"
                                                 class="h-32 w-32 rounded-full object-cover">
                                        @elseif($avatarAtual)
                                            <img src="{{ image_url($avatarAtual) }}" 
                                                 alt="Avatar atual"
                                                 class="h-32 w-32 rounded-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <button type="button"
                                                wire:click="removerAvatar"
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm">
                                            Remover Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status</h2>
                    
                    <div class="space-y-4">
                        <!-- Email Verificado -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email Verificado
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Cliente confirmou o email
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="email_verificado"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <!-- Bloqueado -->
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Conta Bloqueada
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Cliente não pode fazer login
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="bloqueado"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card Prévia -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Prévia</h2>
                    
                    <div class="space-y-4">
                        <!-- Card do Cliente -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" 
                                             alt="{{ $nome }}"
                                             class="h-12 w-12 rounded-full object-cover">
                                    @elseif($avatarAtual)
                                        <img src="{{ image_url($avatarAtual) }}" 
                                             alt="{{ $nome }}"
                                             class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                            <span class="text-lg font-bold text-blue-600 dark:text-blue-300">
                                                {{ substr($nome ?: 'C', 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $nome ?: 'Nome do Cliente' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $email ?: 'email@exemplo.com' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-4 space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                    <div class="flex items-center space-x-1">
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            {{ $email_verificado ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                            {{ $email_verificado ? 'Verificado' : 'Não Verificado' }}
                                        </span>
                                        @if($bloqueado)
                                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                Bloqueado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($telefone)
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-500 dark:text-gray-400">Telefone:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $telefone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Ações -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span>{{ $isEditing ? 'Atualizar Cliente' : 'Criar Cliente' }}</span>
                        </button>

                        <a href="{{ route('admin.clientes.index') }}" 
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
                const input = document.getElementById('avatar');
                if (input && files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        }
    });
</script>
@endscript
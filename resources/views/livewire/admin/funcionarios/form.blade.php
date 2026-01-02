<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $isEditing ? 'Editar Funcionário' : 'Novo Funcionário' }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ $isEditing ? 'Atualize os dados do funcionário' : 'Cadastre um novo funcionário no sistema' }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.funcionarios.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" x-data="{ isSubmitting: false }" x-on:submit="isSubmitting = true">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Coluna Esquerda - Informações Básicas -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Informações Básicas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informações Básicas</h2>
                    
                    <div class="space-y-6">
                        <!-- Avatar e Nome -->
                        <div class="flex items-start space-x-6">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    @if($avatar || ($funcionario && $funcionario->avatar_url))
                                        <img class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 shadow-lg object-cover" 
                                             src="{{ $avatar ? $avatar->temporaryUrl() : image_url($funcionario->avatar_url) }}" 
                                             alt="Avatar">
                                        <button type="button" 
                                                @click="$dispatch('confirm', {
                                                    title: 'Remover Foto',
                                                    text: 'Tem certeza que deseja remover a foto do perfil?',
                                                    icon: 'warning',
                                                    confirmButtonText: 'Sim, remover',
                                                    cancelButtonText: 'Cancelar',
                                                    method: 'confirm-remove-avatar',
                                                    params: []
                                                })"
                                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-full shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 shadow-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-4">
                                    <label for="avatar-upload" 
                                           class="cursor-pointer px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center space-x-2 transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        <span>Upload Foto</span>
                                    </label>
                                    <input id="avatar-upload" 
                                           type="file" 
                                           wire:model="avatar"
                                           class="hidden"
                                           accept="image/*">
                                    @error('avatar')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 text-center">
                                        PNG, JPG até 2MB
                                    </p>
                                </div>
                            </div>

                            <!-- Nome -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nome Completo *
                                </label>
                                <input type="text" 
                                       wire:model="nome"
                                       placeholder="Digite o nome completo"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-base">
                                @error('nome')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email e Telefone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email *
                                </label>
                                <input type="email" 
                                       wire:model="email"
                                       placeholder="email@exemplo.com"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Telefone
                                </label>
                                <input type="text" 
                                       wire:model="telefone"
                                       placeholder="(XX) XXXXX-XXXX"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('telefone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Endereço (Opcional)
                            </label>
                            <textarea wire:model="endereco" 
                                      rows="3"
                                      placeholder="Rua, número, bairro, município, província, complemento, referência..."
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                            @error('endereco')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Formato: Rua, Número, Bairro, Município, Província, Complemento, Referência
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Senha -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Senha de Acesso</h2>
                    
                    <div class="space-y-6">
                        <!-- Senha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $isEditing ? 'Nova Senha (deixe em branco para manter a atual)' : 'Senha *' }}
                            </label>
                            <div class="relative">
                                <input :type="$wire.showPassword ? 'text' : 'password'"
                                       wire:model="password"
                                       placeholder="{{ $isEditing ? 'Digite a nova senha' : 'Digite uma senha segura' }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white pr-12">
                                
                                <button type="button" 
                                        wire:click="$toggle('showPassword')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path x-show="$wire.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        <path x-show="!$wire.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path x-show="!$wire.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Senha
                            </label>
                            <input :type="$wire.showPassword ? 'text' : 'password'"
                                   wire:model="password_confirmation"
                                   placeholder="Confirme a senha"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Gerar Senha -->
                        <div>
                            <button type="button" 
                                    wire:click="generatePassword"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center space-x-2 transition-colors text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Gerar Senha Aleatória</span>
                            </button>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Use letras maiúsculas, minúsculas, números e símbolos
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Configurações e Ações -->
            <div class="space-y-6">
                <!-- Card Cargo -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Cargo e Permissões</h2>
                    
                    <div class="space-y-4">
                        <!-- Cargo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cargo *
                            </label>
                            <select wire:model="role"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Selecione um cargo</option>
                                <option value="operador">Operador</option>
                                <option value="suporte">Suporte</option>
                                <option value="gerente">Gerente</option>
                                <option value="admin">Administrador</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            <!-- Legenda dos Cargos -->
                            <div class="mt-4 space-y-2 text-sm">
                                <div class="flex items-start space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Admin</span>
                                    <span class="text-gray-600 dark:text-gray-400">Acesso completo ao sistema</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">Gerente</span>
                                    <span class="text-gray-600 dark:text-gray-400">Gerencia operações e relatórios</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">Operador</span>
                                    <span class="text-gray-600 dark:text-gray-400">Operações básicas do sistema</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Suporte</span>
                                    <span class="text-gray-600 dark:text-gray-400">Atendimento e suporte ao cliente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status</h2>
                    
                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status do Funcionário *
                            </label>
                            <select wire:model="status"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Selecione um status</option>
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ativo -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Acesso Ativo
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Permite login no sistema
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="status"
                                       value="ativo"
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
                        <!-- Card do Funcionário -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <!-- Avatar -->
                            <div class="h-40 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                @if($avatar || ($funcionario && $funcionario->avatar_url))
                                    <img src="{{ $avatar ? $avatar->temporaryUrl() : image_url($funcionario->avatar_url) }}" 
                                         alt="{{ $nome }}"
                                         class="h-full w-full object-cover">
                                @else
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Informações -->
                            <div class="p-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $nome ?: 'Nome do Funcionário' }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $email ?: 'email@exemplo.com' }}
                                </p>
                                
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Cargo:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white capitalize">
                                            {{ $role ?: 'Não definido' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                        <span class="px-2 py-1 text-xs rounded-full {{ ($status === 'ativo') ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ ($status === 'ativo') ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </div>
                                </div>
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
                                wire:target="save"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span>
                                <span wire:loading.remove wire:target="save">
                                    {{ $isEditing ? 'Atualizar Funcionário' : 'Criar Funcionário' }}
                                </span>
                                <span wire:loading wire:target="save">
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

                        <a href="{{ route('admin.funcionarios.index') }}" 
                           class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                            <span>Cancelar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Loading Overlay -->
    <div wire:loading.flex wire:target="save" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm w-full mx-4">
            <div class="flex flex-col items-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-700 dark:text-gray-300 text-center">Salvando funcionário...</p>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Initialize file upload drag and drop
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.querySelector('#avatar-upload')?.closest('div');
        
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
                const input = document.getElementById('avatar-upload');
                if (input && files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    // Dispara evento para mostrar notificação
                    Livewire.dispatch('notify', {
                        type: 'success',
                        message: 'Imagem adicionada com sucesso!'
                    });
                }
            }
        }

        // Toggle password visibility
        Livewire.on('passwordToggled', () => {
            // Alpine.js handles this automatically
        });
    });
</script>
@endscript
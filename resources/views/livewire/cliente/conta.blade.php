<div>

    <div class="container mx-auto px-4 py-8">
          <!-- Mensagens de Status -->
        @if($sucesso || $erro)
            <div 
                x-data="{ show: true }" 
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                x-init="setTimeout(() => show = false, 5000)"
                class="mb-6"
            >
                <div class="{{ $sucesso ? 'bg-green-100 border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300' : 'bg-red-100 border-red-400 text-red-700 dark:bg-red-900 dark:border-red-700 dark:text-red-300' }} border rounded-lg p-4">
                    <div class="flex items-center">
                        @if($sucesso)
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        @endif
                        <span>{{ $mensagem }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Menu Lateral -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-8">
                    <!-- Avatar -->
                    <div class="p-6 text-center border-b border-gray-200 dark:border-gray-700">
                        <div class="relative inline-block">
                            <div class="w-24 h-24 rounded-full overflow-hidden mx-auto border-4 border-white dark:border-gray-800 shadow-lg">
                                @if($avatarPreview)
                                    <img 
                                        src="{{ $avatarPreview }}" 
                                        alt="{{ $nome }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-2xl font-bold text-white">
                                            {{ strtoupper(substr($nome, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <button 
                                wire:click="$set('avatar', null)"
                                wire:loading.attr="disabled"
                                class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 shadow-lg"
                                @if(!$avatarPreview && !$avatar) disabled @endif
                                title="{{ $avatarPreview ? 'Remover nova foto' : 'Cancelar upload' }}"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">{{ $nome }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $email }}</p>
                        
                        <!-- Upload Avatar -->
                        <div class="mt-4">
                            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Alterar Foto
                                <input 
                                    type="file" 
                                    wire:model="avatar"
                                    class="hidden"
                                    accept="image/*"
                                >
                            </label>
                            @if($avatarUrl && !$avatar)
                                <button 
                                    wire:click="removerAvatar"
                                    class="mt-2 text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                                >
                                    Remover foto atual
                                </button>
                            @endif
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Informações da Conta -->
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-2">Informações da Conta</h4>
                        <ul class="text-sm space-y-1">
                            <li class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Membro desde:</span>
                                <span class="text-gray-900 dark:text-white">{{ $usuario->created_at->format('d/m/Y') }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">E-mail verificado:</span>
                                <span class="{{ $usuario->email_verificado_em ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $usuario->email_verificado_em ? 'Sim' : 'Não' }}
                                </span>
                            </li>
                            @if(!$usuario->email_verificado_em)
                                <li>
                                    <button class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                        Reenviar verificação
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Formulário de Perfil -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informações Pessoais</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Atualize suas informações de contato e endereço
                        </p>
                    </div>
                    
                    <form wire:submit="salvarPerfil" class="p-6 space-y-6">
                        <!-- Nome Completo -->
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nome Completo *
                            </label>
                            <input 
                                type="text" 
                                id="nome"
                                wire:model="nome"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Digite seu nome completo"
                                required
                            >
                            @error('nome')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                E-mail *
                            </label>
                            <input 
                                type="email" 
                                id="email"
                                wire:model="email"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="seu@email.com"
                                required
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Telefone
                            </label>
                            <input 
                                type="tel" 
                                id="telefone"
                                wire:model="telefone"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="(11) 99999-9999"
                            >
                            @error('telefone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Endereço -->
                        <div>
                            <label for="endereco" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Endereço Completo
                            </label>
                            <textarea 
                                id="endereco"
                                wire:model="endereco"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                placeholder="Rua, número, bairro, cidade, estado, CEP"
                            ></textarea>
                            @error('endereco')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="flex justify-end pt-4">
                            <button 
                                type="submit"
                                wire:loading.attr="disabled"
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors"
                            >
                                <span wire:loading.remove wire:target="salvarPerfil">
                                    Salvar Alterações
                                </span>
                                <span wire:loading wire:target="salvarPerfil">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Alterar Senha -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Alterar Senha</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Mantenha sua conta segura com uma senha forte
                                </p>
                            </div>
                            <button 
                                wire:click="toggleFormSenha"
                                class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 transition-colors"
                            >
                                {{ $mostrarFormSenha ? 'Cancelar' : 'Alterar Senha' }}
                            </button>
                        </div>
                    </div>

                    @if($mostrarFormSenha)
                        <form wire:submit="atualizarSenha" class="p-6 space-y-6">
                            <!-- Senha Atual -->
                            <div>
                                <label for="senha_atual" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Senha Atual *
                                </label>
                                <input 
                                    type="password" 
                                    id="senha_atual"
                                    wire:model="senha_atual"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Digite sua senha atual"
                                    required
                                >
                                @error('senha_atual')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nova Senha -->
                            <div>
                                <label for="nova_senha" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nova Senha *
                                </label>
                                <input 
                                    type="password" 
                                    id="nova_senha"
                                    wire:model="nova_senha"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Mínimo 8 caracteres"
                                    required
                                >
                                @error('nova_senha')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmar Nova Senha -->
                            <div>
                                <label for="nova_senha_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Confirmar Nova Senha *
                                </label>
                                <input 
                                    type="password" 
                                    id="nova_senha_confirmation"
                                    wire:model="nova_senha_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Digite a nova senha novamente"
                                    required
                                >
                            </div>

                            <!-- Dicas de Segurança -->
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-2">
                                    Dicas para uma senha segura:
                                </h4>
                                <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Use pelo menos 8 caracteres
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Combine letras maiúsculas e minúsculas
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Inclua números e caracteres especiais
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Evite informações pessoais óbvias
                                    </li>
                                </ul>
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end pt-4">
                                <button 
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors"
                                >
                                    <span wire:loading.remove wire:target="atualizarSenha">
                                        Atualizar Senha
                                    </span>
                                    <span wire:loading wire:target="atualizarSenha">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto text-gray-400 mb-4">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">
                                Sua senha foi atualizada pela última vez em 
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $usuario->updated_at->format('d/m/Y') }}
                                </span>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Preferências -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Preferências</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Configure suas preferências de notificação e tema
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Notificações -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Notificações por E-mail</h3>
                            
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700"
                                        checked
                                    >
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">
                                        Promoções e ofertas especiais
                                    </span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700"
                                        checked
                                    >
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">
                                        Atualizações de pedidos
                                    </span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700"
                                    >
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">
                                        Novidades da loja
                                    </span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700"
                                        checked
                                    >
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">
                                        Produtos em promoção dos seus favoritos
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Configurações da Conta -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Configurações da Conta</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Excluir minha conta</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Esta ação não pode ser desfeita
                                        </p>
                                    </div>
                                    <button 
                                        class="px-4 py-2 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900 transition-colors"
                                        onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.')"
                                    >
                                        Excluir
                                    </button>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Exportar meus dados</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Baixe uma cópia dos seus dados pessoais
                                        </p>
                                    </div>
                                    <button 
                                        class="px-4 py-2 bg-gray-800 dark:bg-gray-600 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-700 transition-colors"
                                    >
                                        Exportar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validação de telefone com máscara
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }
            
            e.target.value = value;
        });
    }

    // Auto-save com debounce
    let saveTimeout;
    
    document.addEventListener('livewire:init', () => {
        // Debounce para salvar automaticamente após 2 segundos sem digitar
        ['nome', 'email', 'telefone', 'endereco'].forEach(field => {
            Livewire.on(`field-updated-${field}`, () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    @this.salvarPerfil();
                }, 2000);
            });
        });
    });
</script>
@endpush
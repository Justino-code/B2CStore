<div class="p-3 sm:p-4 md:p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div>
        <!-- Header -->
        <div class="mb-4 sm:mb-6 md:mb-8">
            <div class="flex flex-col gap-3 sm:gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                        Meu Perfil
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1 text-xs sm:text-sm md:text-base">
                        Gerencie suas informações pessoais e preferências
                    </p>
                </div>
                
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    Último acesso: 
                    @if($usuario->ultimo_acesso)
                        <span class="block sm:inline">{{ $usuario->ultimo_acesso->format('d/m/Y H:i') }}</span>
                        <br>IP: <span class="block sm:inline" style="color: #4f4fc4;">{{ $usuario->ultimo_acesso_ip ?? N/A }}</span>
                    @else
                        <span class="block sm:inline">N/A</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Coluna Esquerda - Foto e Informações -->
            <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                <!-- Foto do Perfil -->
                <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex flex-col items-center">
                        <!-- Avatar -->
                        <div class="relative mb-3 sm:mb-4">
                            @if($avatar_url)
                                <img src="{{ image_url($avatar_url) }}" 
                                     alt="{{ $usuario->nome }}"
                                     class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-2 sm:border-4 border-white dark:border-gray-700 shadow-lg object-cover">
                            @else
                                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center border-2 sm:border-4 border-white dark:border-gray-700 shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold text-white">
                                        {{ strtoupper(substr($usuario->nome, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Ícone de upload -->
                            <label for="avatar-upload" 
                                   class="absolute bottom-1 right-1 sm:bottom-2 sm:right-2 p-1.5 sm:p-2 bg-blue-600 text-white rounded-full cursor-pointer hover:bg-blue-700 transition-colors">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </label>
                            <input type="file" 
                                   id="avatar-upload" 
                                   wire:model="avatar"
                                   accept="image/*"
                                   class="hidden"
                                   wire:loading.attr="disabled">
                        </div>

                        <!-- Upload em progresso -->
                        @if($avatar)
                            <div class="mb-3 sm:mb-4 w-full">
                                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">
                                    Upload em progresso...
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 sm:h-2">
                                    <div class="bg-blue-600 h-1.5 sm:h-2 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Botões de ação para avatar -->
                        <div class="flex flex-col xs:flex-row flex-wrap gap-2 justify-center w-full">
                            @if($avatar)
                                <button wire:click="atualizarAvatar"
                                        wire:loading.attr="disabled"
                                        class="flex-1 xs:flex-none inline-flex items-center justify-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                    <svg wire:loading.remove wire:target="atualizarAvatar" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <svg wire:loading wire:target="atualizarAvatar" class="animate-spin w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="whitespace-nowrap">Salvar Foto</span>
                                </button>
                            @endif
                            
                            @if($avatar_url)
                                <button wire:click="removerAvatar"
                                        wire:loading.attr="disabled"
                                        wire:confirm="Tem certeza que deseja remover sua foto de perfil?"
                                        class="flex-1 xs:flex-none inline-flex items-center justify-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remover
                                </button>
                            @endif
                        </div>

                        <!-- Informações básicas -->
                        <div class="mt-4 sm:mt-6 text-center">
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white break-words">{{ $usuario->nome }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm break-words">{{ $usuario->email }}</p>
                            <div class="mt-2 inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 capitalize">
                                {{ $usuario->role }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 sm:mb-4">
                        Atividade
                    </h3>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total de Pedidos</span>
                            <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">
                                {{ $usuario->pedidos->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Membro desde</span>
                            <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">
                                {{ $usuario->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        @if($usuario->telefone)
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Telefone</span>
                            <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">
                                {{ $usuario->telefone }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Formulários -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                <!-- Informações Pessoais -->
                <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-3 mb-4 sm:mb-6">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            Informações Pessoais
                        </h3>
                        <button wire:click="atualizarPerfil"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                            <svg wire:loading.remove wire:target="atualizarPerfil" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <svg wire:loading wire:target="atualizarPerfil" class="animate-spin w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Salvar Alterações
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Nome -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nome Completo
                            </label>
                            <input type="text" 
                                   wire:model="nome"
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                            @error('nome')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>
                            <input type="email" 
                                   wire:model="email"
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                            @error('email')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Telefone
                            </label>
                            <input type="text" 
                                   wire:model="telefone"
                                   placeholder="+244 XXX XXX XXX"
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                            @error('telefone')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role (somente leitura) -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Função
                            </label>
                            <div class="px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <span class="text-gray-900 dark:text-white capitalize text-sm sm:text-base">{{ $usuario->role }}</span>
                            </div>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                Sua função no sistema
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Alterar Senha -->
                <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-3 mb-4 sm:mb-6">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            Segurança
                        </h3>
                        <button wire:click="$toggle('mostrarFormSenha')"
                                class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Alterar Senha
                        </button>
                    </div>

                    @if($mostrarFormSenha)
                    <div class="space-y-3 sm:space-y-4">
                        <!-- Senha Atual -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Senha Atual
                            </label>
                            <input type="password" 
                                   wire:model="senha_atual"
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                            @error('senha_atual')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nova Senha -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nova Senha
                            </label>
                            <input type="password" 
                                   wire:model="nova_senha"
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                            @error('nova_senha')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Nova Senha -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Nova Senha
                            </label>
                            <input type="password" 
                                   wire:model="nova_senha_confirmation"
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                        </div>

                        <div class="flex flex-col xs:flex-row justify-end gap-2 sm:gap-3 pt-3 sm:pt-4">
                            <button wire:click="$set('mostrarFormSenha', false)"
                                    class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-xs sm:text-sm">
                                Cancelar
                            </button>
                            <button wire:click="atualizarSenha"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                <svg wire:loading.remove wire:target="atualizarSenha" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <svg wire:loading wire:target="atualizarSenha" class="animate-spin w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Alterar Senha
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4 sm:py-6">
                        <svg class="w-8 h-8 sm:w-12 sm:h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                            Clique no botão acima para alterar sua senha
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Endereço -->
                <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-3 mb-4 sm:mb-6">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                                Endereço
                            </h3>
                            @if($usuario->tem_endereco)
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1 break-words">
                                    {{ $usuario->endereco_formatado }}
                                </p>
                            @endif
                        </div>
                        <button wire:click="$toggle('mostrarFormEndereco')"
                                class="flex-shrink-0 inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="whitespace-nowrap">
                                {{ $usuario->tem_endereco ? 'Editar Endereço' : 'Adicionar Endereço' }}
                            </span>
                        </button>
                    </div>

                    @if($mostrarFormEndereco)
                    <div class="space-y-3 sm:space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Rua -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Rua
                                </label>
                                <input type="text" 
                                       wire:model="rua"
                                       class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                @error('rua')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Número -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Número
                                </label>
                                <input type="text" 
                                       wire:model="numero"
                                       class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                @error('numero')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bairro -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bairro
                                </label>
                                <input type="text" 
                                       wire:model="bairro"
                                       class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                @error('bairro')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Município -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Município
                                </label>
                                <input type="text" 
                                       wire:model="municipio"
                                       class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                @error('municipio')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Província -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Província
                                </label>
                                <select wire:model="provincia"
                                        class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                    <option value="">Selecione uma província</option>
                                    @foreach(['Luanda', 'Benguela', 'Huíla', 'Huambo', 'Cabinda', 'Cunene', 'Cuando Cubango', 'Cuanza Norte', 'Cuanza Sul', 'Lunda Norte', 'Lunda Sul', 'Malanje', 'Moxico', 'Namibe', 'Uíge', 'Zaire', 'Bié'] as $provincia)
                                        <option value="{{ $provincia }}">{{ $provincia }}</option>
                                    @endforeach
                                </select>
                                @error('provincia')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Complemento -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Complemento
                                </label>
                                <input type="text" 
                                       wire:model="complemento"
                                       class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                @error('complemento')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Referência -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ponto de Referência
                                </label>
                                <input type="text" 
                                       wire:model="referencia"
                                       placeholder="Ex: Próximo ao mercado X, ao lado do banco Y"
                                       class="w-full px-3 py-2 sm:px-4 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base">
                                @error('referencia')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col xs:flex-row justify-end gap-2 sm:gap-3 pt-3 sm:pt-4">
                            <button wire:click="$set('mostrarFormEndereco', false)"
                                    class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-xs sm:text-sm">
                                Cancelar
                            </button>
                            <button wire:click="atualizarEndereco"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                <svg wire:loading.remove wire:target="atualizarEndereco" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <svg wire:loading wire:target="atualizarEndereco" class="animate-spin w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Salvar Endereço
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
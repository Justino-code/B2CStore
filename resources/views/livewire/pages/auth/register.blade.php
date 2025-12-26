{{-- resources/views/livewire/auth/register-view.blade.php --}}
<div class="space-y-6 animate-fade-in-up">
    <!-- Form Register -->
    <form wire:submit.prevent="register" class="space-y-5">
        <!-- Nome -->
        <div class="space-y-2">
            <label for="nome" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Nome Completo') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input wire:model="form.nome"
                       id="nome"
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('form.nome') border-red-500 dark:border-red-400 @enderror"
                       type="text"
                       placeholder="Seu nome completo"
                       required
                       autofocus
                       autocomplete="name">
            </div>
            @error('form.nome')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Email') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input wire:model="form.email"
                       id="email"
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('form.email') border-red-500 dark:border-red-400 @enderror"
                       type="email"
                       placeholder="seu@email.com"
                       required
                       autocomplete="email">
            </div>
            @error('form.email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Senha -->
        <div class="space-y-2">
            <label for="senha" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Senha') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input wire:model="form.senha"
                       id="senha"
                       class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('form.senha') border-red-500 dark:border-red-400 @enderror"
                       type="{{ $showPassword ? 'text' : 'password' }}"
                       placeholder="••••••••"
                       required
                       autocomplete="new-password">
                <button type="button"
                        wire:click="togglePasswordVisibility('senha')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($showPassword)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        @endif
                    </svg>
                </button>
            </div>
            
            <!-- Password Strength Indicator -->
            @if($form->senha)
            @php
                $strength = $this->getPasswordStrength();
            @endphp
            <div class="mt-2 space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600 dark:text-gray-400">Força da senha:</span>
                    <span class="font-medium @if($strength['color'] === 'red') text-red-600 @elseif($strength['color'] === 'orange') text-orange-600 @elseif($strength['color'] === 'yellow') text-yellow-600 @else text-green-600 @endif">
                        {{ $strength['strength'] }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full @if($strength['color'] === 'red') bg-red-500 @elseif($strength['color'] === 'orange') bg-orange-500 @elseif($strength['color'] === 'yellow') bg-yellow-500 @else bg-green-500 @endif"
                         style="width: {{ $strength['strength'] }}%"></div>
                </div>
                @if(!empty($strength['feedback']))
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-0.5 mt-1">
                    @foreach($strength['feedback'] as $tip)
                    <li class="flex items-center">
                        <svg class="w-3 h-3 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ $tip }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endif
            
            @error('form.senha')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Senha -->
        <div class="space-y-2">
            <label for="senha_confirmation" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Confirmar Senha') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input wire:model="form.senha_confirmation"
                       id="senha_confirmation"
                       class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('form.senha_confirmation') border-red-500 dark:border-red-400 @enderror"
                       type="{{ $showConfirmPassword ? 'text' : 'password' }}"
                       placeholder="••••••••"
                       required
                       autocomplete="new-password">
                <button type="button"
                        wire:click="togglePasswordVisibility('confirm')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($showConfirmPassword)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        @endif
                    </svg>
                </button>
            </div>
            
            <!-- Password Match Indicator - CORREÇÃO AQUI -->
            @if($form->senha && $form->senha_confirmation)
            <div class="mt-1 flex items-center">
                @if($this->passwordsMatch()) {{-- ALTERADO: $this->passwordsMatch() --}}
                <svg class="w-4 h-4 text-green-600 dark:text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-xs text-green-600 dark:text-green-400">As senhas coincidem</span>
                @else
                <svg class="w-4 h-4 text-red-600 dark:text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="text-xs text-red-600 dark:text-red-400">As senhas não coincidem</span>
                @endif
            </div>
            @endif
            
            @error('form.senha_confirmation')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms Agreement -->
        <div class="flex items-start">
            <input wire:model="form.terms"
                   id="terms"
                   type="checkbox"
                   class="h-4 w-4 mt-1 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
            <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                {{ __('Eu concordo com os') }}
                <a href="{{ route('terms') }}" class="text-blue-600 dark:text-blue-400 hover:underline" wire:navigate>
                    {{ __('Termos de Serviço') }}
                </a>
                {{ __('e') }}
                <a href="{{ route('privacy') }}" class="text-blue-600 dark:text-blue-400 hover:underline" wire:navigate>
                    {{ __('Política de Privacidade') }}
                </a>
            </label>
        </div>
        @error('form.terms')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror

        <!-- Error Geral -->
        @error('general')
            <div class="p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            </div>
        @enderror

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="register"
                    @if($isLoading) disabled @endif
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 dark:from-green-500 dark:to-blue-500 dark:hover:from-green-600 dark:hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-green-400 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none">
                @if($isLoading)
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>{{ __('Criando conta...') }}</span>
                @else
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span>{{ __('Criar Conta') }}</span>
                @endif
            </button>
        </div>
    </form>

    <!-- Login Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Já tem uma conta?') }}
            <a href="{{ route('login') }}"
               class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200"
               wire:navigate>
                {{ __('Faça login') }}
            </a>
        </p>
    </div>
</div>

@script
<script>
    // Auto-focus no nome quando o componente carrega
    document.addEventListener('livewire:init', () => {
        setTimeout(() => {
            const nomeInput = document.getElementById('nome');
            if (nomeInput) {
                nomeInput.focus();
            }
        }, 300);
    });
</script>
@endscript
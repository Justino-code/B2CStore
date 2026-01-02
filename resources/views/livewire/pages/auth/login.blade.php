{{-- resources/views/livewire/auth/login-view.blade.php --}}
<div class="space-y-6 animate-fade-in-up">
    <!-- Mensagem de logout (se houver) -->
    @if($logoutMessage)
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-green-800 dark:text-green-300">{{ $logoutMessage }}</p>
        </div>
    </div>
    @endif

    <!-- Social Login (opcional) -->
    @if(config('services.github.client_id') || config('services.google.client_id'))
    <div>
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Ou continue com
                </span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            @if(config('services.github.client_id'))
            <a href="{{ route('auth.github') }}"
               class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-2">GitHub</span>
            </a>
            @endif

            @if(config('services.google.client_id'))
            <a href="{{ route('auth.google') }}"
               class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                </svg>
                <span class="ml-2">Google</span>
            </a>
            @endif
        </div>
    </div>
    @endif

    <!-- Form Login -->
    <form wire:submit.prevent="login" class="space-y-5">
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
                       autofocus
                       autocomplete="email"
                       x-on:input="$wire.clearFieldError('email')">
            </div>
            @error('form.email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Senha') }}
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200"
                       href="{{ route('password.request') }}"
                       wire:navigate>
                        {{ __('Esqueceu a senha?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input wire:model="form.password"
                       id="password"
                       class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors duration-200 @error('form.password') border-red-500 dark:border-red-400 @enderror"
                       type="{{ $showPassword ? 'text' : 'password' }}"
                       placeholder="••••••••"
                       required
                       autocomplete="current-password"
                       x-on:input="$wire.clearFieldError('password')">
                <button type="button"
                        wire:click="togglePasswordVisibility"
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
            @error('form.password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember"
                   id="remember"
                   type="checkbox"
                   class="h-4 w-4 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200">
            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                {{ __('Lembrar-me') }}
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="login"
                    @if($isLoading) disabled @endif
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 dark:from-blue-500 dark:to-purple-500 dark:hover:from-blue-600 dark:hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none">
                @if($isLoading)
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>{{ __('Entrando...') }}</span>
                @else
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>{{ __('Entrar') }}</span>
                @endif
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Não tem uma conta?') }}
            <a href="{{ route('register') }}"
               class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200">
                {{ __('Cadastre-se') }}
            </a>
        </p>
    </div>

    <!-- Terms & Privacy Notice -->
    <div class="text-center text-xs text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-200 dark:border-gray-700">
        <p>
            Ao continuar, você concorda com nossos
            <a href="{{ route('terms') }}" class="hover:underline" wire:navigate>Termos de Serviço</a>
            e
            <a href="{{ route('privacy') }}" class="hover:underline" wire:navigate>Política de Privacidade</a>.
        </p>
    </div>
</div>

@script
<script>
    // Auto-focus no email quando o componente carrega
    document.addEventListener('livewire:init', () => {
        setTimeout(() => {
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.focus();
            }
        }, 300);
    });

    // Limpar erros quando o usuário começa a digitar (alternativa)
    document.addEventListener('livewire:init', () => {
        Livewire.on('updated', (name, value) => {
            if (name && name.startsWith('form.')) {
                const field = name.replace('form.', '');
                const input = document.querySelector(`[wire\\:model="form.${field}"]`);
                const errorElement = document.querySelector(`[wire\\:model="form.${field}"] ~ p.text-red-600`);
                
                if (input && input.classList.contains('border-red-500')) {
                    input.classList.remove('border-red-500', 'dark:border-red-400');
                }
                
                if (errorElement && value.trim() !== '') {
                    setTimeout(() => {
                        errorElement.remove();
                    }, 100);
                }
            }
        });
    });
</script>
@endscript
{{-- resources/views/livewire/auth/logout-view.blade.php --}}
<div class="space-y-6 animate-fade-in-up">
    <!-- User Info -->
    <div class="text-center">
        <div class="mx-auto h-20 w-20 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center shadow-lg mb-4">
            <span class="text-white font-bold text-2xl">
                {{ substr($getUser()->name, 0, 1) }}
            </span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ $getUser()->name }}
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $getUser()->email }}
        </p>
        <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Logado
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    Olá, <strong>{{ $getUser()->name }}</strong>! Você está atualmente logado no sistema.
                </p>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                    Último acesso: {{ now()->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-3">
        <a href="{{ route('dashboard') }}"
           class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0"
           wire:navigate>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Ir para Dashboard
        </a>

        <a href="{{ route('profile') }}"
           class="w-full flex items-center justify-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
           wire:navigate>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Meu Perfil
        </a>

        <button type="button"
                wire:click="logout"
                wire:loading.attr="disabled"
                wire:target="logout"
                class="w-full flex items-center justify-center py-3 px-4 border border-red-300 dark:border-red-700 rounded-lg shadow-sm text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span wire:loading.remove wire:target="logout">{{ __('Sair da Conta') }}</span>
            <span wire:loading wire:target="logout">{{ __('Saindo...') }}</span>
        </button>
    </div>

    <!-- Session Info -->
    <div class="text-center text-xs text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-200 dark:border-gray-700">
        <p>
            Para sua segurança, clique em "Sair da Conta" ao terminar sua sessão.
        </p>
        <p class="mt-1">
            Sua sessão expira em: <strong>30 minutos</strong>
        </p>
    </div>
</div>

@script
<script>
    // Timer de sessão (opcional)
    let sessionTimeout = 30 * 60; // 30 minutos em segundos
    
    function updateSessionTimer() {
        if (sessionTimeout > 0) {
            sessionTimeout--;
            const minutes = Math.floor(sessionTimeout / 60);
            const seconds = sessionTimeout % 60;
            
            const timerElement = document.querySelector('strong');
            if (timerElement) {
                timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
        } else {
            // Auto logout quando o tempo expirar
            Livewire.dispatch('logout');
        }
    }
    
    // Iniciar timer (opcional)
    // setInterval(updateSessionTimer, 1000);
</script>
@endscript
{{-- resources/views/livewire/auth/login-view.blade.php --}}
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Login</h2>
        <p class="text-gray-600">Entre com suas credenciais</p>
    </div>

    <form wire:submit.prevent="login" class="space-y-4">
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input 
                wire:model="form.email"
                type="email" 
                id="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required
                autofocus
            >
            @error('form.email') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input 
                wire:model="form.password"
                type="password" 
                id="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required
            >
            @error('form.password') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                wire:model="form.remember"
                type="checkbox" 
                id="remember"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
            <label for="remember" class="ml-2 text-sm text-gray-700">Manter-me conectado</label>
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <span wire:loading.remove wire:target="login">Entrar</span>
                <span wire:loading wire:target="login">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>

        <!-- Links adicionais -->
        <div class="text-center text-sm text-gray-600 mt-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-500">
                    Esqueceu sua senha?
                </a>
            @endif
        </div>
    </form>
</div>
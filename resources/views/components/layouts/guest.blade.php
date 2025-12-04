{{-- components/layouts/guest.blade.php --}}
@props(['title' => 'Autenticação', 'header' => null, 'description' => null, 'navigation' => null])

<x-layouts.app :title="$title">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">

        <!-- Logo -->
        <div>
            <a href="{{ route('home') }}">
                <x-application-logo class="w-20 h-20 fill-current text-blue-600 dark:text-blue-400 transition-colors duration-300" />
            </a>
        </div>

        <!-- Card de Autenticação -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-2xl rounded-lg sm:rounded-2xl transition-all duration-300 hover:shadow-3xl">

            <!-- Dark Mode Toggle (dentro do card) -->
            <div class="flex justify-end mb-4">
                <x-theme-toggle-button />
            </div>

            <!-- Header -->
            @if($header)
                <div class="mb-6 text-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors duration-300">
                        {{ $header }}
                    </h1>
                    @if($description)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">
                            {{ $description }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Main Slot -->
            <div class="space-y-6">
                {{ $slot }}
            </div>

            <!-- Navigation Links -->
            @if($navigation)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    {{ $navigation }}
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-700 dark:text-gray-300 transition-colors duration-300">
            <p class="text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'B2CStore') }}. Todos os direitos reservados.
            </p>
        </div>

    </div>

    <!-- Modal Container (para modais públicos) -->
    <div id="guest-modal-container"></div>

</x-layouts.app>

@push('styles')
<style>
    /* Animação suave para o card */
    .guest-card-enter {
        opacity: 0;
        transform: translateY(20px);
    }

    .guest-card-enter-active {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    /* Efeito de hover suave */
    .guest-card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .guest-card-hover:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Adicionar classe de animação ao card
        const card = document.querySelector('[class*="shadow-2xl"]');
        if (card) {
            card.classList.add('guest-card-hover');
        }
    });
</script>
@endpush

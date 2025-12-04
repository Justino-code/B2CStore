<x-layouts.app :title="$title ?? 'Public'">

    <div class="min-h-screen flex flex-col bg-white dark:bg-gray-900">

        <!-- Public Navbar -->
        <x-navbar.public />

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Hero Section (opcional, pode ser sobrescrito) -->
            @isset($hero)
                {{ $hero }}
            @endisset

            <!-- Page Content -->
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-footer.public />
    </div>

    <!-- Modal Container (para modais públicos) -->
    <div id="public-modal-container"></div>

</x-layouts.app>

@push('styles')
<style>
    /* Estilos específicos para páginas públicas */
    .public-container {
        @apply max-w-7xl mx-auto px-4 sm:px-6 lg:px-8;
    }

    .public-section {
        @apply py-12 md:py-16 lg:py-20;
    }

    .public-title {
        @apply text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4;
    }

    .public-subtitle {
        @apply text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8;
    }

    /* Hero section styles */
    .hero-gradient {
        @apply bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-800 dark:to-purple-800;
    }
</style>
@endpush

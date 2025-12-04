<x-layouts.app :title="$title ?? 'Cliente'">

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">

        <!-- Cliente Navbar -->
        <x-navbar.cliente />

        <!-- Page Header (opcional, para páginas específicas) -->
        @isset($pageHeader)
            <div class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {{ $pageHeader }}
                </div>
            </div>
        @endisset

        <!-- Main Content -->
        <main class="cliente-container">
            <!-- Breadcrumbs (opcional) -->
            @isset($breadcrumbs)
                <div class="py-4">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            {{ $breadcrumbs }}
                        </ol>
                    </nav>
                </div>
            @endisset

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar -->
                <div class="lg:w-64">
                    <x-sidebar.cliente />
                </div>

                <!-- Conteúdo da Página -->
                <div class="flex-1">
                    <div class="cliente-card">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <x-footer.public />
    </div>

    <!-- Modal Container (para modais do cliente) -->
    <div id="cliente-modal-container"></div>

</x-layouts.app>

@push('styles')
<style>
    /* Estilos específicos para área do cliente */
    .cliente-container {
        @apply max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6;
    }

    .cliente-card {
        @apply bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300;
    }

    .cliente-section-title {
        @apply text-lg font-semibold text-gray-900 dark:text-white mb-4 transition-colors duration-300;
    }
</style>
@endpush

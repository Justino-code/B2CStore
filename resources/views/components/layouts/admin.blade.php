{{-- layouts/admin.blade.php --}}
<x-layouts.app :title="$title ?? 'Admin Dashboard'">

    <!-- Navbar Admin -->
    <x-navbar.admin />

    <!-- Page Header -->
    @isset($pageHeader)
        <div class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $pageHeader }}
            </div>
        </div>
    @endisset

    <!-- Container Principal com Altura Fixa -->
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50 dark:bg-gray-900 pt-6 pb-24"> <!-- pb-24 para espaço do footer -->
        <div class="admin-container">
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
                <!-- Sidebar Admin -->
                <div class="lg:w-64">
                    <x-sidebar.admin />
                </div>

                <!-- Conteúdo Principal com Scroll -->
                <div class="flex-1">
                    <!-- Conteúdo com Scroll -->
                    <div class="admin-card max-h-[calc(100vh-14rem)] overflow-y-auto">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer FIXO no final -->
    <footer class="fixed bottom-0 left-0 right-0">
        <x-footer.admin />
    </footer>

    <!-- Modal Container -->
    <div id="admin-modal-container"></div>

</x-layouts.app>

@push('styles')
<style>
    /* Estilos específicos para admin */
    .admin-container {
        @apply max-w-7xl mx-auto px-4 sm:px-6 lg:px-8;
    }

    .admin-card {
        @apply bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300;
    }
</style>
@endpush
<x-layouts.app :title="$title ?? 'Cliente'">

    <!-- Navbar -->
    <x-navbar.cliente />

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
        <div class="cliente-container">
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

                <!-- Conteúdo com Scroll -->
                <div class="flex-1">
                    <div class="cliente-card max-h-[calc(100vh-12rem)] overflow-y-auto">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer FIXO no final -->
    <footer class="fixed bottom-0 left-0 right-0">
        <x-footer.cliente />
    </footer>

    <!-- Modal -->
    <div id="cliente-modal-container"></div>

</x-layouts.app>
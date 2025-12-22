<x-layouts.app :title="$title ?? 'Dashboard'">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Admin Sidebar (Desktop) -->
        <aside class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-200 lg:bg-white lg:dark:bg-gray-800 lg:dark:border-gray-700 transition-colors duration-300">
            <!-- Logo -->
            <div class="flex h-16 shrink-0 items-center px-6 border-b border-gray-200 dark:border-gray-700">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600 dark:text-blue-400">
                    B2CStore Admin
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 space-y-1 px-4 py-4">
                <x-sidebar.admin />
            </nav>

            <!-- User Menu -->
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8 rounded-full"
                             src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1D4ED8&color=fff' }}"
                             alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ ucfirst(Auth::user()->role) }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <div x-data="{ mobileMenuOpen: false }" class="lg:hidden">
            <!-- Mobile Menu Overlay -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75"
                 @click="mobileMenuOpen = false">
            </div>

            <!-- Mobile Menu Panel -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 transition-colors duration-300">
                <x-sidebar.admin />
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Admin Navbar -->
            <x-navbar.admin />

            <!-- Page Content -->
            <main class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <!-- Page Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $pageTitle ?? 'Dashboard' }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $pageDescription ?? 'Gerencie sua loja online' }}
                        </p>
                    </div>

                    <!-- Breadcrumbs -->
                    @isset($breadcrumbs)
                        <nav class="mb-6" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2 text-sm">
                                {{ $breadcrumbs }}
                            </ol>
                        </nav>
                    @endisset

                    <!-- Page Content -->
                    <div class="admin-card">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Container (para modais do admin) -->
    <div id="admin-modal-container"></div>
</x-layouts.app>

@push('styles')
<style>
    /* Estilos específicos para admin */
    .admin-card {
        @apply bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-300;
    }

    .sidebar-link {
        @apply flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors duration-200;
    }

    .sidebar-link.active {
        @apply bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300;
    }

    .sidebar-link:not(.active) {
        @apply text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700;
    }

    .sidebar-icon {
        @apply mr-3 h-5 w-5 flex-shrink-0;
    }
</style>
@endpush

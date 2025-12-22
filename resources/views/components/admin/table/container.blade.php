{{-- components/admin/table/container.blade.php --}}
@props([
    'title' => null,
    'description' => null,
    'actions' => null,
    'filters' => null,
    'search' => true,
    'searchPlaceholder' => 'Buscar...',
])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    @if($title || $filters || $actions)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                @if($title)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                        @if($description)
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
                        @endif
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3">
                    @if($search)
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search"
                                   placeholder="{{ $searchPlaceholder }}"
                                   class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm w-full sm:w-64 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    @endif

                    @if($filters)
                        {{ $filters }}
                    @endif

                    @if($actions)
                        <div class="flex items-center space-x-2">
                            {{ $actions }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </table>
    </div>
</div>

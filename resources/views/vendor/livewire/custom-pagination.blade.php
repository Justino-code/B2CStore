{{-- resources/views/vendor/livewire/custom-pagination.blade.php --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="relative">
        {{-- Loading overlay --}}
        <div wire:loading wire:target="gotoPage,previousPage,nextPage"
             class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center z-10">
            <div class="flex flex-col items-center gap-2">
                <div class="w-8 h-8 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Carregando...</span>
            </div>
        </div>
        
        <div class="flex justify-between items-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-600 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Anterior
                </span>
            @else
                <button wire:click="previousPage" 
                        wire:loading.attr="disabled"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Anterior
                </button>
            @endif

            {{-- Pagination Elements --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
                <div>
                    <span class="relative z-0 inline-flex rounded-md shadow-sm">
                        {{-- Previous Dots --}}
                        @if($paginator->currentPage() > 3)
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                ...
                            </span>
                        @endif

                        {{-- Pagination Numbers --}}
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $element }}
                                </span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg cursor-default">
                                                {{ $page }}
                                            </span>
                                        </span>
                                    @elseif ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                                        <button wire:click="gotoPage({{ $page }})" 
                                                wire:loading.attr="disabled"
                                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Dots --}}
                        @if($paginator->currentPage() < $paginator->lastPage() - 2)
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                ...
                            </span>
                        @endif
                    </span>
                </div>
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" 
                        wire:loading.attr="disabled"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Próxima
                    <i class="fas fa-chevron-right ml-2"></i>
                </button>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-600 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg cursor-not-allowed">
                    Próxima
                    <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
        
        {{-- Info da página --}}
        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
            Página <span class="font-semibold">{{ $paginator->currentPage() }}</span> de 
            <span class="font-semibold">{{ $paginator->lastPage() }}</span>
        </div>
    </nav>
@endif
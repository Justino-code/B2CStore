{{-- Breadcrumb --}}
<nav class="mb-8" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm">
        <li>
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
            <span class="text-gray-900 dark:text-white font-medium">Produtos</span>
        </li>
        @if($categoriaId && $categorias->find($categoriaId))
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                <span class="text-gray-500 dark:text-gray-400">
                    {{ $categorias->find($categoriaId)->nome }}
                </span>
            </li>
        @endif
    </ol>
</nav>
{{-- components/admin/cards/stat-card.blade.php --}}
@props([
    'title',
    'value',
    'change' => null,
    'icon' => null,
    'color' => 'blue',
    'trend' => 'up' // 'up', 'down', or 'neutral'
])

@php
    $colorClasses = [
        'blue' => [
            'bg' => 'bg-blue-500',
            'dark' => 'dark:bg-blue-600',
            'text' => 'text-blue-600 dark:text-blue-400',
            'border' => 'border-blue-100 dark:border-blue-900'
        ],
        'green' => [
            'bg' => 'bg-green-500',
            'dark' => 'dark:bg-green-600',
            'text' => 'text-green-600 dark:text-green-400',
            'border' => 'border-green-100 dark:border-green-900'
        ],
        'purple' => [
            'bg' => 'bg-purple-500',
            'dark' => 'dark:bg-purple-600',
            'text' => 'text-purple-600 dark:text-purple-400',
            'border' => 'border-purple-100 dark:border-purple-900'
        ],
        'yellow' => [
            'bg' => 'bg-yellow-500',
            'dark' => 'dark:bg-yellow-600',
            'text' => 'text-yellow-600 dark:text-yellow-400',
            'border' => 'border-yellow-100 dark:border-yellow-900'
        ],
        'red' => [
            'bg' => 'bg-red-500',
            'dark' => 'dark:bg-red-600',
            'text' => 'text-red-600 dark:text-red-400',
            'border' => 'border-red-100 dark:border-red-900'
        ],
    ];

    $iconMap = [
        'dollar' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-6.5a6 6 0 01-6 6',
        'shopping-cart' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
        'chart-bar' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'tag' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
        'box' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'credit-card' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
        'trending-up' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
        'trending-down' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6'
    ];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border {{ $colorClasses[$color]['border'] }} p-6 transition-all duration-300 hover:shadow-md">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>

            @if($change)
                <div class="mt-2 flex items-center">
                    @if($trend === 'up')
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">
                            {{ $change }}
                        </span>
                    @elseif($trend === 'down')
                        <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">
                            {{ $change }}
                        </span>
                    @else
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ $change }}
                        </span>
                    @endif
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">vs último mês</span>
                </div>
            @endif
        </div>

        @if($icon)
            <div class="p-3 rounded-lg {{ $colorClasses[$color]['bg'] }} {{ $colorClasses[$color]['dark'] }}">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconMap[$icon] ?? $iconMap['chart-bar'] }}"/>
                </svg>
            </div>
        @endif
    </div>
</div>

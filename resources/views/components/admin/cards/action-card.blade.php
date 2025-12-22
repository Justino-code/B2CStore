{{-- components/admin/cards/action-card.blade.php --}}
@props([
    'title',
    'description' => null,
    'icon',
    'action',
    'actionText' => 'Acessar',
    'color' => 'blue'
])

@php
    $colorClasses = [
        'blue' => [
            'bg' => 'bg-blue-600 hover:bg-blue-700',
            'dark' => 'dark:bg-blue-500 dark:hover:bg-blue-600',
            'text' => 'text-blue-600 dark:text-blue-400'
        ],
        'green' => [
            'bg' => 'bg-green-600 hover:bg-green-700',
            'dark' => 'dark:bg-green-500 dark:hover:bg-green-600',
            'text' => 'text-green-600 dark:text-green-400'
        ],
        'purple' => [
            'bg' => 'bg-purple-600 hover:bg-purple-700',
            'dark' => 'dark:bg-purple-500 dark:hover:purple-600',
            'text' => 'text-purple-600 dark:text-purple-400'
        ],
    ];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md group">
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
            @if($description)
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
            @endif
        </div>

        @if($icon)
            <div class="p-2 rounded-lg {{ $colorClasses[$color]['text'] }} bg-opacity-10 group-hover:scale-110 transition-transform duration-200">
                {!! $icon !!}
            </div>
        @endif
    </div>

    <a href="{{ $action }}"
       class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white {{ $colorClasses[$color]['bg'] }} {{ $colorClasses[$color]['dark'] }} rounded-lg transition-colors duration-200">
        {{ $actionText }}
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>

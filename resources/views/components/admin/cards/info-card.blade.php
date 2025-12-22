{{-- components/admin/cards/info-card.blade.php --}}
@props([
    'title',
    'description' => null,
    'action' => null,
    'actionText' => 'Ver mais',
    'icon' => null,
    'variant' => 'default' // 'default', 'warning', 'info', 'success', 'danger'
])

@php
    $variantClasses = [
        'default' => [
            'bg' => 'bg-white dark:bg-gray-800',
            'border' => 'border-gray-200 dark:border-gray-700',
            'text' => 'text-gray-900 dark:text-white',
            'icon' => 'text-blue-600 dark:text-blue-400'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
            'border' => 'border-yellow-200 dark:border-yellow-800',
            'text' => 'text-yellow-800 dark:text-yellow-200',
            'icon' => 'text-yellow-600 dark:text-yellow-400'
        ],
        'info' => [
            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
            'border' => 'border-blue-200 dark:border-blue-800',
            'text' => 'text-blue-800 dark:text-blue-200',
            'icon' => 'text-blue-600 dark:text-blue-400'
        ],
        'success' => [
            'bg' => 'bg-green-50 dark:bg-green-900/20',
            'border' => 'border-green-200 dark:border-green-800',
            'text' => 'text-green-800 dark:text-green-200',
            'icon' => 'text-green-600 dark:text-green-400'
        ],
        'danger' => [
            'bg' => 'bg-red-50 dark:bg-red-900/20',
            'border' => 'border-red-200 dark:border-red-800',
            'text' => 'text-red-800 dark:text-red-200',
            'icon' => 'text-red-600 dark:text-red-400'
        ],
    ];

    $variant = $variantClasses[$variant] ?? $variantClasses['default'];
@endphp

<div class="{{ $variant['bg'] }} border {{ $variant['border'] }} rounded-xl p-6 transition-colors duration-300">
    <div class="flex items-start">
        @if($icon)
            <div class="mr-4">
                <div class="p-2 rounded-lg {{ $variant['icon'] }}">
                    {!! $icon !!}
                </div>
            </div>
        @endif

        <div class="flex-1">
            <h3 class="text-lg font-semibold {{ $variant['text'] }} mb-2">{{ $title }}</h3>

            @if($description)
                <p class="text-sm {{ str_replace('800', '600', $variant['text']) }} mb-4">
                    {{ $description }}
                </p>
            @endif

            @if($action)
                <a href="{{ $action }}" class="inline-flex items-center text-sm font-medium {{ $variant['icon'] }} hover:underline">
                    {{ $actionText }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>

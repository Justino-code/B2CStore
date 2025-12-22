{{-- components/admin/buttons/secondary.blade.php --}}
@props([
    'type' => 'button',
    'size' => 'md',
    'fullWidth' => false,
    'disabled' => false,
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $widthClass = $fullWidth ? 'w-full' : '';
    $disabledClass = $disabled ? 'opacity-50 cursor-not-allowed' : '';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center {$sizeClasses[$size]} {$widthClass} {$disabledClass} font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800"]) }}
    {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>

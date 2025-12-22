{{-- components/admin/buttons/danger.blade.php --}}
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
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center {$sizeClasses[$size]} {$widthClass} {$disabledClass} font-medium text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 dark:from-red-500 dark:to-pink-500 dark:hover:from-red-600 dark:hover:to-pink-600 rounded-lg shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800"]) }}
    {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>

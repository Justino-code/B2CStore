{{-- components/admin/buttons/primary.blade.php --}}
@props([
    'type' => 'button',
    'size' => 'md', // 'sm', 'md', 'lg'
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
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center {$sizeClasses[$size]} {$widthClass} {$disabledClass} font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 dark:from-blue-500 dark:to-purple-500 dark:hover:from-blue-600 dark:hover:to-purple-600 rounded-lg shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800"]) }}
    {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>

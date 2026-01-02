@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'border-blue-500 text-gray-900 dark:text-white'
            : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-300';
@endphp

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-1 pt-1 border-b-2 text-sm lg:text-base font-medium transition-colors duration-200 ' . $classes]) }}>
    {{ $slot }}
</a>
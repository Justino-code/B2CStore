@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300 border-blue-500'
            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 border-transparent';
@endphp

<a {{ $attributes->merge(['class' => 'flex items-center px-3 py-2 text-base font-medium rounded-md border-l-4 transition-colors duration-200 ' . $classes]) }}>
    {{ $slot }}
</a>
@props(['title', 'value', 'icon', 'color' => 'blue', 'change' => null])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-400',
        'green' => 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400',
        'red' => 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-400',
        'yellow' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400',
        'purple' => 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-400',
        'indigo' => 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400',
    ];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-lg {{ $colors[$color] }}">
            {{ $icon }}
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $value }}</p>
            @if($change)
                <div class="flex items-center mt-1">
                    @if(str_starts_with($change, '+'))
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-600 dark:text-green-400 text-sm font-medium ml-1">{{ $change }}</span>
                    @else
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-red-600 dark:text-red-400 text-sm font-medium ml-1">{{ $change }}</span>
                    @endif
                    <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">vs período anterior</span>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- components/admin/badges/status.blade.php --}}
@props([
    'status' => 'active', // 'active', 'inactive', 'pending', 'approved', 'rejected', 'completed', 'cancelled'
    'size' => 'md' // 'sm', 'md'
])

@php
    $statusConfig = [
        'active' => [
            'text' => 'Ativo',
            'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        'inactive' => [
            'text' => 'Inativo',
            'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
            'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        'pending' => [
            'text' => 'Pendente',
            'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        'approved' => [
            'text' => 'Aprovado',
            'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
        ],
        'rejected' => [
            'text' => 'Rejeitado',
            'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        'completed' => [
            'text' => 'Concluído',
            'class' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
        ],
        'cancelled' => [
            'text' => 'Cancelado',
            'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
            'icon' => 'M6 18L18 6M6 6l12 12'
        ],
    ];

    $config = $statusConfig[$status] ?? $statusConfig['inactive'];
    $sizeClass = $size === 'sm' ? 'px-2 py-0.5 text-xs' : 'px-3 py-1 text-sm';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center {$sizeClass} rounded-full font-medium {$config['class']}"]) }}>
    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
    </svg>
    {{ $config['text'] }}
</span>

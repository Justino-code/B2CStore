{{-- components/admin/table/header.blade.php --}}
@props(['columns' => []])

<thead class="bg-gray-50 dark:bg-gray-900">
    <tr>
        @foreach($columns as $column)
            <th {{ $column->attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider']) }}>
                {{ $column }}
            </th>
        @endforeach
    </tr>
</thead>

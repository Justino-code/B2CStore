<!-- Abas -->
<div class="mb-6 overflow-x-auto">
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="flex space-x-1">
            @php
                $abas = [
                    'vendas' => [
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'label' => 'Vendas'
                    ],
                    'produtos' => [
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'label' => 'Produtos'
                    ],
                    'clientes' => [
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75l-4.5-2.48m0 0l-4.5 2.48m4.5-2.48v7.5',
                        'label' => 'Clientes'
                    ],
                    'categorias' => [
                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                        'label' => 'Categorias'
                    ],
                    'cupons' => [
                        'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                        'label' => 'Cupons'
                    ]
                ];
            @endphp
            
            @foreach($abas as $aba => $config)
                <button wire:click="selecionarAba('{{ $aba }}')"
                        class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors duration-200 {{ $abaAtiva === $aba 
                            ? 'border-blue-500 text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' 
                            : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                        </svg>
                        <span>{{ $config['label'] }}</span>
                    </div>
                </button>
            @endforeach
        </nav>
    </div>
</div>
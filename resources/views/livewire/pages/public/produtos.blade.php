{{-- resources/views/livewire/pages/public/produtos.blade.php --}}
<div>
    <!-- Conteúdo Principal -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="container mx-auto px-4">
            
            {{-- Breadcrumb --}}
            @include('livewire.pages.public.produtos.partials.breadcrumb')
            
            {{-- Header da página --}}
            @include('livewire.pages.public.produtos.partials.header')
            
            {{-- Estrutura responsiva --}}
            <div class="flex flex-col lg:flex-row lg:items-start gap-8">
                
                {{-- Sidebar de Filtros (Desktop) --}}
                <div class="hidden lg:block lg:w-1/4 lg:sticky lg:top-24">
                    <div class="h-full">
                        @include('livewire.pages.public.produtos.partials.filters-sidebar')
                    </div>
                </div>
                
                {{-- Conteúdo Principal --}}
                <div class="w-full lg:w-3/4">
                    <main class="w-full">
                        
                        {{-- Barra de controle --}}
                        @include('livewire.pages.public.produtos.partials.products-toolbar')
                        
                        {{-- Grid/Lista de produtos --}}
                        @if($produtos->count() > 0)
                            @if($viewMode === 'grid')
                                @include('livewire.pages.public.produtos.partials.products-grid')
                            @else
                                @include('livewire.pages.public.produtos.partials.products-list')
                            @endif
                            
                            {{-- Paginação --}}
                            <div class="mt-8">
                                {{ $produtos->links('vendor.livewire.tailwind') }}
                            </div>
                        @else
                            {{-- Nenhum produto encontrado --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                                <i class="fas fa-search text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    Nenhum produto encontrado
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">
                                    Tente ajustar seus filtros ou buscar por outro termo.
                                </p>
                                <button wire:click="limparFiltros"
                                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                    Limpar filtros
                                </button>
                            </div>
                        @endif
                    </main>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal Filtros Mobile --}}
    <div class="lg:hidden">
        @include('livewire.pages.public.produtos.partials.filters-mobile-modal')
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('priceFilter', () => ({
        min: @entangle('precoMin'),
        max: @entangle('precoMax'),
        precoMaximoDisponivel: {{ $precoMaximoDisponivel ?? 10000 }},
        
        init() {
            // Ajustar valores iniciais
            if (this.min > this.precoMaximoDisponivel) this.min = 0;
            if (this.max > this.precoMaximoDisponivel) this.max = this.precoMaximoDisponivel;
            
            // Observar mudanças no mínimo
            this.$watch('min', (value) => {
                value = parseInt(value);
                if (value > this.max) this.max = value;
                if (value > this.precoMaximoDisponivel) value = this.precoMaximoDisponivel;
                this.$wire.set('precoMin', value);
            });
            
            // Observar mudanças no máximo
            this.$watch('max', (value) => {
                value = parseInt(value);
                if (value < this.min) this.min = value;
                if (value > this.precoMaximoDisponivel) value = this.precoMaximoDisponivel;
                this.$wire.set('precoMax', value);
            });
        }
    }));
});
</script>
@endpush

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .dark .custom-scrollbar::-webkit-scrollbar-track {
        background: #1f2937;
    }
    
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4b5563;
    }
    
    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
    
    /* Correção para sidebar cortado */
    .container {
        overflow: visible !important;
    }
    
    .min-h-screen {
        overflow: visible !important;
    }
    
    .bg-gray-50 {
        overflow: visible !important;
    }
    
    /* Garantir que o sidebar não tenha altura limitada */
    .lg\:w-1\/4 {
        height: auto !important;
        min-height: auto !important;
        max-height: none !important;
    }
    
    /* Remover qualquer overflow do sidebar */
    .lg\:sticky {
        overflow: visible !important;
    }
</style>
@endpush
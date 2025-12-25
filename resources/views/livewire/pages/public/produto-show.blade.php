{{-- resources/views/livewire/pages/public/produto-show.blade.php --}}
<div x-data="{ activeTab: 'description' }">
    {{-- Breadcrumb --}}
    <nav class="py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <a href="{{ route('categoria', $produto->categoria->slug) }}" 
                       class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        {{ $produto->categoria->nome }}
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-gray-900 dark:text-white font-medium truncate max-w-xs">
                        {{ $produto->nome }}
                    </span>
                </li>
            </ol>
        </div>
    </nav>

    <div class="py-8 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            {{-- Product Main Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                {{-- Product Images --}}
                @include('livewire.pages.public.partials.produto-images')
                
                {{-- Product Info --}}
                @include('livewire.pages.public.partials.produto-info')
            </div>

            {{-- Tabs Section --}}
            <div class="mb-16">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-8">
                        <button 
                            @click="activeTab = 'description'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'description' }"
                            class="py-4 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                        >
                            <i class="fas fa-file-alt mr-2"></i>Descrição
                        </button>
                        <button 
                            @click="activeTab = 'specifications'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'specifications' }"
                            class="py-4 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                        >
                            <i class="fas fa-list mr-2"></i>Especificações
                        </button>
                        <button 
                            @click="activeTab = 'reviews'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'reviews' }"
                            class="py-4 px-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                        >
                            <i class="fas fa-star mr-2"></i>Avaliações ({{ $totalReviews }})
                        </button>
                    </nav>
                </div>

                {{-- Description Tab --}}
                <div x-show="activeTab === 'description'" class="py-8">
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $produto->descricao !!}
                    </div>
                </div>

                {{-- Specifications Tab --}}
                <div x-show="activeTab === 'specifications'" class="py-8" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($produto->especificacoes)
                            @foreach($produto->especificacoes as $key => $value)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $key }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $value }}</dd>
                                </div>
                            @endforeach
                        @endif
                        
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SKU</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $produto->sku }}</dd>
                        </div>
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Peso</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $produto->peso ?? 'N/A' }} kg</dd>
                        </div>
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dimensões</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $produto->dimensoes ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Categoria</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $produto->categoria->nome }}</dd>
                        </div>
                        @if($produto->marca)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Marca</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $produto->marca->nome }}</dd>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Reviews Tab --}}
                <div x-show="activeTab === 'reviews'" class="py-8" style="display: none;" id="reviews">
                    @include('livewire.pages.public.partials.produto-reviews')
                </div>
            </div>

            {{-- Related Products --}}
            @if($produtosRelacionados->count() > 0)
                @include('livewire.pages.public.partials.produtos-relacionados')
            @endif
        </div>
    </div>

    {{-- Review Modal --}}
    @include('livewire.pages.public.partials.review-modal')
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('productPage', () => ({
        activeTab: 'description',
        init() {
            // Verifica se há hash na URL para abrir tab específica
            if (window.location.hash === '#reviews') {
                this.activeTab = 'reviews';
                setTimeout(() => {
                    document.getElementById('reviews')?.scrollIntoView({ behavior: 'smooth' });
                }, 100);
            }
        }
    }));
});

// Image Gallery Functions
function navigateImage(direction) {
    const images = @json($produto->imagens->pluck('url_imagem'));
    const currentImage = document.getElementById('mainProductImage')?.src;
    if (!currentImage) return;
    
    const currentIndex = images.findIndex(img => currentImage.includes(img));
    if (currentIndex === -1) return;
    
    let newIndex = currentIndex + direction;
    if (newIndex < 0) newIndex = images.length - 1;
    if (newIndex >= images.length) newIndex = 0;
    
    // Trigger Livewire event
    if (window.Livewire) {
        window.Livewire.dispatch('selecionarImagem', { urlImagem: images[newIndex] });
    }
}
</script>
@endpush
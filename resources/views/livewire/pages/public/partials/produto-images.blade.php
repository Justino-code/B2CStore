{{-- resources/views/livewire/pages/public/partials/produto-images.blade.php --}}
<div x-data="{ 
    isFavorito: {{ $isFavorite ? 'true' : 'false' }},
    isLoading: false
}"
@favorito-atualizado.window="
    if ($event.detail.produtoId === {{ $produto->id_produto }}) {
        isFavorito = $event.detail.acao === 'adicionado';
        isLoading = false;
    }
">
    {{-- Desktop Image Gallery --}}
    <div class="hidden lg:block">
        {{-- Main Image --}}
        <div class="relative bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden mb-6 shadow-lg">
            <div>
                @if($imagemSelecionada ?? $produto->imagens->first()?->url_imagem)
                    <img 
                        src="{{ image_url($imagemSelecionada ?? $produto->imagens->first()->url_imagem) }}" 
                        alt="{{ $produto->nome }}"
                        class="w-full h-full object-contain transition-transform duration-300 hover:scale-105 cursor-zoom-in"
                        id="mainProductImage"
                        loading="eager"
                        onclick="window.open(this.src, '_blank')"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-image text-gray-300 dark:text-gray-700 text-8xl"></i>
                    </div>
                @endif
                
                {{-- Navigation Buttons --}}
                @if($produto->imagens->count() > 1)
                    <button 
                        class="absolute left-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm flex items-center justify-center shadow-lg hover:scale-110 transition-transform"
                        onclick="navigateImage(-1)"
                        aria-label="Imagem anterior"
                    >
                        <i class="fas fa-chevron-left text-gray-700 dark:text-gray-300"></i>
                    </button>
                    <button 
                        class="absolute right-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm flex items-center justify-center shadow-lg hover:scale-110 transition-transform"
                        onclick="navigateImage(1)"
                        aria-label="Próxima imagem"
                    >
                        <i class="fas fa-chevron-right text-gray-700 dark:text-gray-300"></i>
                    </button>
                @endif
                
                {{-- Badges --}}
                <div class="absolute top-6 left-6 flex flex-col gap-2">
                    @if($produto->preco_promocional)
                        @php
                            $desconto = calculateDiscountPercentage($produto->preco, $produto->preco_promocional);
                        @endphp
                        <span class="px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-sm font-bold rounded-lg shadow-lg">
                            -{{ $desconto }}% OFF
                        </span>
                    @endif
                    @if($produto->novidade)
                        <span class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold rounded-lg shadow-lg">
                            <i class="fas fa-bolt mr-1"></i> NOVO
                        </span>
                    @endif
                </div>
                
                {{-- Favorite Button --}}
                <button 
                    wire:click="addToFavorites({{ $produto->id_produto }})"
                    @click="isLoading = true"
                    wire:loading.attr="disabled"
                    :disabled="isLoading"
                    class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm flex items-center justify-center shadow-lg hover:scale-110 transition-transform group"
                    :title="isFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos'"
                    aria-label="Adicionar aos favoritos">
                    <div class="relative">
                        {{-- Ícone do coração --}}
                        <i class="fas fa-heart text-2xl transition-colors duration-300"
                           :class="isFavorito ? 'text-rose-500' : 'text-gray-400 group-hover:text-rose-500'"
                           x-show="!isLoading"></i>
                        
                        {{-- Loader durante a ação --}}
                        <div class="absolute inset-0 flex items-center justify-center"
                             x-show="isLoading"
                             x-transition:enter="transition-opacity duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <div class="w-5 h-5 border-2 border-rose-500/30 border-t-rose-500 
                                      rounded-full animate-spin"></div>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        {{-- Thumbnails --}}
        @if($produto->imagens->count() > 1)
            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                @foreach($produto->imagens as $index => $imagem)
                    <button 
                        wire:click="selecionarImagem('{{ $imagem->url_imagem }}')"
                        class="flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border-2 {{ ($imagemSelecionada ?? $produto->imagens->first()->url_imagem) === $imagem->url_imagem ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600' }} transition-all duration-200 group"
                        data-index="{{ $index }}"
                        aria-label="Ver imagem {{ $index + 1 }}"
                    >
                        <div class="relative w-full h-full">
                            <img 
                                src="{{ image_url($imagem->url_imagem) }}" 
                                alt="{{ $produto->nome }} - Imagem {{ $index + 1 }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Mobile Image Gallery --}}
    <div class="lg:hidden">
        {{-- Main Image --}}
        <div class="relative bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden mb-4">
            <div>
                @if($imagemSelecionada ?? $produto->imagens->first()?->url_imagem)
                    <img 
                        src="{{ image_url($imagemSelecionada ?? $produto->imagens->first()->url_imagem) }}" 
                        alt="{{ $produto->nome }}"
                        class="w-full h-full object-contain"
                        loading="eager"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-image text-gray-300 dark:text-gray-700 text-6xl"></i>
                    </div>
                @endif
                
                {{-- Badges --}}
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    @if($produto->preco_promocional)
                        @php
                            $desconto = calculateDiscountPercentage($produto->preco, $produto->preco_promocional);
                        @endphp
                        <span class="px-3 py-2 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-sm font-bold rounded-lg shadow-lg">
                            -{{ $desconto }}% OFF
                        </span>
                    @endif
                    @if($produto->novidade)
                        <span class="px-3 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold rounded-lg shadow-lg">
                            <i class="fas fa-bolt mr-1"></i> NOVO
                        </span>
                    @endif
                </div>
                
                {{-- Favorite Button --}}
                <button 
                    wire:click="addToFavorites({{ $produto->id_produto }})"
                    @click="isLoading = true"
                    wire:loading.attr="disabled"
                    :disabled="isLoading"
                    class="absolute top-4 right-4 w-12 h-12 rounded-full bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm flex items-center justify-center shadow-lg hover:scale-110 transition-transform group"
                    :title="isFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos'"
                    @favorito-atualizado.window="
                        if ($event.detail.produtoId === {{ $produto->id_produto }}) {
                            isFavorito = $event.detail.acao === 'adicionado';
                            isLoading = false;
                        }
                    ">
                    <div class="relative">
                        <i class="fas fa-heart text-xl transition-colors duration-300"
                           :class="isFavorito ? 'text-rose-500' : 'text-gray-400 group-hover:text-rose-500'"
                           x-show="!isLoading"></i>
                        
                        <div class="absolute inset-0 flex items-center justify-center"
                             x-show="isLoading"
                             x-transition:enter="transition-opacity duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <div class="w-4 h-4 border-2 border-rose-500/30 border-t-rose-500 
                                      rounded-full animate-spin"></div>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        {{-- Thumbnails --}}
        @if($produto->imagens->count() > 1)
            <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                @foreach($produto->imagens as $imagem)
                    <button 
                        wire:click="selecionarImagem('{{ $imagem->url_imagem }}')"
                        class="aspect-square rounded-xl overflow-hidden border-2 {{ ($imagemSelecionada ?? $produto->imagens->first()->url_imagem) === $imagem->url_imagem ? 'border-blue-500' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600' }} transition-colors"
                    >
                        <img 
                            src="{{ image_url($imagem->url_imagem) }}" 
                            alt="{{ $produto->nome }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>
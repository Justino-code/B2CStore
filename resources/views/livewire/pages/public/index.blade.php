{{-- resources/views/livewire/pages/public/index.blade.php --}}
<div x-data="{
    init() {
        if (window.initSwiper && typeof Swiper !== 'undefined') {
            window.initSwiperByType('.swiper-container', 'hero');
        }
    }
}" 
x-init="init()"
wire:ignore>
    
    <!-- ========== HERO BANNER ========== -->
    <section class="relative overflow-hidden">
        <div class="swiper-container h-[400px] md:h-[500px]">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide relative">
                    @if($banner->imagem)
                    <img src="{{ asset('storage/' . $banner->imagem) }}" 
                         alt="{{ $banner->titulo }}"
                         class="w-full h-full object-cover"
                         loading="lazy">
                    @else
                    <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600"></div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4 md:px-8">
                            <div class="max-w-xl text-white">
                                <h1 class="text-3xl md:text-4xl font-bold mb-3 animate__animated animate__fadeInUp">
                                    {{ $banner->titulo }}
                                </h1>
                                <p class="text-base md:text-lg mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                                    {{ $banner->subtitulo }}
                                </p>
                                @if($banner->link)
                                <a href="{{ $banner->link }}"
                                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 transform hover:-translate-y-1 animate__animated animate__fadeInUp animate__delay-2s">
                                    {{ $banner->texto_botao ?? 'Comprar Agora' }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Navigation Buttons -->
            <div class="swiper-button-next text-white mr-4 md:mr-8"></div>
            <div class="swiper-button-prev text-white ml-4 md:ml-8"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- ========== CATEGORIAS DESTAQUE ========== -->
    <section class="py-8 md:py-12 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-th-large mr-2 text-blue-600"></i>
                    Categorias em Destaque
                </h2>
                @if($categorias->count() > 0)
                <a href="{{ route('categorias') }}"
                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center text-sm md:text-base">
                    Ver todas
                    <i class="fas fa-chevron-right ml-1 md:ml-2"></i>
                </a>
                @endif
            </div>

            @if($categorias->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-3 md:gap-4">
                @foreach($categorias as $categoria)
                <a href="{{ route('categoria', $categoria->slug) }}"
                   class="group relative overflow-hidden bg-gray-50 dark:bg-gray-700 rounded-lg md:rounded-xl p-3 md:p-4 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-2 md:mb-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        @if($categoria->imagem_url)
                        <img src="{{ image_url($categoria->imagem_url) }}"
                             alt="{{ $categoria->nome }}"
                             class="w-8 h-8 md:w-10 md:h-10 object-contain"
                             loading="lazy">
                        @else
                        <i class="fas fa-box text-blue-600 dark:text-blue-400 text-base md:text-xl"></i>
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1 text-sm md:text-base line-clamp-1">
                        {{ $categoria->nome }}
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">
                        {{ $categoria->produtos_count }} produtos
                    </p>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-th-large text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">Nenhuma categoria cadastrada.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- ========== PRODUTOS EM DESTAQUE ========== -->
    <section id="produtos" class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-star mr-2 text-yellow-500"></i>
                    Produtos em Destaque
                </h2>
                @if($destaques->count() > 0)
                <a href="{{ route('produtos.destaque') }}"
                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center text-sm md:text-base">
                    Ver todos
                    <i class="fas fa-chevron-right ml-1 md:ml-2"></i>
                </a>
                @endif
            </div>

            @if($destaques->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 md:gap-6">
                @foreach($destaques as $produto)
                    @include('components.ui.product-card', ['produto' => $produto])
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-star text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">Nenhum produto em destaque.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- ========== BANNER PROMOCIONAL ========== -->
    @if($promocoes->count() > 0)
    <section class="py-8 md:py-12">
        <div class="container mx-auto px-4">
            <div class="relative bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-800 dark:to-purple-800 rounded-xl md:rounded-2xl overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-48 h-48 md:w-64 md:h-64 bg-white rounded-full -translate-y-16 md:-translate-y-32 translate-x-16 md:translate-x-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 md:w-96 md:h-96 bg-white rounded-full translate-y-24 md:translate-y-48 -translate-x-24 md:-translate-x-48"></div>
                </div>
                
                <div class="relative py-8 md:py-12 px-4 md:px-16 flex flex-col md:flex-row items-center justify-between">
                    <div class="text-white mb-6 md:mb-0 md:mr-8 text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">
                            Ofertas Especiais!
                        </h2>
                        <p class="text-base md:text-lg mb-4 md:mb-6 opacity-90">
                            Produtos selecionados com descontos exclusivos
                        </p>
                        <p class="text-sm opacity-80">
                            {{ $promocoes->count() }} produtos em promoção
                        </p>
                    </div>
                    
                    <a href="{{ route('produtos.promocao') }}"
                       class="inline-flex items-center px-6 py-3 md:px-8 md:py-4 bg-white text-blue-600 hover:bg-gray-100 font-bold text-base md:text-lg rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        Aproveitar Ofertas
                        <i class="fas fa-bolt ml-2 md:ml-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ========== PRODUTOS EM PROMOÇÃO ========== -->
    <section class="py-8 md:py-12 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-tag mr-2 text-red-500"></i>
                    Produtos em Promoção
                </h2>
                @if($promocoes->count() > 0)
                <a href="{{ route('produtos.promocao') }}"
                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center text-sm md:text-base">
                    Ver todos
                    <i class="fas fa-chevron-right ml-1 md:ml-2"></i>
                </a>
                @endif
            </div>

            @if($promocoes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($promocoes as $produto)
                    @include('components.ui.product-card', ['produto' => $produto, 'destaquePromo' => true])
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-tag text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">Nenhum produto em promoção no momento.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- ========== NOVIDADES ========== -->
    @if($novidades->count() > 0)
    <section class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-rocket mr-2 text-green-500"></i>
                    Novidades
                </h2>
                <a href="{{ route('produtos.novidade') }}"
                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center text-sm md:text-base">
                    Ver todos
                    <i class="fas fa-chevron-right ml-1 md:ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($novidades as $produto)
                    @include('components.ui.product-card', ['produto' => $produto, 'novidade' => true])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ========== VANTAGENS ========== -->
    <section class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <i class="fas fa-shipping-fast text-blue-600 dark:text-blue-400 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 md:mb-2 text-base md:text-lg">Entrega Rápida</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Entrega em até 48h para SP e RJ</p>
                </div>
                
                <div class="text-center">
                    <div class="w-14 h-14 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-green-600 dark:text-green-400 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 md:mb-2 text-base md:text-lg">Compra Segura</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Site 100% seguro com SSL</p>
                </div>
                
                <div class="text-center">
                    <div class="w-14 h-14 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-purple-600 dark:text-purple-400 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 md:mb-2 text-base md:text-lg">Devolução Fácil</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">7 dias para arrependimento</p>
                </div>
                
                <div class="text-center">
                    <div class="w-14 h-14 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                        <i class="fas fa-headset text-yellow-600 dark:text-yellow-400 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 md:mb-2 text-base md:text-lg">Suporte 24/7</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Atendimento via chat e telefone</p>
                </div>
            </div>
        </div>
    </section>
</div>
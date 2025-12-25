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
    
    <!-- ========== HERO BANNER MODERNO E ELEGANTE ========== -->
    <section class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black">
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/10 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/10 rounded-full mix-blend-multiply filter blur-3xl animate-pulse delay-1000"></div>
            
            <!-- Animated Orbs -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-cyan-500/20 rounded-full animate-ping opacity-20"></div>
            <div class="absolute bottom-1/3 right-1/3 w-24 h-24 bg-purple-500/20 rounded-full animate-ping opacity-20 delay-500"></div>
            
            <!-- Grid Pattern -->
            <div class="absolute inset-0 opacity-5" 
                 style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), 
                        linear-gradient(to bottom, #ffffff 1px, transparent 1px);
                        background-size: 40px 40px;"></div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper-container h-[500px] md:h-[600px] lg:h-[700px] relative">
            <div class="swiper-wrapper">
                @forelse($banners as $banner)
                    <div class="swiper-slide relative">
                        <!-- Background Image with Parallax Effect -->
                        <div class="absolute inset-0 overflow-hidden">
                            @if($banner->imagem)
                                <img
                                    src="{{ image_url($banner->imagem) }}"
                                    alt="{{ $banner->titulo }}"
                                    class="w-full h-full object-cover swiper-parallax"
                                    data-swiper-parallax="-30%"
                                    data-swiper-parallax-duration="800"
                                    loading="lazy"
                                />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900"></div>
                            @endif
                            
                            <!-- Gradient Overlays -->
                            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/40"></div>
                        </div>

                        <!-- Content Container -->
                        <div class="relative h-full flex items-center">
                            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                                <div class="max-w-2xl lg:max-w-3xl">
                                    <!-- Badge -->
                                    <div class="inline-flex items-center gap-2 mb-6 md:mb-8 swiper-parallax"
                                         data-swiper-parallax="-100"
                                         data-swiper-parallax-duration="600">
                                        <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-sm font-semibold rounded-full shadow-lg">
                                            <i class="fas fa-bolt mr-2 animate-pulse"></i>Destaque
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6 leading-tight swiper-parallax"
                                        data-swiper-parallax="-200"
                                        data-swiper-parallax-duration="800">
                                        <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-purple-400 bg-clip-text text-transparent">
                                            {{ $banner->titulo }}
                                        </span>
                                    </h1>

                                    <!-- Subtitle -->
                                    <p class="text-lg md:text-xl lg:text-2xl text-white/90 mb-8 md:mb-10 leading-relaxed max-w-xl swiper-parallax"
                                       data-swiper-parallax="-150"
                                       data-swiper-parallax-duration="1000">
                                        {{ $banner->subtitulo }}
                                    </p>

                                    <!-- CTA Button -->
                                    @if($banner->link)
                                        <div class="flex flex-col sm:flex-row gap-4 swiper-parallax"
                                             data-swiper-parallax="-50"
                                             data-swiper-parallax-duration="1200">
                                            <a href="{{ $banner->link }}"
                                               class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/30 inline-flex items-center justify-center gap-3 overflow-hidden">
                                                <!-- Button Shine Effect -->
                                                <span class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent"></span>
                                                
                                                <span>{{ $banner->texto_botao ?? 'Saiba Mais' }}</span>
                                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                            </a>
                                        </div>
                                    @endif

                                   
                                </div>
                            </div>
                        </div>

                        <!-- Slide Number -->
                        <div class="absolute bottom-8 right-8 z-10">
                            <div class="text-white/60 text-sm font-mono">
                                <span class="text-2xl font-bold text-white">{{ $loop->iteration }}</span>
                                <span class="mx-2">/</span>
                                <span>{{ $banners->count() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Default Slide -->
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900">
                            <!-- Animated Background -->
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%239C92AC\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                            
                            <!-- Floating Elements -->
                            <div class="absolute top-20 left-20 w-48 h-48 bg-white/5 rounded-full animate-float"></div>
                            <div class="absolute bottom-20 right-20 w-64 h-64 bg-white/5 rounded-full animate-float delay-1000"></div>
                        </div>

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                        <!-- Content -->
                        <div class="relative h-full flex items-center">
                            <div class="container mx-auto px-4 md:px-8">
                                <div class="max-w-3xl">
                                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                                        <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-purple-400 bg-clip-text text-transparent">
                                            Bem-vindo à <br><span class="text-white">B2CStore</span>
                                        </span>
                                    </h1>
                                    <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-2xl leading-relaxed">
                                        Descubra uma experiência de compra única com produtos selecionados, 
                                        qualidade premium e atendimento excepcional.
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <a href="{{ route('produtos') }}"
                                           class="group px-10 py-5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold text-lg rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/30 inline-flex items-center justify-center gap-3 overflow-hidden">
                                            <!-- Shine Effect -->
                                            <span class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent"></span>
                                            
                                            <i class="fas fa-gem text-lg"></i>
                                            <span>Explorar Produtos</span>
                                            <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Navigation -->
            @if($banners->count() > 1)
                <div class="swiper-button-next !text-white !w-14 !h-14 !rounded-full !bg-white/10 !backdrop-blur-sm !border !border-white/20 hover:!bg-white/20 hover:!scale-110 transition-all duration-300 mr-4 md:mr-8">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="swiper-button-prev !text-white !w-14 !h-14 !rounded-full !bg-white/10 !backdrop-blur-sm !border !border-white/20 hover:!bg-white/20 hover:!scale-110 transition-all duration-300 ml-4 md:ml-8">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="swiper-pagination !bottom-8">
                    <span class="swiper-pagination-bullet !bg-white/50 !opacity-50 hover:!opacity-100 transition-opacity"></span>
                    <span class="swiper-pagination-bullet-active !bg-gradient-to-r !from-blue-500 !to-cyan-500 !opacity-100"></span>
                </div>
            @endif

            <!-- Autoplay Progress Bar -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/10 z-20">
                <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 swiper-progress-bar" 
                     style="transition: width 5s linear;"></div>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-8 z-20 hidden md:block">
                <div class="flex flex-col items-center text-white/60 text-sm animate-bounce">
                    <span class="mb-2 text-xs uppercase tracking-wider">Scroll</span>
                    <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                        <div class="w-1 h-3 bg-white/60 rounded-full mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

      <!-- Social Proof Banner -->
<div class="absolute bottom-0 left-0 right-0 z-10 bg-gradient-to-r from-black/50 to-transparent backdrop-blur-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between text-white/80 text-sm">

            <!-- Clientes satisfeitos -->
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-400"></i>
                <span>
                    +{{ number_format($clientesSatisfeitos, 0, ',', '.') }}
                    clientes satisfeitos
                </span>
            </div>

            <!-- Estrelas + Entrega -->
            <div class="hidden md:flex items-center gap-4">

                <!-- Avaliação média -->
                <div class="flex items-center gap-2">
                    <div class="flex">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($estrelas))
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                            @elseif ($i - $estrelas < 1)
                                <i class="fas fa-star-half-alt text-yellow-400 text-xs"></i>
                            @else
                                <i class="far fa-star text-yellow-400 text-xs"></i>
                            @endif
                        @endfor
                    </div>

                    <span>
                        {{ number_format($estrelas, 1) }}/5
                    </span>
                </div>

                <!-- Separador -->
                <div class="w-px h-4 bg-white/30"></div>

                <!-- Entrega -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-shipping-fast text-blue-400"></i>
                    <span>Entrega em 24h</span>
                </div>

            </div>
        </div>
    </div>
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
                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Entrega em até 48h</p>
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

@push('styles')
<style>
    /* Animação personalizada para elementos flutuantes */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) translateX(0px);
        }
        33% {
            transform: translateY(-20px) translateX(10px);
        }
        66% {
            transform: translateY(10px) translateX(-10px);
        }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .delay-1000 {
        animation-delay: 1s;
    }
    
    .delay-500 {
        animation-delay: 0.5s;
    }
    
    /* Estilos personalizados para Swiper */
    .swiper-progress-bar {
        width: 0%;
    }
    
    .swiper-slide-active .swiper-progress-bar {
        width: 100%;
    }
</style>
@endpush
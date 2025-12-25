{{-- resources/views/livewire/pages/public/sobre.blade.php --}}
<div>
    {{-- Hero Section --}}
    <section class="relative py-20 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 dark:from-blue-900 dark:via-indigo-900 dark:to-purple-900 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-1000"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <nav class="mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-100 hover:text-white">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-blue-200 text-xs mx-2"></i>
                        <span class="text-white font-medium">Sobre Nós</span>
                    </li>
                </ol>
            </nav>
            
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                    A <span class="text-yellow-300">Nossa</span> História
                </h1>
                <p class="text-xl text-blue-100 mb-8">
                    Conectando você aos melhores produtos com qualidade, confiança e inovação
                </p>
                <div class="inline-flex items-center space-x-4">
                    <span class="text-yellow-300 text-sm font-semibold">
                        <i class="fas fa-star mr-1"></i> 4.9 Avaliação dos Clientes
                    </span>
                    <span class="text-white text-sm">
                        <i class="fas fa-shopping-cart mr-1"></i> +10.000 Produtos
                    </span>
                    <span class="text-white text-sm">
                        <i class="fas fa-users mr-1"></i> +50.000 Clientes Satisfeitos
                    </span>
                </div>
            </div>
        </div>
        
        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-auto" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" class="dark:fill-gray-900"/>
            </svg>
        </div>
    </section>

    {{-- Our Story --}}
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm font-semibold mb-6">
                        <i class="fas fa-rocket mr-2"></i> Desde 2020
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Transformando o <span class="text-blue-600 dark:text-blue-400">Comércio Eletrônico</span>
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">
                        Fundada em 2020, a B2CStore nasceu com a missão de revolucionar a experiência de compra online. 
                        Começamos como uma pequena loja virtual e hoje somos referência no mercado digital.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                        Nossa jornada é marcada pela inovação constante, qualidade excepcional e um compromisso 
                        inabalável com a satisfação dos nossos clientes.
                    </p>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">+50K</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Clientes Ativos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">+10K</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Produtos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">99%</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Satisfação</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">24/7</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Suporte</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img 
                            src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                            alt="Nossa Equipe trabalhando juntos"
                            class="w-full h-[500px] object-cover"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    </div>
                    
                    {{-- Floating Card --}}
                    <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 max-w-xs">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white mr-4">
                                <i class="fas fa-trophy text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white">Prêmio Excelência</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">2023</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Reconhecida como a melhor plataforma de e-commerce do ano.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Values --}}
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Nossos <span class="text-blue-600 dark:text-blue-400">Valores</span>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Princípios que guiam cada decisão e ação na B2CStore
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Value 1 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Confiança</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Construímos relacionamentos baseados na transparência e integridade em todas as transações.
                    </p>
                </div>
                
                {{-- Value 2 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-medal text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Qualidade</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Compromisso com a excelência em cada produto e serviço que oferecemos aos nossos clientes.
                    </p>
                </div>
                
                {{-- Value 3 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-lightbulb text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Inovação</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Estamos sempre à frente, buscando novas tecnologias e soluções para melhorar sua experiência.
                    </p>
                </div>
                
                {{-- Value 4 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-heart text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Paixão</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Amamos o que fazemos e isso se reflete em cada detalhe da sua jornada de compra.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Team --}}
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Conheça Nossa <span class="text-blue-600 dark:text-blue-400">Equipe</span>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Profissionais dedicados que tornam a B2CStore especial
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Team Member 1 --}}
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="relative overflow-hidden h-64">
                        <img 
                            src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                            alt="CEO - Maria Silva"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Maria Silva</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-4">CEO & Fundadora</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Visionária e apaixonada por tecnologia, lidera a empresa com foco em inovação e crescimento.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Team Member 2 --}}
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="relative overflow-hidden h-64">
                        <img 
                            src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                            alt="CTO - João Santos"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">João Santos</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-4">CTO</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Especialista em tecnologia com mais de 15 anos de experiência em e-commerce.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Team Member 3 --}}
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="relative overflow-hidden h-64">
                        <img 
                            src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                            alt="CMO - Ana Pereira"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Ana Pereira</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-4">CMO</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Estrategista de marketing digital com foco em experiência do cliente e branding.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Team Member 4 --}}
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="relative overflow-hidden h-64">
                        <img 
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                            alt="CSO - Pedro Costa"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Pedro Costa</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-4">Chefe de Suporte</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            Garante que cada cliente tenha uma experiência excepcional em todas as interações.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    O Que Nossos <span class="text-blue-600 dark:text-blue-400">Clientes</span> Dizem
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Histórias reais de satisfação e confiança
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Testimonial 1 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img 
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                                alt="Carlos Mendes"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Carlos Mendes</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cliente desde 2021</p>
                        </div>
                    </div>
                    <div class="flex text-amber-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 italic">
                        "A B2CStore transformou minha forma de comprar. A qualidade dos produtos e o atendimento são excepcionais. Recomendo!"
                    </p>
                </div>
                
                {{-- Testimonial 2 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img 
                                src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                                alt="Sofia Almeida"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Sofia Almeida</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cliente desde 2022</p>
                        </div>
                    </div>
                    <div class="flex text-amber-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 italic">
                        "Entrega rápida, produtos de qualidade e suporte incrível. Minha loja online favorita! Nunca tive problemas."
                    </p>
                </div>
                
                {{-- Testimonial 3 --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img 
                                src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                                alt="Ricardo Santos"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Ricardo Santos</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cliente desde 2020</p>
                        </div>
                    </div>
                    <div class="flex text-amber-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 italic">
                        "Como cliente desde o início, posso dizer que a evolução foi impressionante. Cada vez melhores!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Mission & Vision --}}
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- Mission --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-8 shadow-lg">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Nossa Missão</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Oferecer a melhor experiência de compra online através de produtos de qualidade, 
                        tecnologia inovadora e um atendimento excepcional que supera as expectativas dos nossos clientes.
                    </p>
                    <img 
                        src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                        alt="Equipe focada em missão"
                        class="w-full h-48 object-cover rounded-xl"
                        loading="lazy"
                    >
                </div>
                
                {{-- Vision --}}
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-8 shadow-lg">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white mb-6">
                        <i class="fas fa-eye text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Nossa Visão</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Ser a principal referência em e-commerce na região, reconhecida pela inovação, 
                        sustentabilidade e pelo impacto positivo na vida dos nossos clientes e comunidades.
                    </p>
                    <img 
                        src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                        alt="Visão de futuro"
                        class="w-full h-48 object-cover rounded-xl"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-800 dark:to-indigo-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Pronto para uma Nova Experiência de Compra?
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    Junte-se a milhares de clientes satisfeitos e descubra o melhor do e-commerce
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('produtos') }}" 
                       class="px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 font-bold rounded-xl transition-colors duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl">
                        <i class="fas fa-shopping-bag"></i>
                        Começar a Comprar
                    </a>
                    <a href="{{ route('contato') }}" 
                       class="px-8 py-4 bg-transparent border-2 border-white text-white hover:bg-white/10 font-bold rounded-xl transition-colors duration-300 flex items-center justify-center gap-3">
                        <i class="fas fa-phone-alt"></i>
                        Fale Conosco
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0.3;
        }
    }
    
    .delay-1000 {
        animation-delay: 1s;
    }
</style>
@endpush
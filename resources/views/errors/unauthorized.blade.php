{{-- resources/views/errors/unauthorized.blade.php --}}
<x-app-layout>
    @push('styles')
    <style>
        @keyframes gentle-float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(2deg); }
            66% { transform: translateY(-5px) rotate(-1deg); }
        }
        
        .animate-gentle-float { animation: gentle-float 6s ease-in-out infinite; }
        
        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        
        .dark .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
        }
    </style>
    @endpush

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-900 dark:to-blue-900/20 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-grid-pattern"></div>
        
        <div class="relative max-w-2xl w-full">
            <!-- Main Card -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
                
                <!-- Decorative Header -->
                <div class="h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                
                <div class="p-8 md:p-12">
                    <!-- Illustration Container -->
                    <div class="relative mb-10">
                        <div class="w-64 h-64 mx-auto">
                            <!-- Main Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-48 h-48 rounded-2xl bg-gradient-to-br from-blue-500/10 to-indigo-500/10 dark:from-blue-500/5 dark:to-indigo-500/5 flex items-center justify-center shadow-inner">
                                    <div class="w-32 h-32 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center shadow-lg">
                                        <i class="fas fa-compass text-5xl text-blue-500 dark:text-blue-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 mb-6">
                            <i class="fas fa-info-circle text-blue-500 dark:text-blue-400 mr-2"></i>
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Direção necessária</span>
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            Caminho não disponível
                        </h1>
                        
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800/50 dark:to-blue-900/20 rounded-2xl p-6 max-w-lg mx-auto mb-6">
                            <p class="text-gray-600 dark:text-gray-300 mb-4 text-lg leading-relaxed">
                                Parece que você chegou a um lugar que não está disponível no momento.
                            </p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Não se preocupe, podemos ajudá-lo a encontrar o que precisa.
                            </p>
                        </div>
                    </div>

                    <!-- Primary Action Buttons -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                        <a href="{{ route('home') }}" 
                           class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-2xl p-5 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl">
                            <div class="absolute inset-0 bg-white/10 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-700"></div>
                            <div class="relative flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4 group-hover:rotate-12 transition-transform">
                                    <i class="fas fa-home text-xl"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-semibold text-lg">Voltar ao Início</div>
                                    <div class="text-sm opacity-90">Página principal</div>
                                </div>
                                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                        
                        <button onclick="window.history.back()" 
                                class="group relative overflow-hidden bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-500 text-gray-700 dark:text-gray-300 font-medium rounded-2xl p-5 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-sm hover:shadow-md">
                            <div class="absolute inset-0 bg-gray-50 dark:bg-gray-700/50 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-700"></div>
                            <div class="relative flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mr-4 group-hover:-translate-x-1 transition-transform">
                                    <i class="fas fa-arrow-left text-xl text-gray-600 dark:text-gray-400"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-semibold text-lg">Retornar</div>
                                    <div class="text-sm opacity-90">Para onde estava</div>
                                </div>
                            </div>
                        </button>
                    </div>

                    <!-- Quick Links -->
                    <div class="border-t border-gray-200 dark:border-gray-800 pt-10">
                        <p class="text-gray-500 dark:text-gray-400 mb-6 text-center text-sm font-medium">
                            Explore nossas seções principais:
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <a href="{{ route('produtos') }}" 
                               class="group flex flex-col items-center p-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl hover:border-blue-200 dark:hover:border-blue-800 hover:shadow-lg transition-all duration-300">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-box text-blue-500 dark:text-blue-400"></i>
                                </div>
                                <div class="font-medium text-gray-900 dark:text-white">Produtos</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Descubra novidades</div>
                            </a>
                            
                            <a href="{{ route('categorias') }}" 
                               class="group flex flex-col items-center p-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl hover:border-green-200 dark:hover:border-green-800 hover:shadow-lg transition-all duration-300">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-tags text-green-500 dark:text-green-400"></i>
                                </div>
                                <div class="font-medium text-gray-900 dark:text-white">Categorias</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Navegue por tipo</div>
                            </a>
                            
                            <a href="{{ route('login') }}" 
                               class="group flex flex-col items-center p-4 bg-gradient-to-r from-purple-500/10 to-pink-500/10 dark:from-purple-500/5 dark:to-pink-500/5 border border-purple-200 dark:border-purple-800/30 rounded-xl hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg transition-all duration-300">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-user text-purple-500 dark:text-purple-400"></i>
                                </div>
                                <div class="font-medium text-gray-900 dark:text-white">Conta</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Acesse sua conta</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    
    <script>
        // Animações para ícones
        document.addEventListener('DOMContentLoaded', function() {
            // Adiciona animação de flutuação aos ícones
            const mainIcon = document.querySelector('.absolute.inset-0');
            if (mainIcon) {
                mainIcon.classList.add('animate-gentle-float');
            }
            
            // Efeito de ripple nos botões
            const buttons = document.querySelectorAll('a, button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.5);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        pointer-events: none;
                    `;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                });
            });
            
            // Adiciona CSS para animação ripple
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
    @endpush
</x-app-layout>
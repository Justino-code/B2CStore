{{-- components/footer/public.blade.php --}}
<footer class="bg-gray-900 dark:bg-gray-950 text-white transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">

            <!-- Brand Column -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg"></div>
                    <div class="ml-3">
                        <div class="text-xl font-bold">B2CStore</div>
                        <div class="text-gray-400 text-sm">Sua loja digital</div>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Produtos de qualidade com entrega rápida e atendimento especializado.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3">
                <h3 class="text-base font-semibold">Links Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Início</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Produtos</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Categorias</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Sobre</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="space-y-3">
                <h3 class="text-base font-semibold">Suporte</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Ajuda</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Contato</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Entrega</a></li>
                </ul>
            </div>

            <!-- Contact & Newsletter -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold">Fique por dentro</h3>
                <div class="space-y-3">
                    <p class="text-gray-400 text-sm">Receba nossas ofertas</p>
                    <div class="flex">
                        <input type="email"
                               placeholder="Seu e-mail"
                               class="flex-1 px-3 py-2 text-sm text-gray-900 bg-white rounded-l-lg focus:outline-none">
                        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-sm font-medium rounded-r-lg transition-colors">
                            Inscrever
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="mt-8 pt-8 border-t border-gray-800"></div>

        <!-- Bottom Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-gray-500 text-sm text-center sm:text-left">
                &copy; {{ date('Y') }} B2CStore. Todos os direitos reservados.
            </div>

            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <div class="flex items-center space-x-2">
                    <span class="text-gray-500 text-sm hidden sm:inline">Tema:</span>
                    <x-theme-toggle-button />
                </div>

                <!-- Links -->
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Termos</a>
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Privacidade</a>
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors hidden sm:inline">Cookies</a>
                </div>
            </div>
        </div>

    </div>
</footer>

{{-- components/footer/cliente.blade.php --}}
<footer class="bg-gray-800 dark:bg-gray-900 text-white transition-colors duration-300">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg"></div>
                    <span class="ml-2 text-xl font-bold tracking-tight">B2CStore</span>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Sua experiência de compra digital, segura e conveniente em um só lugar.
                </p>
            </div>

            <!-- Minha Conta -->
            <div class="space-y-3">
                <h3 class="text-lg font-semibold text-white">Minha Conta</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Meu Perfil</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Meus Pedidos</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Favoritos</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Endereços</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Configurações</a></li>
                </ul>
            </div>

            <!-- Ajuda -->
            <div class="space-y-3">
                <h3 class="text-lg font-semibold text-white">Ajuda</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Central de Ajuda</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">FAQ</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Entrega</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Trocas</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Contato</a></li>
                </ul>
            </div>

            <!-- Pagamentos Seguros -->
            <div class="space-y-3">
                <h3 class="text-lg font-semibold text-white">Pagamentos</h3>
                <div class="flex space-x-2">
                    <div class="w-10 h-6 bg-gray-700 rounded flex items-center justify-center">
                        <span class="text-xs">VISA</span>
                    </div>
                    <div class="w-10 h-6 bg-gray-700 rounded flex items-center justify-center">
                        <span class="text-xs">MC</span>
                    </div>
                    <div class="w-10 h-6 bg-gray-700 rounded flex items-center justify-center">
                        <span class="text-xs">PIX</span>
                    </div>
                </div>
                <p class="text-gray-300 text-xs mt-2">
                    Compra 100% segura com criptografia SSL.
                </p>

                <!-- Botão de Tema -->
                <div class="pt-4 flex items-center space-x-2">
                    <span class="text-gray-300 text-sm">Tema:</span>
                    <x-theme-toggle-button />
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 pt-8 border-t border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} B2CStore. CNPJ: 00.000.000/0000-00
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">Termos</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">Privacidade</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

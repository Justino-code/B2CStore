<footer class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo e Descrição -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg"></div>
                    <span class="ml-2 text-xl font-bold">B2CStore</span>
                </div>
                <p class="text-gray-300 text-sm">
                    Sua loja escolar completa. Oferecemos materiais de qualidade, entrega rápida e atendimento especializado para estudantes e instituições.
                </p>
            </div>

            <!-- Links Rápidos -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white text-sm">Produtos</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-white text-sm">Categorias</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white text-sm">Sobre Nós</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white text-sm">Contato</a></li>
                </ul>
            </div>

            <!-- Suporte -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Suporte</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('faq') }}" class="text-gray-300 hover:text-white text-sm">Perguntas Frequentes</a></li>
                    <li><a href="{{ route('shipping') }}" class="text-gray-300 hover:text-white text-sm">Entrega</a></li>
                    <li><a href="{{ route('returns') }}" class="text-gray-300 hover:text-white text-sm">Trocas e Devoluções</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-300 hover:text-white text-sm">Privacidade</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} B2CStore. CNPJ: 00.000.000/0000-00
                </p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="{{ route('terms') }}" class="text-gray-300 hover:text-white text-sm">Termos de Uso</a>
                    <a href="{{ route('privacy') }}" class="text-gray-300 hover:text-white text-sm">Política de Privacidade</a>
                </div>
            </div>
        </div>
    </div>
</footer>

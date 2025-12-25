{{-- resources/views/livewire/pages/public/partials/produto-reviews.blade.php --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Left Column: Summary --}}
    <div class="lg:col-span-1">
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-6 sticky top-6">
            <div class="text-center mb-6">
                <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ number_format($ratingMedio, 1) }}
                </div>
                <div class="flex items-center justify-center mb-3">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-2xl {{ $i <= floor($ratingMedio) ? 'text-amber-400' : ($i <= ceil($ratingMedio) ? 'text-amber-300' : 'text-gray-300 dark:text-gray-600') }} mr-1"></i>
                    @endfor
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    Baseado em {{ $totalReviews }} {{ Str::plural('avaliação', $totalReviews) }}
                </p>
            </div>

            {{-- Rating Distribution --}}
            <div class="space-y-3 mb-6">
                @foreach($reviewsStats['distribuicao'] as $stat)
                    <div class="flex items-center">
                        <div class="flex items-center w-16">
                            <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">{{ $stat['rating'] }}</span>
                            <i class="fas fa-star text-amber-400 text-sm"></i>
                        </div>
                        <div class="flex-1 mx-3">
                            <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full transition-all duration-500" 
                                     style="width: {{ $stat['percentage'] }}%"></div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400 w-10 text-right">
                            {{ $stat['count'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Review Button --}}
            @auth
                <button 
                    @click="$wire.openReviewModal()"
                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center gap-2 hover:scale-[1.02]"
                >
                    <i class="fas fa-star"></i>
                    Avaliar Produto
                </button>
            @else
                <div class="text-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                    <p class="text-amber-700 dark:text-amber-300 text-sm mb-3">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        Faça login para avaliar este produto
                    </p>
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-sign-in-alt"></i>
                        Fazer Login
                    </a>
                </div>
            @endauth
        </div>

        {{-- Review Guidelines --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5">
            <h4 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                Diretrizes para avaliações
            </h4>
            <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-400">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                    <span>Seja específico sobre sua experiência</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                    <span>Inclua pontos positivos e áreas de melhoria</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                    <span>Evite linguagem ofensiva ou inapropriada</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Right Column: Reviews List --}}
    <div class="lg:col-span-2">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $reviewsStats['total'] }}</div>
                <div class="text-sm text-blue-700 dark:text-blue-300">Total Avaliações</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">
                    {{ $reviewsStats['positivas'] }}
                </div>
                <div class="text-sm text-green-700 dark:text-green-300">Positivas (4-5)</div>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-1">
                    {{ $reviewsStats['neutras'] }}
                </div>
                <div class="text-sm text-amber-700 dark:text-amber-300">Neutras (3)</div>
            </div>
            <div class="bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-900/20 dark:to-rose-800/20 rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-rose-600 dark:text-rose-400 mb-1">
                    {{ $reviewsStats['negativas'] }}
                </div>
                <div class="text-sm text-rose-700 dark:text-rose-300">Negativas (1-2)</div>
            </div>
        </div>

        {{-- Sort Options --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Comentários dos Clientes
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">
                    (Mostrando {{ $reviews->count() }} de {{ $totalReviews }})
                </span>
            </h3>
            <div class="flex items-center gap-3">
                <select class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="recent">Mais recentes</option>
                    <option value="helpful">Mais úteis</option>
                    <option value="highest">Maior avaliação</option>
                    <option value="lowest">Menor avaliação</option>
                </select>
            </div>
        </div>

        {{-- Reviews List --}}
        @if($reviews->count() > 0)
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-lg transition-all duration-300 review-card">
                        {{-- Review Header --}}
                        <div class="flex items-start gap-4 mb-4">
                            {{-- User Avatar --}}
                            @if($review->usuario && $review->usuario->avatar)
                                <img src="{{ Storage::url($review->usuario->avatar) }}" 
                                     alt="{{ $review->usuario->nome }}"
                                     class="w-12 h-12 rounded-full">
                            @else
                                <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 dark:text-blue-300"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <div class="flex items-center flex-wrap gap-2 mb-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $review->usuario ? $review->usuario->nome : 'Usuário Anônimo' }}
                                    </h4>
                                    @if($review->usuario && $review->usuario->verificado)
                                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs rounded flex items-center gap-1">
                                            <i class="fas fa-check-circle text-xs"></i>
                                            Verificado
                                        </span>
                                    @endif
                                    
                                    @if($review->usuario && $review->usuario->id_usuario === auth()->id())
                                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs rounded">
                                            Sua avaliação
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Review Content --}}
                        <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed whitespace-pre-line">
                            {{ $review->comentario }}
                        </p>
                        
                        {{-- Review Actions --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex items-center gap-4">
                                <button class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                                    <i class="far fa-thumbs-up"></i>
                                    Útil ({{ rand(0, 50) }})
                                </button>
                                <button class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                    <i class="far fa-thumbs-down"></i>
                                    ({{ rand(0, 10) }})
                                </button>
                            </div>
                            
                            <button class="text-sm text-gray-500 dark:text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                <i class="far fa-flag"></i>
                                Reportar
                            </button>
                        </div>
                    </div>
                @endforeach
                
                {{-- Load More Button --}}
                @if($totalReviews > 15)
                    <div class="text-center pt-6">
                        <button class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Carregar Mais Avaliações
                        </button>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-12">
                <div class="mb-6">
                    <i class="fas fa-star text-gray-300 dark:text-gray-600 text-6xl mb-4"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Nenhuma avaliação ainda
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    Seja o primeiro a compartilhar sua experiência com este produto e ajude outros clientes em sua decisão de compra.
                </p>
                @auth
                    <button 
                        @click="$wire.openReviewModal()"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-300 flex items-center gap-2 mx-auto hover:scale-[1.02]"
                    >
                        <i class="fas fa-star"></i>
                        Escrever Primeira Avaliação
                    </button>
                @else
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-4 inline-block">
                        <p class="text-amber-700 dark:text-amber-300 text-sm mb-3">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Faça login para escrever a primeira avaliação
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-sign-in-alt"></i>
                            Fazer Login
                        </a>
                    </div>
                @endauth
            </div>
        @endif
    </div>
</div>
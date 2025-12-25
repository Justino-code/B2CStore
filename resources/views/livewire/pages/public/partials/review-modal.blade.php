{{-- resources/views/livewire/pages/public/partials/review-modal.blade.php --}}
<div x-data="{ showReviewModal: @entangle('showReviewModal') }" x-cloak>
    <div x-show="showReviewModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Overlay --}}
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
                 @click="showReviewModal = false"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            {{-- Modal Content --}}
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="px-6 py-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Avaliar Produto
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $produto->nome }}
                            </p>
                        </div>
                        <button @click="showReviewModal = false" 
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    {{-- User Info --}}
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex items-center">
                            @if(auth()->user()?->avatar_url)
                                <img src="{{ image_url(auth()->user()?->avatar_url) }}" 
                                     alt="{{ auth()->user()?->nome }}"
                                     class="w-10 h-10 rounded-full mr-3">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 dark:text-blue-300"></i>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                    Avaliando como: <span class="font-semibold">{{ auth()->user()?->nome }}</span>
                                </p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">
                                    <i class="fas fa-envelope mr-1"></i>
                                    {{ auth()->user()?->email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="submitReview">
                        {{-- Rating --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Como você avalia este produto?
                            </label>
                            <div class="flex items-center justify-center space-x-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button 
                                        type="button"
                                        wire:click="$set('reviewRating', {{ $i }})"
                                        class="text-4xl {{ $i <= $reviewRating ? 'text-amber-400 hover:text-amber-500' : 'text-gray-300 dark:text-gray-600 hover:text-gray-400' }} transition-colors transform hover:scale-110"
                                        aria-label="Avaliar com {{ $i }} estrelas"
                                    >
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <div class="text-center mt-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    @switch($reviewRating)
                                        @case(1)
                                            ⭐ Péssimo
                                            @break
                                        @case(2)
                                            ⭐⭐ Ruim
                                            @break
                                        @case(3)
                                            ⭐⭐⭐ Regular
                                            @break
                                        @case(4)
                                            ⭐⭐⭐⭐ Bom
                                            @break
                                        @case(5)
                                            ⭐⭐⭐⭐⭐ Excelente
                                            @break
                                    @endswitch
                                </span>
                            </div>
                            @error('reviewRating') 
                                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Comment --}}
                        <div class="mb-6">
                            <label for="reviewComentario" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Seu comentário
                                <span class="text-gray-500 text-xs">(mínimo 10 caracteres)</span>
                            </label>
                            <textarea 
                                wire:model="reviewComentario"
                                id="reviewComentario"
                                rows="5"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                placeholder="Compartilhe sua experiência com este produto... O que você gostou? O que poderia melhorar? Sua opinião ajuda outros compradores."
                                aria-describedby="commentHelp"
                            ></textarea>
                            <div id="commentHelp" class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span>
                                    @if(strlen($reviewComentario) < 10)
                                        <span class="text-rose-600">Faltam {{ 10 - strlen($reviewComentario) }} caracteres</span>
                                    @else
                                        <span class="text-green-600">✓ Comentário válido</span>
                                    @endif
                                </span>
                                <span>{{ strlen($reviewComentario) }}/1000 caracteres</span>
                            </div>
                            @error('reviewComentario') 
                                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tips for good review --}}
                        <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                            <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300 mb-2 flex items-center">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Dicas para uma boa avaliação:
                            </h4>
                            <ul class="text-xs text-amber-700 dark:text-amber-400 space-y-1">
                                <li class="flex items-start">
                                    <i class="fas fa-check mr-2 mt-0.5 text-xs"></i>
                                    <span>Mencione a qualidade do produto</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check mr-2 mt-0.5 text-xs"></i>
                                    <span>Descreva sua experiência de uso</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check mr-2 mt-0.5 text-xs"></i>
                                    <span>Compare com suas expectativas</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Privacy Notice --}}
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Sua avaliação será revisada antes de ser publicada. Seu nome de usuário será exibido junto com o comentário.
                            </p>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button 
                                type="button"
                                @click="showReviewModal = false"
                                class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-300 flex items-center gap-2 hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                {{ strlen($reviewComentario) < 10 ? 'disabled' : '' }}
                            >
                                <span wire:loading.remove>
                                    <i class="fas fa-paper-plane"></i>
                                    Enviar Avaliação
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Enviando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
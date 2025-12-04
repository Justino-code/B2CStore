{{-- resources/views/home.blade.php --}}
<x-layouts.public>
    <!-- Página Home -->
    <section class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">
        <h1 class="text-4xl font-bold mb-4">Bem-vindo à B2CStore</h1>
        <p class="text-lg mb-6">
            Esta é a página inicial usando o layout moderno com <code>{{ '$slot' }}</code>.
        </p>

        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Botão de Teste Toast -->
            <button
                onclick="Notyf.success('Notificação de teste no tema atual!')"
                class="px-6 py-3 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition-colors">
                Testar Notificação
            </button>

            <!-- Botão de Teste Confirm -->
            <button
                onclick="Swal.fire({
                    title: 'Você quer continuar?',
                    text: 'Este é um teste de confirmação com tema adaptável.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if(result.isConfirmed){
                        Notyf.success('Confirmado no tema atual!');
                    }
                })"
                class="px-6 py-3 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                Testar Confirm
            </button>

            <!-- Botão para testar outros tipos -->
            <button
                onclick="Notyf.error('Erro no tema atual!')"
                class="px-6 py-3 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                Testar Erro
            </button>
        </div>

        <div class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Instruções:</h2>
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                <li>• Clique no botão de dark/light mode na navbar para alternar temas</li>
                <li>• As notificações e modais seguirão automaticamente o tema atual</li>
                <li>• Teste alternando o tema e abrindo novas notificações</li>
                <li>• Cada nova notificação será estilizada de acordo com o tema ativo</li>
            </ul>
        </div>
    </section>
</x-layouts.public>

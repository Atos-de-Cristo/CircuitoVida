@props(['id' => null, 'maxWidth' => null, 'closeModal'=>null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <!-- Cabeçalho do modal -->
    <div class="relative">
        <!-- Botão de fechar o modal -->
        <div class="absolute p-2 top-2 right-2">
            <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" wire:click.prevent="{{$closeModal}}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6">
                    <path fill-rule="evenodd" d="M13.414 6l3.293-3.293a1 1 0 0 0-1.414-1.414L12 4.586 8.707 1.293A1 1 0 0 0 7.293 2.707L10.586 6l-3.293 3.293a1 1 0 1 0 1.414 1.414L12 7.414l3.293 3.293a1 1 0 0 0 1.414-1.414L13.414 6z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Título do modal -->
        <div class="text-lg font-medium p-2  bg-gray-100 dark:bg-gray-800 text-center text-gray-900 dark:text-gray-100">
            {{ $title }}
        </div>

        <!-- Conteúdo do modal -->
        <div class="overflow-auto ">
        <div class="px-6 py-4">
            <div class="mt-4 text-sm  text-gray-600 dark:text-gray-400">
                {{ $content }}
            </div>
        </div>
    </div>
        <!-- Rodapé do modal -->
        <div class="flex flex-row px-6 py-4 bg-gray-100 dark:bg-gray-800 rounded dark:text-white sm:flex sm:flex-row-reverse">
            {{ $footer }}
        </div>
    </div>
</x-modal>

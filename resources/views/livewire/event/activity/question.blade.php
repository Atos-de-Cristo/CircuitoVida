<div>
    <form class="">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="mb-4">
                <label class="block">Tipo:</label>
                <div class="flex items-center">
                    <label class="mr-4">
                        <input wire:model="type" type="radio" value="aberta" class="mr-1">
                        <span class="text-sm">Aberto</span>
                    </label>
                    <label>
                        <input wire:model="type" type="radio" value="multi" class="mr-1">
                        <span class="text-sm">Múltipla Escolha</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="title" class="block">Título:</label>
                <input wire:model="title" type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded">
            </div>

            @if($type === 'multi')
                <div class="mb-4">
                    <label class="block">Opções:</label>
                    @foreach($options as $index => $option)
                        <div class="flex items-center mb-2">
                            <input wire:model="options.{{ $index }}.text" type="text" class="w-full px-4 py-2 border border-gray-300 rounded">
                                <label class="ml-2">
                                    <input wire:model="options.{{ $index }}.correct" type="checkbox" class="mr-1">
                                    <span class="text-sm">Correta</span>
                                </label>
                            <button type="button" wire:click="removeOption({{ $index }})" class="ml-2 px-4 py-2 bg-red-500 text-white rounded">Remover</button>
                        </div>
                    @endforeach
                    <button type="button" wire:click="addOption" class="px-4 py-2 bg-green-500 text-white rounded">Adicionar Opção</button>
                </div>
            @endif
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click.prevent="store()" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Salvar
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="close()" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Fechar
                </button>
            </span>
        </div>
    </form>
</div>

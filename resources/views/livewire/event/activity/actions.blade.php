<div>
    @empty($activityId)
        <button wire:click.prevent="$set('isOpenActivity', true)" class="btn-primary text-xs ml-2">
            <x-svg.add size="w-4 h-4" color="text-white" />
        </button>
    @else
        <button wire:click.prevent="$set('isOpenActivity', true)" class="mr-2">
            <x-svg.edit />
        </button>
        <button wire:click.prevent="dellActivity()">
            <x-svg.delete />
        </button>
    @endempty

    @if ($isOpenActivity)
        <div class="fixed z-40 inset-0 overflow-y-auto ease-out duration-400">
            <div class="flex items-end justify-start min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

                <div class="fixed inset-0 flex flex-col items-center justify-start z-50 mt-8">
                    <div class="bg-white  rounded shadow-lg top-0 sm:max-w-lg sm:w-full">

                        <form>
                            <div class="bg-gray-50 text-center rounded">
                                <h2 class="text-lg text-gray-800 font-bold p-2 mb-4">Adicionar Atividade</h2>
                            </div>
                            <div class="px-4 pt-2 pb-4 sm:p-6 sm:pb-4 text-left">
                                <div class="md:flex">
                                    <div class="md:w-1/2 p-1">
                                        <div class="mb-4">
                                            <label for="campTitle"
                                                class="block text-gray-700 text-sm font-bold mb-2">Titulo:</label>
                                            <input type="text" wire:model="title" id="campTitle"
                                                placeholder="Entre com o titulo"
                                                class="shadow appearance-none border rounded w-full sm:w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            @error('title')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="campDescription"
                                                class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                                            <textarea
                                                class="shadow appearance-none border rounded w-full sm:w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="campDescription" wire:model="description" placeholder="Informe a descrição" rows="5"></textarea>
                                            @error('description')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 rounded sm:flex sm:flex-row-reverse">
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button wire:click="store()" type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Salvar
                                    </button>
                                </span>
                                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                    <button wire:click="$set('isOpenActivity', false)" type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Fechar
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

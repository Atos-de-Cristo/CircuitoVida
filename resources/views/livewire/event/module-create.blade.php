
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
        <div class="bg-gray-50 text-center rounded-md">
            <h2 class="text-lg text-gray-800 font-bold p-2 mb-2">Adicionar Módulo</h2>
        </div>
                <div class="px-4  pb-4 sm:p-6 sm:pb-4 text-left">
                    <div class="md:flex">
                        <div class="md:w-1/2 p-1">
                            <div class="mb-4">
                                <label for="campName" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                                <input type="text"
                                    class="shadow appearance-none border rounded w-full sm:w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="campName" placeholder="Entre com um nome" wire:model="nameModule">
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 rounded sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button
                            wire:click.prevent="storeModule()"
                            type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        >
                            Save
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button
                            wire:click="closeModalModule()"
                            type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        >
                            Cancel
                        </button>
                    </span>
                </div>

            </form>

            </div>
        </div>
    </div>
</div>

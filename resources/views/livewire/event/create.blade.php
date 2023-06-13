<x-dialog-modal id="myModal" maxWidth="2xl" closeModal="closeModal()">
    <x-slot name="title">
        Adicionar Evento
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="md:flex">
                <div class="md:w-1/2 p-1">
                    <div class="mb-4">
                        <label for="campType"
                            class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tipo</label>
                        <select id="campType" wire:model="type"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione o tipo</option>
                            @foreach ($typesList as $type)
                                <option value="{{ $type->name }}">{{ $type->value }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="campName"
                            class="block  text-gray-700 dark:text-gray-300  text-sm font-bold mb-2">Nome:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campName" placeholder="Entre com um nome" wire:model.lazy="name">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campDataStart" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Data
                            Início</label>
                        <input type="datetime-local"
                            class="shadow appearance-none border rounded w-full py-2 px-3text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campDataStart" placeholder="Informe a data de início" wire:model.lazy="start_date">
                        @error('start_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campDataEnd" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Data
                            Término:</label>
                        <input type="datetime-local"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campDataEnd" placeholder="Informe a data de término" wire:model.lazy="end_date">
                        @error('end_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campLocal" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Local:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campLocal" placeholder="Informe o local" wire:model.lazy="local">
                        @error('local')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campImg" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imagem</label>
                        <input type="file" wire:model="newImage" class="text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                        @error('newImage')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        @error('image')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        @if ($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" alt="Nova Imagem Selecionada"
                                class="mt-2 w-32 h-auto">
                        @elseif ($image != '')
                            <img src="{{ asset($image) }}" alt="Imagem Atual" class="mt-2 w-32 h-auto">
                        @endif
                    </div>
                </div>
                <div class="md:w-1/2 p-1">
                    <div class="mb-4">
                        <label for="campTickets" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Vagas:</label>
                        <input type="number"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campTickets" placeholder="Limite de vagas" wire:model.lazy="tickets_limit">
                        @error('tickets_limit')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="campValue" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Valor:</label>
                        <input type="number"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campValue" placeholder="Informe o valor" wire:model.lazy="value">
                        @error('value')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="campDescription"
                            class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Descrição:</label>
                        <textarea
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline"
                            id="campDescription" wire:model.lazy="description" placeholder="Informe a descrição" rows="5"></textarea>
                        @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="countries" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Status</label>
                        <select id="countries" wire:model="status"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione o status</option>
                            @foreach ($statusList as $status)
                                <option value="{{ $status->name }}">{{ $status->value }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button wire:click.prevent="store()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Save
            </button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

            <button wire:click.prevent="closeModal()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Cancel
            </button>
        </span>
    </x-slot>
</x-dialog-modal>

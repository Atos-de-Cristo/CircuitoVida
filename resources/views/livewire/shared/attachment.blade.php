<div>
    @empty($attachmentId)
        <button wire:click.prevent="$set('isOpenAttachment', true)" class="btn-primary text-xs ml-2">
         <x-svg.uploud size="w-4 h-4"/>
        </button>
    @else
        <button wire:click.prevent="$set('isOpenAttachment', true)" class="mr-2">
            <x-svg.edit/>
        </button>
        <button wire:click.prevent="dellAttachment()">
            <x-svg.delete/>
        </button>
    @endempty

    @if ($isOpenAttachment)
    <x-dialog-modal id="myModal" maxWidth="xl" closeModal="$set('isOpenAttachment', false)">
        <x-slot name="title">
            @if (!empty($attachmentId))
            Atualizar Material
            @else
            Adicionar Material
            @endif
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="md:flex">
                    <div class="md:w-1/2 p-1">
                    <div class="mb-4">
                        <label for="campName" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nome:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline" id="campName" placeholder="Entre com o nome" wire:model.lazy="name">
                        @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror


                    </div>
                    @empty($attachmentId)

                    <div class="mb-4">
                        <label for="campImg" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Anexo</label>
                        <input type="file" wire:model="attachment">
                        @error('attachment')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                @endempty
                    </div>
                </div>
            </form>

        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="store()" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    @if (!empty($attachmentId))
                    Atualizar
                    @else
                    Salvar
                    @endif
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenActivity', false)" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>

    @endif
</div>

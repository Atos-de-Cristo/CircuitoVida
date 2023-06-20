<div>
    @if ($categoryId)
        <button wire:click.prevent="$set('isOpen', true)" class="mr-2">
            <x-svg.edit />
        </button>
        <button wire:click="del()" class="mr-2">
            <x-svg.delete />
        </button>
    @else
        <button wire:click.prevent="$set('isOpen', true)" class="btn-primary" >
            <x-svg.add size="h-6 w-6"/>
            <span>Categoria</span>
        </button>
    @endif

    @if ($isOpen)
        <x-dialog-modal id="myModal" maxWidth="lg" closeModal="$set('isOpen', false)">
            <x-slot name="title">
                @if (!empty($categoryId))
                    Atualizar Categoria
                @else
                    Adicionar Categoria
                @endif
            </x-slot>

            <x-slot name="content">
                <form>
                    <div class="flex flex-col">

                        <div class="mb-4">
                            <label for="campName" class="label-input-form">Nome:</label>
                            <input
                                type="text"
                                id="campName"
                                class="input-form"
                                wire:model.lazy="name"
                                placeholder="Entre com o nome da categoria"
                            >
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="store()" type="button" class="btn-submit">
                        @if (!empty($categoryId))
                            Atualizar
                        @else
                            Salvar
                        @endif
                    </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpen', false)" type="button" class="btn-default">
                        Cancelar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

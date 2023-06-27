<x-dialog-modal id="isOpenModule" wire:model="isOpenModule" maxWidth="lg" closeModal="closeModalModule()">
    <x-slot name="title">
        @if (!empty($module_id))
        Atualizar Módulo
        @else
        Adicionar Módulo
        @endif
    </x-slot>

    <x-slot name="content">

        <form>
            <div class="flex flex-col">
                <div class="mb-4">
                    <label for="campName" class="label-input-form">Nome:</label>
                    <input type="text" class="input-form " id="campName" placeholder="Entre com um nome"
                        wire:model.lazy="nameModule">
                    @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button wire:click.prevent="storeModule()" type="button" class="btn-submit">
                @if (!empty($module_id))
                Atualizar
                @else
                Salvar
                @endif
            </button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button wire:click="closeModalModule()" type="button" class="btn-default">
                Cancelar
            </button>
        </span>
    </x-slot>
</x-dialog-modal>

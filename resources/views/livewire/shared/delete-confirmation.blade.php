<div>
    <button wire:click.prevent="openModal()" class="hover:scale-125">
        <x-icon-trash class="w-5 h-5" />
    </button>
    @if ($isOpenDelete)
    <x-dialog-modal id="isOpenActivity" wire:model="isOpenDelete" maxWidth="sm" closeModal="closeModal()">
        <x-slot name="title">
            Confirmar
        </x-slot>

        <x-slot name="content">
            Tem certeza de que quer deletar esse item?
        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="delete()" type="button" class="btn-submit">
                    Confirmar    
                </button>
            </span>
            <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenDelete', false)" type  class="btn-default">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>

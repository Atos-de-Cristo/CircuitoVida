<div>
    @empty($attachmentId)
    <button wire:click.prevent="$set('isOpenAttachment', true)" class="btn-primary text-xs ml-2">
        <x-icon-cloud-arrow-up  />
    </button>
    @else
    <button wire:click.prevent="$set('isOpenAttachment', true)" class="mr-2 hover:scale-110">
        <x-icon-pencil class="w-5 h-5" />
    </button>
    <button wire:click.prevent="dellAttachment()" class="hover:scale-110">
        <x-icon-trash class="w-5 h-5" />
    </button>
    @endempty

    @if ($isOpenAttachment)
    <x-dialog-modal id="isOpenAttachment" wire:model="isOpenAttachment" maxWidth="xl" closeModal="$set('isOpenAttachment', false)">
        <x-slot name="title">
            @if (!empty($attachmentId))
            Atualizar Material
            @else
            Adicionar Material
            @endif
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label for="campName" class="label-input-form">Nome:</label>
                        <input type="text" class="input-form" id="campName" placeholder="Entre com o nome"
                            wire:model.lazy="name">
                        @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @empty($attachmentId)
                    <div class="mb-4">
                        <label for="campImg" class="label-input-form">Anexo</label>
                        <input type="file" wire:model="attachment">
                        @error('attachment')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @endempty

                </div>
            </form>

        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="store()" type="button" class="btn-submit">
                    @if (!empty($attachmentId))
                        Atualizar
                    @else
                        Salvar
                    @endif
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenAttachment', false)" type="button" class="btn-default">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>

    @endif
</div>

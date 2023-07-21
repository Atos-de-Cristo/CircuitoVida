<div>
    @empty($activityId)
    <button wire:click.prevent="$set('isOpenActivity', true)" class="btn-primary text-xs ml-2">
        <x-icon-plus  />
    </button>
    @else
    <button wire:click.prevent="$set('isOpenActivity', true)" class="mr-2 hover:scale-110">
        <x-icon-pencil class="w-5 h-5" />
    </button>
    <button wire:click.prevent="dellActivity()"class="hover:scale-110">
        <x-icon-trash class="w-5 h-5" />
    </button>
    @endempty

    @if ($isOpenActivity)
    <x-dialog-modal id="isOpenActivity" wire:model="isOpenActivity" maxWidth="lg" closeModal="$set('isOpenActivity', false)">
        <x-slot name="title">
            @if (!empty($activityId))
            Atualizar Atividade
            @else
            Adicionar Atividade
            @endif
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="flex flex-col">

                    <div class="mb-4">
                        <label for="campTitle" class="label-input-form">Titulo:</label>
                        <input type="text" wire:model.lazy="title" id="campTitle" placeholder="Entre com o titulo"
                            class="input-form">
                        @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="campDescription" class="label-input-form">Descrição:</label>
                        <textarea class="input-form" id="campDescription" wire:model.lazy="description"
                            placeholder="Informe a descrição" rows="5"></textarea>
                        @error('description')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
            </form>

        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="store()" type="button" class="btn-submit">
                    @if (!empty($activityId))
                    Atualizar
                    @else
                    Salvar
                    @endif
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenActivity', false)" type="button" class="btn-default">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>

    @endif
</div>

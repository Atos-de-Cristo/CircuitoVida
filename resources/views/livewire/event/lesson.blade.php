<div>
    @if ($lessonId)
        <div class="flex gap-2">
            <button wire:click.prevent="$set('isOpenLesson', true)">
                <x-icon-pencil class="w-5 h-5" />
            </button>
            <button wire:click.prevent="dellLesson()">
                <x-icon-trash class="w-5 h-5" />
            </button>
        </div>
    @else
        <button wire:click.prevent="$set('isOpenLesson', true)"
            class="btn-primary text-xs flex items-center">
            <div class="flex items-center justify-center">
                <x-icon-plus class="w-4 h-4" />
                <span class="ml-1">Aula</span>
            </div>
        </button>
    @endif
    @if ($isOpenLesson)
    <x-dialog-modal id="isOpenLesson" wire:model="isOpenLesson" maxWidth="lg" closeModal="$set('isOpenLesson', false)">
        <x-slot name="title">
            @if (!empty($lessonId))
            Atualizar Aula
            @else
            Adicionar Aula
            @endif
        </x-slot>
        <x-slot name="content">
            <form>
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label for="campTitle" class="label-input-form">Tema:</label>
                        <input type="text"  class="input-form" id="campTitle" placeholder="Entre com um nome" wire:model="title">
                        @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="campDescription" class="label-input-form">Descrição:</label>
                        <textarea class="input-form" id="campDescription" wire:model="description" placeholder="Informe a descrição" rows="5"></textarea>
                        @error('description')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="campTitle" class="label-input-form">Video:</label>
                        <input
                            type="text"
                            wire:model="video"
                            class="input-form"
                            id="campTitle"
                            placeholder="Entre com o ID do youtube"
                        >
                        @error('video')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="campDataStart" class="label-input-form">Data Inicio</label>
                        <input
                            type="datetime-local"
                            class="input-form"
                            id="campDataStart"
                            placeholder="Informe a data de início"
                            wire:model.lazy="start_date"
                        >
                        @error('start_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="campDataEnd" class="label-input-form">Data Fim</label>
                        <input
                            type="datetime-local"
                            class="input-form"
                            id="campDataEnd"
                            placeholder="Informe a data de fim"
                            wire:model.lazy="end_date"
                        >
                        @error('end_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click.prevent="store()" type="button"
                    class="btn-submit">
                    @if (!empty($lessonId))
                    Atualizar
                    @else
                    Salvar
                    @endif
                </button>
            </span>
            <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenLesson', false)" type="button"
                    class="btn-default">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>

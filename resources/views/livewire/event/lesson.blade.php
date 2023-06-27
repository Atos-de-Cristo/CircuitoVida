
<x-dialog-modal id="isOpenLesson" wire:model="isOpenLesson" maxWidth="lg" closeModal="closeModal()">
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
                    <input type="text"  class="input-form" id="campTitle" placeholder="Entre com um nome" wire:model.lazy="title">
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
                    <label for="campDataEnd" class="label-input-form">Data Inicio</label>
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
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button wire:click="closeModal()" type="button"
                class="btn-default">
                Cancelar
            </button>
        </span>
    </x-slot>
</x-dialog-modal>

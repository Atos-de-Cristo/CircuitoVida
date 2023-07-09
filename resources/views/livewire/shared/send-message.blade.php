<div>
    @if ($isOpenMessage)
        <x-dialog-modal id="isOpenMessage" wire:model="isOpenMessage" maxWidth="xl" closeModal="$set('isOpenMessage', false)">
            <x-slot name="title">
                Enviar Mensagem
            </x-slot>

            <x-slot name="content">
                <form>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label for="campMessage" class="label-input-form">Para:</label>
                            @if ($forUser)
                                {{ $forUser->name }}
                            @endif
                            @if ($forEvent)
                                {{ $forEvent->name }} ({{$forEvent->inscriptions->count()}} inscrições)
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label for="campMessage" class="label-input-form">Mensagem:</label>
                            <textarea
                                type="text"
                                class="input-form"
                                id="campMessage"
                                placeholder="Entre com uma mensagem"
                                wire:model.lazy="message"
                            ></textarea>
                            @error('message')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="send()" type="button" class="btn-submit">
                        Enviar
                    </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpenMessage', false)" type="button" class="btn-default">
                        Cancelar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

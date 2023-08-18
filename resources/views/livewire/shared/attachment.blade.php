<div>
    @if (session()->has('message'))
        @foreach (session('message') as $messagem)
            <x-alert-message :message='$messagem' :messageType="session('message')" />
        @endforeach
    @endif

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
                            wire:model.lazy="form.name">
                        @error('form.name')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @empty($attachmentId)
                    <div class="mb-4">
                        <label for="campImg" class="label-input-form">Anexo</label>
                        <input type="file" wire:model="attachment">
                        @error('form.attachment')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @endempty
                    <div class="mb-4">
                        <label class="relative inline-flex items-center mr-5 cursor-pointer">
                            <input type="checkbox" class="sr-only peer" wire:model.prevent="form.after_class">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{(isset($this->form['after_class']) && $this->form['after_class']) ? 'Pós Aula' : 'Liberado'}}
                            </span>
                        </label>
                        @error('form.after_class')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
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
            <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenAttachment', false)" type="button" class="btn-default">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>

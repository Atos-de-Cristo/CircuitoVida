

<div>
    <div class="mt-2 sm:mt-0 flex space-x-2">
        <button wire:click.prevent="$set('isOpenFrequency', true)" class="btn-primary">
            <x-svg.checklist size="w-4 h-4" />
            <span class="ml-2">Fequência</span>
        </button>
    </div>
    @if ($isOpenFrequency)
    <x-dialog-modal id="myModal" wire:model="isOpenFrequency" maxWidth="lg" closeModal="$set('isOpenFrequency', false)">
        <x-slot name="title">
         Frequência Aula
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="max-h-96 bg-gray-50 dark:bg-slate-800">
                    <div class="flex flex-col w-full">
                        @foreach($inscriptions as $item)
                        <div class="flex items-center justify-between border-b px-2 py-2">
                            <img class="w-8 h-8 bg-black rounded-full mr-2"
                            src="{{ asset($item->user->profile_photo_url) }}" width="32" height="32"
                            alt="{{ $item->user->name }}" />
                            <div class="w-2/3">{{ $item->user->name }}</div>
                            <div class="w-1/3">
                                @if ($item->frequencies->where('user_id', $item->user->id)->where('lesson_id', $lessonId)->count() >= 1)
                                    Presente!
                                @else
                                    <input
                                        id="freq-{{ $item->user->id }}"
                                        type="checkbox"
                                        value="{{ $item }}"
                                        wire:model.lazy="users"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    >
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>

        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="storeFrequency()" type="button" class="btn-submit">
                    Salvar
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenFrequency', false)" type="button" class="btn-default">
                    Cancelar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>


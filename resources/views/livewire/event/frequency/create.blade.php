

<div>
    <div class="mt-2 sm:mt-0 flex space-x-2">
        <button wire:click.prevent="$set('isOpenFrequency', true)" class="btn-primary">
            <x-icon-check class="w-4 h-4" />
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
                <div class="max-h-96 bg-gray-50">
                    <div class="flex flex-col w-full dark:bg-slate-800">
                        @foreach($inscriptions as $item)
                        @php
                            $isPresent = $item->frequencies->where('user_id', $item->user->id)->where('lesson_id', $lessonId)->where('is_present', true)->count() >= 1;
                            $loadingKey = $item->user->id . '_' . $lessonId;
                        @endphp
                        <div class="flex items-center justify-between border-b px-2 py-2">
                            @isset($item->user->profile_photo_url)
                                <img class="w-8 h-8 bg-black rounded-full mr-2"
                                    src="{{ asset($item->user->profile_photo_url) }}" width="32" height="32"
                                    alt="Foto Perfil"
                                />
                            @endisset
                            @isset($item->user->name)
                                <div class="flex-1">{{ $item->user->name }}</div>
                            @endisset
                            @isset($item->user->id)
                                <div class="mr-2">
                                    <div wire:loading wire:target="toggleFrequency('{{ $item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}')">
                                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        wire:loading.attr="disabled"
                                        wire:loading.remove wire:target="toggleFrequency('{{$item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}')"
                                        id="freq-{{ $item->user->id }}"
                                        type="checkbox"
                                        value="{{ $item }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        wire:click="toggleFrequency('{{ $item->user->id }}', '{{ $lessonId }}', '{{ $item->id }}')"
                                        @if($isPresent) checked @endif
                                    >
                                </div>
                            @endisset
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>

        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="$set('isOpenFrequency', false)" type="button" class="btn-default">
                    Fechar
                </button>
            </span>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>


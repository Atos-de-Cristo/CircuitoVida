<div class="flex flex-col items-end">
    @can('admin')
        <button wire:click.prevent="$set('isOpen', true)" class="btn-primary mb-2" >
            <x-icon-plus/>
            <span class="ml-1">Inscrição</span>
        </button>
    @endCan
    @forelse ($this->user->inscriptions as $inscription)
        <a
            href="{{ route('eventManager', $inscription->event->id) }}"
            class="w-full mb-4 flex flex-col bg-white dark:bg-slate-800 rounded-md sm:flex-row justify-start"
        >
            <div  class="sm:w-40 w-full rouded-l-md">
                <img src="{{ asset(!empty($inscription->event->image) ? $inscription->event->image : 'images/curso.png') }}"
                    alt="{{ $inscription->name }}"
                    class="hover:scale-105  object-cover h-32 w-full sm:rounded-l-md rounded-t-md">
            </div>

            <div class=" p-3 ">
                <h2 class="hover:scale-105 font-bold text-xl">{{ $inscription->event->name }}</h2>
                <p class="nome">Status: {{getStatusInscription($inscription->status) }}</p>
                <div class="tags">
                    <div class="flex flex-row justify-center items-center gap-3">
                        <p class="status information text-sm font-semibold">Atividades:</p>
                        <div class="w-full sm:w-64 bg-gray-200 rounded-full dark:bg-gray-700">
                            <div
                                class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                style="width: {{ $this->activity[$inscription->event_id]['responseCount'] && $this->activity[$inscription->event_id]['activityCount'] ? ($this->activity[$inscription->event_id]['responseCount'] / $this->activity[$inscription->event_id]['activityCount'] * 100) : 0 }}%"
                                >
                                    {{
                                        ($this->activity[$inscription->event_id]['responseCount'] && $this->activity[$inscription->event_id]['activityCount'])
                                        ? number_format(($this->activity[$inscription->event_id]['responseCount'] / $this->activity[$inscription->event_id]['activityCount'] * 100), 2, '.', '')
                                        : 0
                                    }}%
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row justify-center items-center gap-3">
                        <p class="status information text-sm font-semibold">Frequência:</p>
                        <div class="w-full sm:w-64 bg-gray-200 rounded-full dark:bg-gray-700">
                            <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                style="width: {{ $inscription->frequencies->count() / $inscription->event->lessons->count() * 100  }}%">
                                {{round ($inscription->frequencies->count() / $inscription->event->lessons->count() * 100 ) }}%
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-2">
                    @can('admin')
                        <button wire:click.prevent="initTransfer({{$inscription->event->id}})" class="btn-primary mb-2" >
                            <x-icon-plus/>
                            <span class="ml-1">Transferência</span>
                        </button>
                    @endCan
                </div>
            </div>
        </a>
    @empty
        <span class="text-red-500">Nenhuma inscrição encontrada</span>
    @endforelse
    @if ($isOpen)
        <x-dialog-modal id="isOpen" wire:model="isOpen" maxWidth="lg" closeModal="$set('isOpen', false)">
            <x-slot name="title">Adicionar Inscrição</x-slot>

            <x-slot name="content">
                <form>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label for="campName" class="label-input-form">Nome:</label>
                            <select
                                wire:model.defer="courseId"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                                <option value="">Selecione</option>
                                @foreach ($this->eventList as $event)
                                    @if ($this->user->inscriptions->pluck('event_id')->search($event->id) !== 0)
                                        <option value="{{$event->id}}">{{$event->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="store()" type="button" class="btn-submit">Salvar</button>
                </span>
                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpen', false)" type="button" class="btn-default">
                        Cancelar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
    @if ($isOpenTransf)
        <x-dialog-modal id="isOpenTransf" wire:model="isOpenTransf" maxWidth="lg" closeModal="$set('isOpenTransf', false)">
            <x-slot name="title">Transferir Curso</x-slot>

            <x-slot name="content">
                <form>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label for="campName" class="label-input-form">Novo Curso:</label>
                            <select
                                wire:model.defer="transferCourseId"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                                <option value="">Selecione</option>
                                @foreach ($this->eventList as $event)
                                    @if ($this->user->inscriptions->pluck('event_id')->search($event->id) !== 0)
                                        <option value="{{$event->id}}">{{$event->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </x-slot>
            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="transfer()" type="button" class="btn-submit">Transferir</button>
                </span>
                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpenTransf', false)" type="button" class="btn-default">
                        Cancelar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

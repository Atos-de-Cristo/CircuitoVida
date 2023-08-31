<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="sm:col-span-2 md:col-span-1">
        <div
            class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md   mt-2 mb-4  ">
            <div class="dark:bg-gradient-to-r from-indigo-900 to-indigo-600 h-16 rounded-t-lg p-2">
                <div class="  bg-slate-700 w-20 h-20 rounded-full flex items-center justify-center">
                    <div class="w-16 h-16 flex  border-2 border-white rounded-full overflow-hidden">
                        <img
                            src="{{ asset($this->user->profile_photo_url) }}"
                            alt="{{ $this->user->name }}"
                            class="object-cover h-full w-full cursor-pointer"
                        >
                    </div>
                </div>
            </div>
            <div class="px-4 py-2">
                <h1 class="text-xl font-bold mt-5 sm:mb-0">{{ $this->user->name }}</h1>
                <p class="">{{ $this->user->email }}</p>
            </div>
        </div>
        <div class="">
            <livewire:profile :userId="$this->user->id" />
        </div>
    </div>
    <div class="sm:col-span-2 md:col-span-2">
        <div
            class="overflow-hidden bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 shadow-xl rounded-md mt-2">
            <div class="bg-slate-50 dark:bg-slate-800">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium">
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'curso')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'curso' ? 'border-b-2 dark:border-indigo-800' : '' }}">Cursos</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'atividades')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'atividades' ? 'border-b-2 dark:border-indigo-800' : '' }}">Atividades</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'anexos')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'anexos' ? 'border-b-2 dark:border-indigo-800' : '' }}">Anexos</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button wire:click="$set('tab', 'message')"
                            class="inline-block rounded-t-lg p-4 {{ $tab === 'message' ? 'border-b-2 dark:border-indigo-800' : '' }}">Messagens</button>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col  gap-2 p-5 ">
                @if ($tab == 'curso')
                @forelse ($this->user->inscriptions as $inscription)
                <a
                    href="{{ route('eventManager', $inscription->event->id) }}"
                    class="flex flex-col bg-white dark:bg-slate-800 rounded-md sm:flex-row justify-start"
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
                            <div class="flex flex-row justify-center items-center gap-2">
                                <p class="status information text-sm font-semibold">Atividades:</p>
                                <div class="w-full sm:w-64 bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                        style="width: {{ $this->activity[$inscription->event_id]['responseCount'] && $this->activity[$inscription->event_id]['activityCount'] ? ($this->activity[$inscription->event_id]['responseCount'] / $this->activity[$inscription->event_id]['activityCount'] * 100) : 0 }}%"> {{ $this->activity[$inscription->event_id]['responseCount'] &&
                                        $this->activity[$inscription->event_id]['activityCount'] ?
                                        ($this->activity[$inscription->event_id]['responseCount'] /
                                        $this->activity[$inscription->event_id]['activityCount'] * 100) : 0 }}%
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row justify-center items-center gap-2">
                                <p class="status information text-sm font-semibold">Frequência:</p>
                                <div class="w-full sm:w-64 bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                        style="width: {{ $inscription->frequencies->count() / $inscription->event->lessons->count() * 100  }}%">
                                        {{round ($inscription->frequencies->count() / $inscription->event->lessons->count() * 100 ) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                @empty
                <span class="text-red-500">Nenhuma inscrição encontrada</span>
                @endforelse
                @endif
                @if ($tab === 'atividades')
                <div class="">
                    <livewire:user-activity :user="$this->user->id" :key="rand()" />
                </div>
                @endif
                @if ($tab === 'anexos')
                <div class="px-5 py-5">
                    <livewire:user-attachments :user="$this->user->id" :key="rand()" />
                </div>
                @endif
                @if ($tab === 'message')
                <div class="px-5 py-5 w-full">
                    <livewire:user-message :user="$this->user->id" :key="rand()" />
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

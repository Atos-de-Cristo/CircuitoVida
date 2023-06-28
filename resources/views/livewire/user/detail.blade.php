<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

    <div class="sm:col-span-2 md:col-span-1 ">
        <div class="card-white border-t-2 dark:border-indigo-900">
            <div class="w-32 h-32 flex items-center rounded-full overflow-hidden mx-auto">
                <img src="{{ asset($this->user->profile_photo_url) }}" alt="{{ $this->user->name }}"
                    class="object-cover h-full w-full cursor-pointer">
            </div>
            <h1 class="text-xl font-bold text-center mt-5 mb-4 sm:mb-0">{{ $this->user->name }}</h1>
            <p class="text-center">{{ $this->user->email }}</p>
        </div>
    </div>
    <div class="sm:col-span-2 md:col-span-2">
        <div class="card-white">
            <h1 class="text-xl font-bold text-center mb-4 sm:mb-0">Cursos</h1>
            <div class="flex flex-wrap m-0  rounded">
                @forelse ($this->user->inscriptions as $inscription)
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg flex flex-col h-full">
                        <div class="flex-grow  flex flex-col items-center justify-center">
                           <a href="{{route('eventManager',$inscription->event->id)}}"><img src="{{ asset(!empty($inscription->event->image) ? $inscription->event->image : 'images/curso.png') }}"
                            alt="{{ $inscription->name }}" class="hover:scale-105 h-52 w-full bg-slate-500 ">
                            </a>
                        </div>
                        <div class="flex-grow p-4 flex flex-col justify-between">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $inscription->event->name }}</h3>
                                <p class="text-sm text-gray-500">Status: {{ getStatusInscription($inscription->status)
                                    }}</p>
                                <p class="text-sm text-gray-500">Atividades: {{ $this->activity[$inscription->event_id]
                                    }}</p>
                                <div class="relative">
                                    <div class="mb-2">
                                        <span class="text-gray-500 text-xs">Atividades:</span>
                                    </div>
                                    <div class="overflow-hidden h-4 text-xs flex bg-indigo-200 rounded">
                                        <div style="width: {{ is_numeric($this->activity[$inscription->event_id]) && is_numeric($inscription->event->lessons->count()) ? ($this->activity[$inscription->event_id] / $inscription->event->lessons->count() * 100) : 0 }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap justify-center {{ $this->activity[$inscription->event_id] == $inscription->event->lessons->count() ? 'bg-green-500' : 'bg-indigo-500' }}">
                                        </div>
                                    </div>
                                    <span
                                        class="absolute right-0 top-1/2 transform -translate-y-1/2 pr-2 text-sm text-gray-500">{{
                                        $this->activity[$inscription->event_id] }}</span>
                                </div>
                                <div class="relative">
                                    <div class="mb-2">
                                        <span class="text-gray-500 text-xs">Frequência:</span>
                                    </div>
                                    <div class="overflow-hidden h-4 text-xs flex bg-indigo-200 rounded">
                                        <div style="width: {{ $inscription->frequencies->count() / $inscription->event->lessons->count() * 100 }}%"
                                            class="shadow-none flex flex-col text-center
                                             whitespace-nowrap justify-center {{ $inscription->frequencies->count() == $inscription->event->lessons->count() ? 'bg-green-500' : 'bg-indigo-500' }}">
                                        </div>
                                    </div>
                                    <span
                                        class="absolute right-0 top-1/2 transform -translate-y-1/2 pr-2 text-sm text-gray-500">{{
                                        $inscription->frequencies->count() }} / {{ $inscription->event->lessons->count()
                                        }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @empty
                <span class="text-red-500">Nenhuma inscrição encontrada</span>
                @endforelse
            </div>
        </div>
    </div>

</div>

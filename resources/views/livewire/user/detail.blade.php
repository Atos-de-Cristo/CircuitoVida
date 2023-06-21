<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

    <div class="sm:col-span-2 md:col-span-1 ">
        <div class="card-white border-t-2 dark:border-indigo-900">
            <div class="w-32 h-32 flex items-center rounded-full overflow-hidden mx-auto">
                <img src="{{ asset($this->user->profile_photo_url) }}" alt="{{ $this->user->name }}"
                    class="object-cover h-full w-full cursor-pointer">
            </div>
            <h1 class="text-xl font-bold text-center mb-4 sm:mb-0">{{ $this->user->name }}</h1>
            <p class="text-center">{{ $this->user->email }}</p>
        </div>
    </div>
    <div class="sm:col-span-2 md:col-span-2">
        <div class="card-white">
            <h1 class="text-xl font-bold text-center mb-4 sm:mb-0">Cursos</h1>
            <div class="flex flex-wrap m-0 bg-gray-50 rounded">
                @forelse ($this->user->inscriptions as $inscription)
                    <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
                        <div class="bg-white overflow-hidden shadow rounded-lg flex flex-col h-full">
                            <div class="flex-grow p-4 flex flex-col items-center justify-center">
                                <img src="{{ asset(!empty($inscription->event->image) ? $inscription->event->image : 'images/curso.png') }}"
                                    alt="{{ $inscription->name }}"
                                    class="hover:scale-125 h-52 w-full bg-slate-500 rounded-t-lg">
                            </div>
                            <div class="flex-grow p-4 flex flex-col justify-between">
                                <div class="mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $inscription->event->name }}</h3>
                                    <p class="text-sm text-gray-500">Status: {{ getStatusInscription($inscription->status) }}</p>
                                    <p class="text-sm text-gray-500">Frequencia: {{ $inscription->frequencies->count() }} / {{ $inscription->event->lessons->count() }}</p>
                                    <p class="text-sm text-gray-500">Atividades: {{ $this->activity[$inscription->event_id] }}</p>
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

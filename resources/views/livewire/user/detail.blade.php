<div>
    <h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Inscrições</h1>
    <div class="card-white">
        <div class="flex flex-wrap m-0 bg-gray-50 rounded">
            @forelse ($user->inscriptions as $inscription)
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

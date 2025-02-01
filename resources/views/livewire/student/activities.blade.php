<div>
    <div class="flex flex-col md:flex-row sm:items-center items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-icon-paste class="w-6 h-6" />
            <div class="ml-2 text-xl font-bold">
                Lista de Atividades
            </div>
        </div>
    </div>
    <div class="card-white p-4">
        <div >
            <ul>
                @forelse ($this->user->activities as $activity)
                <a href="/event/{{ $activity->lesson->event->id}}/question/{{ $activity->id }}" class="flex flex-col bg-white dark:bg-slate-800  rounded-md sm:flex-row  justify-start">
                    <div  class="sm:w-40 w-full rouded-l-md">
                        <img src="{{ asset(!empty($activity->lesson->event->image) ? $activity->lesson->event->image : 'images/curso_new.png') }}"
                            alt="{{ $activity->lesson->event->name }}"
                            class="hover:scale-105  object-cover h-32 w-full sm:rounded-l-md rounded-t-md">
                    </div>

                    <div class=" p-3 ">
                        <h2 class="hover:scale-105 font-bold text-xl">{{ $activity->lesson->event->name}}</h2>


                        <div class="tags">
                            <div class="flex flex-row justify-start items-center gap-2">
                                <p class="status information text-sm font-semibold">Aula:</p>
                                <p class="status information text-sm font-semibold">{{ $activity->lesson->title }}</p>


                            </div>
                            <div class="flex flex-row justify-start items-center gap-2">
                                <p class="status information text-sm font-semibold">Atividade:</p>
                                <p class="status information text-sm font-semibold">{{ $activity->title }}</p>

                            </div>
                        </div>
                    </div>
                </a>
                @empty
                    <li>Nenhuma atividade encontrada!</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

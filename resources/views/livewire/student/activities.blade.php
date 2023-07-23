<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Lista de Atividades
            </div>
        </div>
    </div>
    <div class="card-white">
        <div class="flex flex-wrap m-0  rounded-md">
            <ul>
                @forelse ($this->user->activities as $activity)
                    <li class="mt-4">
                        <a href="/event/question/{{ $activity->id }}">
                            <b>Curso:</b> {{ $activity->lesson->event->name }} <br />
                            <b>Aula:</b> {{ $activity->lesson->title }} <br />
                            <b>Atividade:</b> {{ $activity->title }} <br />
                            <b>Descrição:</b> {{ $activity->description }}
                        </a>
                    </li>
                @empty
                    <li>Nenhuma atividade encontrada!</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

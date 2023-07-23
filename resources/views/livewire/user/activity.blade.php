<div>
    <ul>
        @forelse ($this->user->activities as $activity)
            <a href="/event/question/{{ $activity->id }}">
                Curso: {{ $activity->lesson->event->name }} <br />
                Aula: {{ $activity->lesson->title }} <br />
                Atividade: {{ $activity->title }}
            </a>
        @empty
            <p>Nenhuma atividade encontrada!</p>
        @endforelse
    </ul>
</div>

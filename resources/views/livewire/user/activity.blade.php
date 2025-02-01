<div>
    <ul>
        @forelse ($this->user->activities as $activity)

        <a href="/event/question/{{ $activity->id }}" class="flex flex-col bg-white dark:bg-slate-800  rounded-md sm:flex-row  justify-start">
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
            <p>Nenhuma atividade encontrada!</p>
        @endforelse
    </ul>
</div>

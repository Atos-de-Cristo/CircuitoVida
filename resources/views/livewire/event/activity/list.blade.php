<div class="overflow-auto ">
    @forelse ($activities as $activity)
    @cannot(['monitorEvent'], $eventId)
    @if ($activity->type == 'E')
        @can('aluno')
            @if (!$activity->users->find(Auth::user()->id))
                @php continue; @endphp
            @endif
        @endcan
    @endif
    @endcannot
        <div class="flex justify-between items-baseline mb-2">
            <x-icon-file-word class="pt-1" />
            <div class="flex flex-1 justify-start -mt-1">
                <a
                    href="{{ route('eventActivityQuestion', ['eventId' => $activity->lesson->event->id, 'id' => $activity->id]) }}"
                    class="font-bold text-md text-blue-500 hover:underline  ml-2 flex flex-col mt-0"
                >
                    <p class="">{{ $activity->title }}</p>
                    @if ($activity->type == 'E')
                        @cannot('aluno')
                            <p>({{$activity->users->pluck('name')->implode(', ')}})</p>
                        @endcannot
                    @endif
                    <small>{{ $activity->description }}</small>
                </a>
            </div>
            <div class="flex items-center mr-2 min-w-[56px]">
                @can('admin')
                    <livewire:event-activity-actions :activityId="$activity->id" :lessonId="$lessonId" :key="rand().$activity->id" />
                @endcan
            </div>
        </div>
    @empty
        <span class="text-red-500">Nenhuma atividade cadastrada</span>
    @endforelse
</div>

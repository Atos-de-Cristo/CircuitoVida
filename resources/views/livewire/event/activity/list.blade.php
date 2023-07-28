<div class="overflow-auto ">
    @forelse ($activities as $activity)
    @if ($activity->type == 'E')
        @can('aluno')
            @if (!$activity->users->find(Auth::user()->id))
                @php continue; @endphp
            @endif
        @endcan
    @endif
        <div class="flex items-center justify-between">
            <div class="flex justify-start items-baseline">
                <x-icon-file-word />
                <a
                    href="{{ route('eventActivityQuestion', ['eventId' => $activity->lesson->event->id, 'id' => $activity->id]) }}"
                    class="font-bold text-md text-blue-500 hover:underline  ml-2 flex flex-col"
                >
                    @if ($activity->type == 'E')
                        @can('admin')
                            <small>({{$activity->users->pluck('name')->implode(', ')}})</small>
                        @endcan
                    @endif
                    {{ $activity->title }}
                    <small>{{ $activity->description }}</small>
                </a>
            </div>
            <div class="flex items-center mr-2">
                @can('admin')
                    <livewire:event-activity-actions :activityId="$activity->id" :lessonId="$lessonId" :key="rand().$activity->id" />
                @endcan
            </div>
        </div>
    @empty
        <span class="text-red-500">Nenhuma atividade cadastrada</span>
    @endforelse
</div>

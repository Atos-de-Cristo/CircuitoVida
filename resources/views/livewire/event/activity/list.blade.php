<div>
    @forelse ($activities as $activity)
        <div class="flex items-center justify-between">
            <div class="flex justify-start items-baseline">
             <x-svg.activity/>
                <a
                    href="{{ route('eventActivityQuestion', ['id' => $activity->id]) }}"
                    class="font-bold text-md text-blue-500 hover:underline  ml-2 flex flex-col"
                >
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

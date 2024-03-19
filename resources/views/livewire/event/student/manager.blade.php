<div class="card-white py-2 px-4">
    <x-search-form placeholder="Buscar aluno..." />

    <div class="overflow-auto h-96">
        @forelse ($inscriptions as $key => $aluno)
            @can('monitorEvent', $event_id)
            <div>
                <div
                    class="flex items-center mt-4 {{ (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'bg-infor p-2' : '' }}"
                >
                    <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                        width="32" height="32" alt="{{ $aluno->user->name }}" />
                    <livewire:event-student-status
                        :inscriptionId="$aluno->id"
                        :eventId="$event_id"
                        :student="$aluno->user"
                        :activityStatus="$aluno->user->activityStatus"
                        :absenceCount="$aluno->user->absenceCount"
                        :key="rand().$aluno->id"
                    />
                </div>
            </div>
            @else
                @can('aluno')
                <div class="flex items-center mt-5 mb-4">
                    <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                        width="32" height="32" alt="{{ $aluno->user->name }}" />
                    <a wire:click="sendMessage({{ $aluno->user->id }})"
                        class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer {{ $aluno->user->id == Auth::user()->id ? 'pointer-events-none' : '' }}">
                        <span class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name
                            }}</span>
                    </a>
                </div>
                @else
                <div>
                    <div
                        class="flex items-center mt-4 {{ (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'bg-infor p-2' : '' }}"
                    >
                        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                            width="32" height="32" alt="{{ $aluno->user->name }}" />
                        <livewire:event-student-status
                            :inscriptionId="$aluno->id"
                            :eventId="$event_id"
                            :student="$aluno->user"
                            :activityStatus="$aluno->user->activityStatus"
                            :absenceCount="$aluno->user->absenceCount"
                            :key="rand().$aluno->id"
                        />
                    </div>
                </div>
                @endcan
            @endcan
        @empty
        <div class="mt-5">
            <span class="text-red-500">Nenhuma inscrição realizada</span>
        </div>
        @endforelse
    </div>
</div>

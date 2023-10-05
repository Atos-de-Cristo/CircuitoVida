<div class="card-white py-2 px-4">
    <x-search-form placeholder="Buscar aluno..." />

    <div class="overflow-auto h-96">
        @forelse ($inscriptions as $key => $aluno)
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
                    @if (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2)
                        <livewire:event-student-status
                            :inscriptionId="$aluno->id"
                            :student="$aluno->user"
                            :activityStatus="$aluno->user->activityStatus"
                            :absenceCount="$aluno->user->absenceCount"
                            :key="rand().$aluno->id"
                        />
                    @else
                    <a class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer"
                        href="{{route('userDetails', $aluno->user->id)}}">
                        <span
                            class="truncate ml-1 text-sm font-medium group-hover:text-slate-800
                        {{ (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'text-white' : '' }}">
                            {{ $aluno->user->name }}
                        </span>
                    </a>
                    @endif
                </div>
            </div>
            @endcan

        @empty
        <div class="mt-5">
            <span class="text-red-500">Nenhuma inscrição realizada</span>
        </div>
        @endforelse
    </div>
</div>

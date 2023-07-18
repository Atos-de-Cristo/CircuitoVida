
<div class="card-white">
    <div class="font-bold flex items-center">
        <div class="relative mr-4 flex">
            <input wire:model.debounce.300ms.page="search"  placeholder="Buscar aluno..."
                class="input-form-search"
                type="text">
            <x-svg.search />
        </div>
    </div>
    @forelse ($inscriptions as $aluno)
        @can('admin')
            <div class="
                flex items-center mt-4 
                @if(count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2)
                    bg-red-500 rounded-md p-2
                @endif
                "
            >
                <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                    width="32" height="32" alt="{{ $aluno->user->name }}" />
                <a
                    href="{{ route('userDetails', $aluno->user->id) }}"
                    class="font-bold text-md text-blue-500 hover:underline ml-2"
                    x-data="{ open: null }"
                >
                    <span class="
                        truncate ml-2 text-sm font-medium group-hover:text-slate-800
                        @if(count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2)
                            text-white
                        @endif
                    ">
                        {{ $aluno->user->name }}
                        @if(count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2)
                            <br />
                            <small>
                                Pendencias:<br />
                                @if ($aluno->user->absenceCount > 2)
                                    Faltas: {{$aluno->user->absenceCount}}<br />
                                @endif
                                @foreach ($aluno->user->activityStatus as $activityPendent)
                                    {{$activityPendent['lesson']}} ({{$activityPendent['activity']}}) - {{$activityPendent['status']}}<br />
                                @endforeach
                            </small>
                        @endif
                    </span>
                </a>
            </div>
        @elsecan('aluno')
            <div class="flex items-center mt-5 mb-4">
                <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
                    width="32" height="32" alt="{{ $aluno->user->name }}" />
                <a wire:click="sendMessage({{$aluno->user->id}})"
                    class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer {{$aluno->user->id == Auth::user()->id ? 'pointer-events-none' : ''}}" x-data="{ open: null }">
                    <span class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name
                        }}</span>

                </a>
            </div>
        @endcan
    @empty
    <div class="mt-5">
        <span class="text-red-500 ">Nenhuma inscrição realizada</span>
    </div>

    @endforelse
</div>

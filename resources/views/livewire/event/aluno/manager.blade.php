<div class="card-white">
    <x-search-form placeholder="Buscar aluno..." />
    @forelse ($inscriptions as $aluno)
    @can('admin')
    <div class="flex items-center mt-4 {{ (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'bg-red-500 rounded-md p-2' : '' }}">
        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}" width="32" height="32" alt="{{ $aluno->user->name }}" />
        <a href="{{ route('userDetails', $aluno->user->id) }}" class="font-bold text-md text-blue-500 hover:underline ml-2" x-data="{ open: null }">
            <span class="truncate ml-1 text-sm font-medium group-hover:text-slate-800 {{ (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) ? 'text-white' : '' }}" 
            @if (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2) 
            data-popover-target="{{ $aluno->user->id }}" 
            @endif>
                {{ $aluno->user->name }}
            </span>
        </a>
    </div>
    <div data-popover id="{{ $aluno->user->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
        <div class="p-3">
            <div class="flex items-center justify-between mb-2">
                <a href="#">
                    <img class="w-10 h-10 rounded-full" src="{{ asset($aluno->user->profile_photo_url) }}" alt="{{ $aluno->user->name }}">
                </a>
                <div></div>
            </div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                <a href="#">{{ $aluno->user->name }}</a>
            </p>
    
            @if (count($aluno->user->activityStatus) > 0 || $aluno->user->absenceCount > 2)
            <div class="flex flex-col py-2">

                <span>
                    Pendências:
                </span>
                @if ($aluno->user->absenceCount > 2)
                    <small>
                        Faltas: {{ $aluno->user->absenceCount }}
                    </small>
                @endif
                
                @foreach ($aluno->user->activityStatus as $activityPendent)
                    <small>
                        {{ $activityPendent['lesson'] }} ({{ $activityPendent['activity'] }}) -
                        {{ $activityPendent['status'] }}
                    </small>
                @endforeach
            </div>
           
            
            @endif
    
        </div>
        <div data-popper-arrow></div>
    </div>
    
    @elsecan('aluno')
    <div class="flex items-center mt-5 mb-4">
        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}" width="32"
            height="32" alt="{{ $aluno->user->name }}" />
        <a wire:click="sendMessage({{$aluno->user->id}})"
            class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer {{$aluno->user->id == Auth::user()->id ? 'pointer-events-none' : ''}}"
            x-data="{ open: null }">
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
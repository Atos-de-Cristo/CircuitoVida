<div class="card-white">
    <div class="font-bold flex items-center">
        <div class="relative mr-4 flex">
            <input wire:model.debounce.300ms.page="search"  placeholder="Buscar eventos..."
                class="input-form-search"
                type="text">
            <x-svg.search />
        </div>
    </div>
    @forelse ($inscriptions as $aluno)
    <div class="flex items-center mt-5 mb-4">
        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($aluno->user->profile_photo_url) }}"
            width="32" height="32" alt="{{ $aluno->user->name }}" />
        @can('admin', 'monitor')
        <a href="{{ route('userDetails', $aluno->user->id) }}"
            class="font-bold text-md text-blue-500 hover:underline ml-2" x-data="{ open: null }">
            <span class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name
                }}</span>
        </a>
        @elsecan('aluno')
        <span class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name
            }}</span>
        @endcan
    </div>
    @empty
    <span class="text-red-500">Nenhuma inscrição realizada</span>
    @endforelse
</div>

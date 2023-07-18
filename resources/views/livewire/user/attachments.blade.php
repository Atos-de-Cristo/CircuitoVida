<div>
    <form>
        <div class="flex flex-row space-x-2 justify-between items-center">
            <div class="">
                <label for="campName" class="label-input-form">Nome:</label>
                <input type="text" class="input-form" id="campName" placeholder="Entre com o nome"
                    wire:model.lazy="name">
                @error('name')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="">
                <label for="campImg" class="label-input-form">Anexo</label>
                <input type="file" wire:model="attachment">
                @error('attachment')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class=" w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="store()" type="button" class="btn-submit">
                    Salvar
                </button>
            </div>
        </div>
        <div class="mt-4">
            <hr class="my-2 border-gray-300">
            @forelse ($this->list as $item)
                <p>
                    <a href="{{$item->path}}" target="_blank" class="font-bold text-md text-blue-500 hover:underline ">
                        {{$item->name}}.{{$item->type}}
                    </a>
                </p>
            @empty
                <p>Nenhum anexo encontrado!</p>
            @endforelse
        </div>
    </form>
</div>

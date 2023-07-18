<div>
    <form>
        <div class="flex flex-row">
            <div class="mb-4">
                <label for="campName" class="label-input-form">Nome:</label>
                <input type="text" class="input-form" id="campName" placeholder="Entre com o nome"
                    wire:model.lazy="name">
                @error('name')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="campImg" class="label-input-form">Anexo</label>
                <input type="file" wire:model="attachment">
                @error('attachment')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click="store()" type="button" class="btn-submit">
                    Salvar
                </button>
            </span>
        </div>
        <div class="mt-4">
            @forelse ($this->list as $item)
                <p>
                    <a href="{{$item->path}}" target="_blank">
                        {{$item->name}} ({{$item->type}})
                    </a>
                </p>
            @empty
                <p>Nenhum anexo encontrado!</p>
            @endforelse
        </div>
    </form>
</div>

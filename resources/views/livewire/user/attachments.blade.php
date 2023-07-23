<div>
    <form>
        <div class="grid gap-2 mb-6 md:grid-cols-5">
            <div class="col-span-2">                
                <input  wire:model.lazy="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entre com o nome" >
                @error('name')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2">
               
                <input wire:model="attachment" class="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="small_size" type="file">
                @error('attachment')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1">
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

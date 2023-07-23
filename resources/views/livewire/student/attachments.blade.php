<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Lista de Anexos
            </div>
        </div>
    </div>
    <div class="card-white">
        <div class="flex flex-wrap m-0 rounded-md flex-col">
            @forelse ($this->list as $item)
                <p>
                    <a
                        href="{{$item->path}}"
                        target="_blank"
                        class="font-bold text-md text-blue-500 hover:underline"
                    >
                        {{$item->name}}.{{$item->type}}
                    </a>
                </p>
            @empty
                <p>Nenhum anexo encontrado!</p>
            @endforelse
        </div>
    </div>
</div>

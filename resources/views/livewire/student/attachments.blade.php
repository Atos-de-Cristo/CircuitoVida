<div>
    <div class="flex flex-col md:flex-row sm:items-center items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-icon-paperclip class="w-6 h-6" />
            <div class="ml-2 text-xl font-bold">
                Lista de Anexos Individual
            </div>
        </div>
    </div>
    <div class="card-white p-4">
        <div class="flex flex-wrap m-0 rounded-md flex-col">
            @forelse ($this->list as $item)
                <p class="flex gap-2 items-center">
                  <x-icon-paperclip  />
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
    <div class="flex flex-col md:flex-row sm:items-center items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-icon-paperclip class="w-6 h-6" />
            <div class="ml-2 text-xl font-bold">
                Lista de Anexos por Aula
            </div>
        </div>
    </div>
    <div class="card-white p-4">
        <div class="flex flex-wrap m-0 rounded-md flex-col">
            @forelse ($this->listLesson as $item)
                <p class="flex gap-2 items-center">
                  <x-icon-paperclip  />
                    <a
                        href="{{$item->path}}"
                        target="_blank"
                        class="font-bold text-md text-blue-500 hover:underline"
                    >
                        {{$item->name}}.{{$item->type}} (Aula: {{$item->lesson->title}})
                    </a>
                </p>
            @empty
                <p>Nenhum anexo encontrado!</p>
            @endforelse
        </div>
    </div>
</div>

<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Lista de Inscrições
            </div>
        </div>
        <div class="hidden md:inline">
            <ol class="flex items-center space-x-2 text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Cursos</li>
            </ol>
        </div>
    </div>
    <div class="card-white">      
       
           @foreach($dataAll as $data)
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-2">
                    <div class="bg-gray-100  max-w-sm  dark:bg-slate-800 overflow-hidden shadow rounded-lg flex flex-col ">
                        <div class="flex-shrink-0">
                            <img src="{{ asset(!empty($data->event->image) ? $data->event->image : 'images/curso.png') }}"
                                alt="Logo Evento {{ $data->event->name }}"
                                class="hover:scale-105 h-52 w-full object-cover rounded-t-lg cursor-pointer"
                                wire:click="manager({{ $data->id }})">
                        </div>
                        <div class="flex-grow p-4 flex flex-col justify-between">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $data->event->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-white">{{ getTypeEvent($data->event->type) }}</p>
                                <p class="text-sm text-gray-500 dark:text-white">{{ getStatusEvent($data->status) }}</p>
                            </div>
                            <div>
                                <hr class="my-2 border-gray-300">
                                <div class="flex justify-center md:space-x-4 md:space-y-0 space-y-4 flex-col md:flex-row">
                                    <button wire:click="view({{ $data->event->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver</button>
                                    <button wire:click="cancel({{ $data->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                                </div>
    
                            </div>
                        </div>
                    </div>
    
    
                </div>
                @endforeach
    </div>
</div>

<div>
    @if (session()->has('message'))
    <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
    @endif
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Gerenciar Inscrições
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
        <div class="flex flex-col mb-4 sm:flex-row justify-between items-center">
            <x-search-form placeholder="Buscar eventos..."/>
        </div>
        <div class="flex flex-wrap m-0  rounded-md">
            @foreach ($dataAll as $data)
            <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
                <div
                    class="bg-gray-100  max-w-sm  dark:bg-slate-800  overflow-hidden shadow rounded-lg flex flex-col h-full">
                    <div class="flex-shrink-0">
                        <img src="{{ asset(!empty($data->image) ? $data->image : 'images/curso.png') }}"
                            alt="Logo Evento {{ $data->name }}"
                            class="hover:scale-110 h-52 w-full object-cover rounded-t-lg cursor-pointer"
                            wire:click="manager({{ $data->id }})">

                    </div>
                    <div class="flex-grow p-4 flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $data->name }} </h3>
                            <p class="text-sm dark:text-white text-gray-500 ">Início:
                                {{ date('d/m/Y', strtotime($data->start_date)) }}</p>
                            <p class="text-sm dark:text-white text-gray-500">Fim: {{ date('d/m/Y',
                                strtotime($data->end_date)) }}
                            </p>
                            <p class="text-sm dark:text-white text-gray-500">Status: {{ getStatusEvent($data->status) }}
                            </p>
                            <p class="text-sm dark:text-white text-gray-500">Vagas: {{ $data->tickets_limit }}</p>
                            <p class="text-sm dark:text-white text-gray-500">Inscritos: {{ count($data->inscriptions) }}
                            </p>
                            <p class="text-sm dark:text-white text-gray-500">Valor: R$
                                {{ number_format(floatval($data->value), 2, ',', '.') }}</p>
                        </div>
                        <div>
                            <hr class="my-2 border-gray-300">
                            <div class="flex justify-center space-x-4">
                                {{-- TODO: usar enums --}}
                                @switch($data->status)
                                @case('P')
                                <button wire:click.prevent="open({{ $data->id }})"
                                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full">Abrir
                                    Inscrições</button>
                                @break

                                @case('A')
                                <button wire:click.prevent="close({{ $data->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">Encerrar</button>
                                @break

                                @case('E')
                                <button wire:click.prevent="viewInsc({{ $data->id }})"
                                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full">
                                    Inscritos</button>
                                <button wire:click.prevent="open({{ $data->id }})"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">Reabrir
                                </button>
                                @break
                                @endswitch

                            </div>
                        </div>
                    </div>


                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $dataAll->links() }}
        </div>
    </div>
    @if ($isUser)
    @include('livewire.event.inscription-user')
    @endif
</div>

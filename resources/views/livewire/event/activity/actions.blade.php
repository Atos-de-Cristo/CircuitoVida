<div>
    @empty($activityId)
        <button wire:click.prevent="openModal()" class="btn-primary text-xs ml-2">
            <x-icon-plus  />
        </button>
    @else
        <button wire:click.prevent="openModal()" class="mr-2 hover:scale-110">
            <x-icon-pencil class="w-5 h-5" />
        </button>
        <button wire:click.prevent="dellActivity()" class="hover:scale-110">
            <x-icon-trash class="w-5 h-5" />
        </button>
    @endempty

    @if ($isOpenActivity)
        <x-dialog-modal id="isOpenActivity" wire:model="isOpenActivity" maxWidth="lg" closeModal="closeModal()">
            <x-slot name="title">
                @if (!empty($activityId))
                    Atualizar Atividade
                @else
                    Adicionar Atividade
                @endif
            </x-slot>

            <x-slot name="content">
                <form>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label for="campTitle" class="label-input-form">Titulo:</label>
                            <input type="text" wire:model.prevent="title" id="campTitle" placeholder="Entre com o titulo"
                                class="input-form">
                            @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="campDescription" class="label-input-form">Descrição:</label>
                            <textarea class="input-form" id="campDescription" wire:model.prevent="description"
                                placeholder="Informe a descrição" rows="5"></textarea>
                            @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                <input type="checkbox" class="sr-only peer" wire:model.prevent="type">
                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-focus:ring-4 peer-focus:ring-violet-300 dark:peer-focus:ring-violet-800 dark:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-violet-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{ ($this->type) ? 'Pessoal' : 'Geral' }}
                                </span>
                            </label>
                        </div>
                         @if ($this->type)
                            <div class="mb-4">
                                <div class="font-bold py-2 flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Alunos</h3>
                                    <x-search-form placeholder="Buscar Aluno..."/>
                                </div>

                                <ul class=" max-h-80 overflow-y-auto text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @forelse ($inscriptions as $insc)
                                    @if (str_contains(strtolower($insc->user->name), strtolower($search)) || str_contains(strtolower($insc->user->email), strtolower($search)))
                                        <li class=" border-b border-gray-200 rounded-t-lg dark:border-gray-600" wire:key="inscription-{{ $insc->id }}">
                                            <div class="flex items-center pl-3">
                                                <input
                                                    id="user-{{$insc->user->id}}"
                                                    type="checkbox"
                                                    value="{{$insc->user->id}}"
                                                    wire:model.prevent="userListActivity"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                >
                                                <label for="user-{{$insc->user->id}}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 flex flex-col">
                                                    {{$insc->user->name}}
                                                    <small>{{$insc->user->email}}</small>
                                                </label>
                                            </div>
                                        </li>
                                        @endif
                                    @empty
                                        <span class="text-red-500">Nenhuma inscrição encontrada!</span>
                                    @endforelse
                                </ul>
                            </div>
                        @endif
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="store()" type="button" class="btn-submit">
                        @if (!empty($activityId))
                        Atualizar
                        @else
                        Salvar
                        @endif
                    </button>
                </span>
                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="$set('isOpenActivity', false)" type="button" class="btn-default">
                        Cancelar
                    </button>
                </span>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>

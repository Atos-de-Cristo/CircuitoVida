<div class="relative">
    <button class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer"
        wire:click="$set('isOpen', true)">
        <span class="truncate font-medium font-sans text-sm group-hover:text-slate-800
            {{ (count($activityStatus) > 0 || $absenceCount > 2) ? 'text-gray-800  dark:text-white': '' }}
            ">
            {{ $userName }}
        </span>
    </button>
    @if ($isOpen)
    <x-dialog-modal id="myModal" wire:model.defer="isOpen" maxWidth="2xl" closeModal="closeModal()">
        <x-slot name="title">
            <div class="flex flex-row items-center">
                @can('monitorEvent', $eventId)
                <a
                    class="flex"
                    style="cursor: pointer"
                    wire:click="sendMessage({{ $userId }})"
                    class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer {{ $userId == Auth::user()->id ? 'pointer-events-none' : '' }}"
                >
                    <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($userPhotoUrl) }}"
                    width="32" height="32" alt="{{ $userName }}" />
                    <span class="truncate mt-1 text-sm font-medium group-hover:text-slate-800">{{ $userName }}</span>
                </a>
                @else
                <a href="{{ route('userDetails', $userId) }}" class="flex">
                    <img class="w-10 h-10 rounded-full" src="{{ asset($userPhotoUrl) }}"
                        alt="{{ $userName }}" />
                </a>
                <p class="ml-2 text-base font-semibold leading-none text-gray-900 dark:text-white">
                    <a href="{{ route('userDetails', $userId) }}">{{ $userName }}</a>
                </p>
                @endCan
            </div>
        </x-slot>

        <x-slot name="content">
            @if (count($activityStatus) > 0 || $absenceCount > 0)
            <div class="">
                <strong class="font-roboto">Pendências:</strong>
                <div class="overflow-auto h-80">
                    @if ($absenceCount > 0)
                    <div class="ml-2 mt-2 flex flex-row items-center">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white dark:ring-red-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5  text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                        </span>
                        <div class="ml-3">
                            <h3 class="font-bold leading-tight">Faltas:</h3>
                            <p class="text-sm">{{ $absenceCount }}
                                <span class="text-xs italic">faltas</span>
                            </p>
                        </div>
                    </div>
                    @endif
                    @forelse ($activityStatus as $activityPendent)
                        <div class="ml-2 mt-2 flex flex-row items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full ring-4 ring-white dark:ring-red-900 dark:bg-gray-700">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                            </span>
                            <div class="ml-3">
                                <h3 class="font-bold leading-tight">{{ $activityPendent['module'] }} -> {{ $activityPendent['lesson'] }}</h3>
                                <p class="text-sm font-semibold">{{ $activityPendent['activity'] }}</p>
                                <p class="text-xs italic">{{ $activityPendent['status'] }}</p>
                            </div>
                        </div>
                    @empty
                        <span class="text-red-500">Nenhuma pendência encontrada!</span>
                    @endforelse
                </div>
            </div>
            @else
            <div class="flex items-center justify-center p-4">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <h3 class="mt-2 text-xl font-medium text-gray-900 dark:text-white">Tudo ok! Sem pendências.</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Não há pendências para este aluno.</p>
                </div>
            </div>
            @endif

        </x-slot>
        <x-slot name="footer">
            <div class="flex w-full justify-between">
                <div class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto gap-3">
                    @if ($confirmHandleStatus == 'C')
                    <textarea id="messageTextarea" wire:model.lazy="cancellation_reason" rows="2" placeholder="Motivo do cancelamento"
                        class="m-0 w-full resize-none border-0 bg-gray-100 p-2  focus:ring-0 focus-visible:ring-0 dark:bg-gray-900 "
                        style="overflow-y: auto; resize: vertical; height: auto;"></textarea>
                    <button wire:click="toggleInscription('C')" class="btn-warning">
                        Confirmar
                    </button>
                    @elseif($confirmHandleStatus == 'R')
                    <textarea id="messageTextarea" wire:model.lazy="cancellation_reason" rows="2" placeholder="Motivo da reprovação"
                        class="m-0 w-full resize-none border-0 bg-gray-100 p-2  focus:ring-0 focus-visible:ring-0 dark:bg-gray-900 "
                        style="overflow-y: auto; resize: vertical; height: auto;"></textarea>
                    <button wire:click="toggleInscription('C')" class="btn-danger">
                        Confirmar
                    </button>
                    @elseif($confirmHandleStatus == 'A')
                    <textarea id="messageTextarea" wire:model.lazy="cancellation_reason" rows="2" placeholder="Informe a nota"
                        class="m-0 w-full resize-none border-0 bg-gray-100 p-2  focus:ring-0 focus-visible:ring-0 dark:bg-gray-900 "
                        style="overflow-y: auto; resize: vertical; height: auto;"></textarea>
                    <button wire:click="toggleInscription('A')" class="btn-danger">
                        Confirmar
                    </button>
                    @else
                        @if($inscriptionStatus == 'L')
                            <button wire:click.prevent="$set('confirmHandleStatus', 'A')" class="btn-primary">
                                <x-icon-plus/>
                                <span class="ml-1">Aprovar</span>
                            </button>
                            <button wire:click.prevent="$set('confirmHandleStatus', 'R')" class="btn-danger">
                                <x-icon-plus/>
                                <span class="ml-1">Reprovar</span>
                            </button>
                            <button wire:click.prevent="$set('confirmHandleStatus', 'C')" class="btn-warning">
                                <x-icon-plus/>
                                <span class="ml-1">Cancelar</span>
                            </button>
                        @else
                            <div class="flex flex-col">
                                <div class="bg-gray-100 dark:bg-gray-700 rounded p-3">
                                    <span class="font-bold">Status: </span>
                                    <span class="p-1 rounded text-white
                                        {{ $inscriptionStatus == 'A' ? 'bg-green-500' : 
                                           ($inscriptionStatus == 'R' ? 'bg-red-500' : 
                                            ($inscriptionStatus == 'C' ? 'bg-yellow-500' : 'bg-blue-500')) 
                                        }}">
                                        {{ \App\Enums\InscriptionStatus::fromValue($inscriptionStatus) }}
                                    </span>
                                    
                                    @if(!empty($inscriptionReason))
                                        <div class="mt-2">
                                            <span class="font-bold">Observação:</span>
                                            <p class="text-sm italic">{{ $inscriptionReason }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="closeModal()" type="button" class="btn-default">
                        Fechar
                    </button>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>

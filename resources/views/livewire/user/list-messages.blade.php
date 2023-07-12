<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Mensagens</h1>
    </div>
    <div class="card-white">
        <div class="flex flex-col mb-4 sm:flex-row justify-between items-center">
            <div class="font-bold flex items-center">
                <div class="relative mr-4 flex">
                    <input wire:model.debounce.300ms.page="search" wire:keydown="search"
                        placeholder="Buscar mensagens..." class="input-form-search" type="text">
                    <x-svg.search />
                </div>
            </div>
        </div>
        <ul>
            @forelse ($this->listMessage as $message)
            <li class="flex items-start mb-2">
                <div>
                    <img class="w-12 h-12 bg-black rounded-full mr-2" src="{{ asset($message->userSend->profile_photo_url) }}"
                        width="32" height="32" alt="{{ $message->userSend->name }}" />
                </div>
                <div
                    class="flex-1 rounded-lg rounded-tl-none overflow-hidden shadow-lg bg-white dark:bg-gray-800 mr-14">
                    <div class="px-4 py-2 flex flex-col sm:flex-row justify-between">
                        <p>{{$message->message}}</p>
                        <div>
                            @if (!$message->read)
                            <button wire:click.prevent="read({{$message->id}})">
                                <svg class="h-5 w-5 animate-pulse hover:animate-none" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.5"
                                        d="M22 10C22.0185 10.7271 22 11.0542 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H13"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path
                                        d="M6 8L8.1589 9.79908C9.99553 11.3296 10.9139 12.0949 12 12.0949C13.0861 12.0949 14.0045 11.3296 15.8411 9.79908"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <circle cx="19" cy="5" r="3" stroke="currentColor" stroke-width="1.5"></circle>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-2">
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div>
                                <small class="font-sans">{{$message->userSend->name}}</small>
                            </div>
                            <div class="sm:ml-4">
                                <small class="sm:block italic">Publicado
                                    <span>{{\Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:m:s')}}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <p>Nenhuma mensagem encontrada</p>
            </li>
            @endforelse
        </ul>
        {{ $this->listMessage->links() }}
    </div>
</div>

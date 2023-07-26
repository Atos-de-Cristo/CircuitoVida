<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left  font-bold text-xl">Lista de Mensagens</h1>
    </div>
<x-card>
    <x-slot name="headerCard">
        <x-search-form placeholder="Buscar usuário..."/>
    </x-slot>
    <x-slot name="contentCard">
       
            @forelse ($this->listMessage as $message)
            <div class="flex w-full flex-row items-start mb-2">
                <div>
                    <img class="w-12 h-12 bg-black rounded-full mr-2"
                        src="{{ asset($message->userSend->profile_photo_url) }}" width="32" height="32"
                        alt="{{ $message->userSend->name }}" />
                </div>
                <div
                    class="flex-1 rounded-lg rounded-tl-none overflow-hidden shadow-lg bg-white dark:bg-gray-800 mr-14">
                    <div class="px-4 py-2 flex flex-col sm:flex-row justify-between">
                        <p>{{$message->message}}</p>
                        <div>
                            @if ($message->user_for == auth()->user()->id)
                            @if (!$message->read)
                            <button wire:click.prevent="read({{$message->id}})" class="flex justify-center mt-2 sm:mt-0 items-center space-x-1 animate-pulse ">
                                <svg class="h-5 w-5 animate-pulse hover:animate-none" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.5"
                                        d="M22 10C22.0185 10.7271 22 11.0542 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H13"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path
                                        d="M6 8L8.1589 9.79908C9.99553 11.3296 10.9139 12.0949 12 12.0949C13.0861 12.0949 14.0045 11.3296 15.8411 9.79908"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <circle cx="19" cy="5" r="3" stroke="currentColor" stroke-width="1.5"></circle>
                                </svg>
                                <small class="text-xs"> Marcar como lida</small>
                            </button>
                            @else
                            <button wire:click.prevent="sendMessage({{$message->user_send}})" class="flex justify-center mt-2 sm:mt-0 items-center space-x-1">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" 
                                    transform="rotate(270)">
                                    
                                        <path fill="currentColor"
                                            d="M12 4.5L17 9.5M12 4.5L7 9.5M12 4.5L12 11M12 14.5C12 16.1667 11 19.5 7 19.5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                                                    </svg>
                                <small class="text-xs">Responder!</small>

                            </button>
                            @endif
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
            </div>
            @empty
            <div>
                <p>Nenhuma mensagem encontrada</p>
            </div>
            @endforelse
      
    </x-slot>
    <x-slot name="footerCard">
        {{ $this->listMessage->links() }}
    </x-slot>
</x-card>

    
  
</div>
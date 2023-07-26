<div>
  <div class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md mb-4 p-4">
    <form>
        <div
        x-data="{ textareaHeight: 'auto' }"
        x-init="() => {
          const textarea = document.getElementById('messageTextarea');

          increaseTextareaHeight = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
            textareaHeight = textarea.style.height;
          };

          decreaseTextareaHeight = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight - 16 + 'px';
            textareaHeight = textarea.style.height;
          };

          textarea.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
              event.preventDefault();
              increaseTextareaHeight();
              textarea.value += '\n';
              textarea.scrollTop = textarea.scrollHeight;
            }
            if (event.key === 'Backspace') {
              decreaseTextareaHeight();
            }
          });
        }"
          class="flex flex-col w-full py-[10px] flex-grow md:py-4 md:pl-4 relative border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-300  dark:bg-gray-800 rounded-xl shadow-xs dark:shadow-xs"
        >
          <textarea
            id="messageTextarea"
            wire:model="message"
            rows="2"
            placeholder="Enviar uma mensagem"
            class="m-0 w-full resize-none border-0 bg-transparent p-0 pr-10 focus:ring-0 focus-visible:ring-0 dark:bg-transparent md:pr-12 pl-3 md:pl-0"
            x-bind:style="{ height: textareaHeight }"
            style="overflow-y: auto; scrollbar-width: thin; scrollbar-color: transparent transparent; resize: vertical;"
          ></textarea>
          <button
            wire:click.prevent="sendForum"
            {{$message == null||$message == '' ? 'disabled' : ''}}
            class="absolute p-1 rounded-md md:bottom-3 md:p-2 md:right-3 enabled:bg-green-600 dark:disabled:hover:bg-transparent right-2 disabled:text-gray-400  enabled:bg-green-purple text-white bottom-1.5 transition-colors disabled:opacity-10"
          >
            <span class="" data-state="closed">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none" class="h-4 w-4 m-1 md:m-0" stroke-width="2">
                <path d="M.5 1.163A1 1 0 0 1 1.97.28l12.868 6.837a1 1 0 0 1 0 1.766L1.969 15.72A1 1 0 0 1 .5 14.836V10.33a1 1 0 0 1 .816-.983L8.5 8 1.316 6.653A1 1 0 0 1 .5 5.67V1.163Z" fill="currentColor"></path>
              </svg>
            </span>
          </button>
        </div>
    </form>
   
 
</div>
<ul class="py-6">
  @forelse ($this->listForum as $item)
  <li class="flex items-start mb-2">
    @if ($item->userSend->id == auth()->user()->id)
      <div class="flex-1 rounded-lg rounded-tr-none overflow-hidden shadow-lg bg-white dark:bg-gray-800 ml-14">
        <div class="px-4 py-2">
          <p>{{$item->message}}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 px-4 py-2">
          <div class="flex flex-col sm:flex-row justify-between">
            <div>
              <small class="font-sans">{{$item->userSend->name}}</small>
            </div>
            <div class="sm:ml-4">
              <small class="sm:block italic">Publicado <span>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m:s')}}</span></small>            
            </div>
          </div>
        </div>
        
      </div>
      <div>
        <img class="w-12 h-12 bg-black rounded-full ml-2" src="{{ asset($item->userSend->profile_photo_url) }}"
          width="32" height="32" alt="{{ $item->userSend->name }}" />
      </div>
    @else
      <div>
        <img class="w-12 h-12 bg-black rounded-full mr-2" src="{{ asset($item->userSend->profile_photo_url) }}"
          width="32" height="32" alt="{{ $item->userSend->name }}" />
      </div>
      <div class="flex-1 rounded-lg rounded-tl-none  overflow-hidden shadow-lg bg-white dark:bg-gray-800 mr-14">
        <div class="px-4 py-2">
          <p>{{$item->message}}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 px-4 py-2">
          <div class="flex flex-col sm:flex-row justify-between">
            <div>
              <small class="font-sans">{{$item->userSend->name}}</small>
            </div>
            <div class="sm:ml-4">
              <small class="sm:block italic">Publicado <span>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m:s')}}</span></small> 
          </div>
        </div>
        
      </div>
    @endif
  </li>
  @empty
  <div class="flex flex-col items-center">
    <x-icon-message-not />
    <li>Nenhuma mensagem enviada!</li>
  </div>

  @endforelse
</ul>


</div>

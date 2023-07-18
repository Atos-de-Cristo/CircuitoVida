<div class=" absolute z-50  border-b-3 border-green-100 flex  rounded-md  px-4 py-3 shadow-md my-3 
{{$messageType === 'success' ? 'bg-green-600 border-green-600 text-green-900':'bg-red-400 border-red-500 text-red-900'}}"
    x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 5000)"
    x-transition:enter="transform-gpu ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transform-gpu ease-in duration-100">

    <div class="flex items-center">
        @if ($messageType === 'success')

        <svg class="w-16 h-16 text-white " viewBox="-3.5 0 19 19">

            <path class="fill-current"
                d="M4.63 15.638a1.028 1.028 0 0 1-.79-.37L.36 11.09a1.03 1.03 0 1 1 1.58-1.316l2.535 3.043L9.958 3.32a1.029 1.029 0 0 1 1.783 1.03L5.52 15.122a1.03 1.03 0 0 1-.803.511.89.89 0 0 1-.088.004z">
            </path>

        </svg>
        @elseif ($messageType === 'error')
        <svg class="w-10 h-10 text-white  mr-2" viewBox="0 0 24 24">
            <path class="fill-current"
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18a8 8 0 110-16 8 8 0 010 16zm1-10h-2v2h2v-2zm0 4h-2v6h2v-6z" />
        </svg>
        @endif
        <div class=" flex-col">
            <p class="text-sm text-white font-bold">{{ $messageType =='success' ? 'Sucesso' : 'Erro' }}</p>
            <p class="text-sm text-white font-serif italic">{{ $message }}</p>
        </div>
    </div>

</div>
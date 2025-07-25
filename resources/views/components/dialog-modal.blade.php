@props(['id' => null, 'maxWidth' => null, 'closeModal'=>null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-md border-t-2 dark:border-indigo-900 shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  wire:click.prevent="{{$closeModal}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 overflow-auto">
                {{ $content }}
            </div>
            <!-- Modal footer -->
            <div class="flex items-center  justify-start p-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                {{ $footer }}
        </div>
    </div>   
</x-modal>

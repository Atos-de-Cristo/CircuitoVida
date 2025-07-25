<div
    x-data="{ showMessage: true }"
    x-show="showMessage"
    x-init="setTimeout(() => { showMessage = false; }, 4000)"
    x-transition:enter="transform-gpu ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transform-gpu ease-in duration-100"
    class="
        flex w-auto absolute z-50 rounded-lg items-center p-4 mb-4
        {{ $messageType === 'success' ? 'text-green-800 dark:bg-green-700 bg-green-50 dark:text-green-50' : 'text-red-800 dark:bg-red-700 bg-red-50 dark:text-red-50' }}
    "
    role="alert"
>
    <div class="flex items-center w-full">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div class="ml-3 text-sm font-medium">
            {{ $message }}
        </div>
        <button
            type="button"
            class="ml-auto -mx-1.5 -my-1.5 p-1.5
            {{ $messageType === 'success' ? 'bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 hover:bg-green-200 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700' : 'bg-red-50  text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 hover:bg-red-200 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700'
            }}"
            aria-label="Close"
            @click="showMessage = false"
        >
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
</div>

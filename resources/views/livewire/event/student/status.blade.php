<div class="relative">
    <button
        class="font-bold text-md text-blue-500 hover:underline ml-2 cursor-pointer"
        wire:click="$set('isOpen', true)"
    >
        <span
            class="truncate font-medium font-sans text-sm group-hover:text-slate-800
            {{ (count($activityStatus) > 0 || $absenceCount > 2) ? 'text-gray-800  dark:text-white': '' }}
            "
        >
            {{ $user->name }}
        </span>
    </button>
    @if ($isOpen)
        <div class="fixed -mt-64 -ml-40 z-10 inline-block w-72 h-64 text-sm text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600 overflow-auto">
            <div class="p-3">
                <div class="flex items-center justify-start gap-2">
                    <a href="{{ route('userDetails', $user->id) }}" class="flex">
                        <img class="w-10 h-10 rounded-full" src="{{ asset($user->profile_photo_url) }}"
                            alt="{{ $user->name }}" />
                    </a>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                        <a href="{{ route('userDetails', $user->id) }}">{{ $user->name }}</a>
                    </p>
                </div>
                @if (count($activityStatus) > 0 || $absenceCount > 2)
                <div class="mt-5">
                    <strong class="font-roboto">Pendências:</strong>
                    <div
                        class="relative ml-5 mt-4 text-gray-500 border-l border-gray-200 dark:border-gray-700 dark:text-gray-400"
                    >
                        @if ($absenceCount > 2)
                        <div class="mb-5 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white dark:ring-red-900 dark:bg-gray-700">
                                <svg class="w-3.5 h-3.5  text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            </span>
                            <h3 class="font-bold leading-tight">Faltas:</h3>
                            <p class="text-sm">{{ $absenceCount }}
                                <span class="text-xs italic">faltas</span>
                            </p>
                        </div>
                        @endif
                        @foreach ($activityStatus as $activityPendent)
                        <div class="mb-5 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white dark:ring-red-900 dark:bg-gray-700">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                            </span>
                            <h3 class="font-bold leading-tight">{{ $activityPendent['lesson'] }}</h3>
                            <p class="text-sm font-semibold">{{ $activityPendent['activity'] }}</p>
                            <p class="text-xs italic">{{ $activityPendent['status'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    @endif
</div>

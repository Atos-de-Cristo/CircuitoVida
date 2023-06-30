<div>
    @if(!empty($this->inscriptions))
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Aulas
            </div>
        </div>
    </div>

    <div class="card-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex flex-wrap gap-4 sm:flex-row lg:flex-row mt-4">
            <div>
                @foreach ($this->inscriptions as $modules)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                    @foreach ($modules['lessons'] as $lesson)
                    <div class="relative flex flex-col p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"">
                        <div class=" font-semibold text-gray-700 dark:text-gray-200">{{ $modules['event'] }}</div>
                    <div class="text-gray-500 dark:text-gray-400">{{ $modules['module'] }}</div>
                    <div class="text-gray-500 dark:text-gray-400">{{ $lesson['title'] }}</div>
                    <a href="{{ route('classroom', ['id' => $lesson['id'], 'eventId' => $modules['event_id']]) }}"
                        class="mt-auto font-bold text-md text-blue-500 hover:underline">
                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-lg ">
                            <x-svg.play-lesson size="h-12 w-12" class="text-gray-500" />
                        </div>
                    </a>

                </div>
                @endforeach
            </div>
            @endforeach


        </div>
    </div>
</div>
@endif
</div>

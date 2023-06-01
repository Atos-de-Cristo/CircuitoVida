<div>
    <div class=" font-bold mb-2 flex items-center">
        <svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 100 100"
            enable-background="new 0 0 100 100" xml:space="preserve">
            <path
                d="M63.688,45.27l-18.033-8.967c-0.277-0.138-0.832-0.209-1.141-0.209c-2.583,0-5.015,2.09-5.015,4.562v19.211 c0,2.473,2.432,4.562,5.015,4.562c0.308,0,0.736-0.071,1.011-0.207l18.202-8.969c2.436-1.212,3.701-2.892,3.701-4.992 C67.43,48.822,66.804,46.786,63.688,45.27z M62.014,51.671l-17.82,8.687c-0.249-0.109-0.693-0.323-0.693-0.49V40.656 c0-0.164,0.448-0.378,0.694-0.488l17.604,8.691c0.963,0.469,1.601,0.993,1.601,1.402C63.398,50.432,63.461,50.95,62.014,51.671z">
            </path>
            <path
                d="M87.5,29.526c0-4.985-4.041-9.026-9.026-9.026H22.526c-4.985,0-9.026,4.041-9.026,9.026v40.947 c0,4.985,4.041,9.026,9.026,9.026h55.947c4.985,0,9.026-4.041,9.026-9.026V29.526z M83.5,70.474c0,2.776-2.25,5.026-5.026,5.026 H22.526c-2.776,0-5.026-2.25-5.026-5.026V29.526c0-2.776,2.25-5.026,5.026-5.026h55.947c2.776,0,5.026,2.25,5.026,5.026V70.474z">
            </path>
        </svg>
        <div class="ml-2 text-3xl font-bold">
            {{$lessonData->title}}
        </div>
    </div>
    @if ($lessonData->video)
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 mt-2 mb-4">
        <div class="w-full">
            <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                    src="https://www.youtube.com/embed/{{$lessonData->video}}" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center">
                <svg width="30px" height="30px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                    fill="#000000">
                    <path d="M20,29H36a2,2,0,0,0,0-4H20a2,2,0,0,0,0,4Z"></path>
                    <path d="M20,22H36a2,2,0,0,0,0-4H20a2,2,0,0,0,0,4Z"></path>
                    <path d="M20,36H36a2,2,0,0,0,0-4H20a2,2,0,0,0,0,4Z"></path>
                    <circle cx="12" cy="27" r="2"></circle>
                    <circle cx="12" cy="34" r="2"></circle>
                    <path
                        d="M44,4H4A2,2,0,0,0,2,6V42a2,2,0,0,0,2,2H44a2,2,0,0,0,2-2V6A2,2,0,0,0,44,4ZM42,40H6V14H42Zm0-30H6V8H42Z">
                    </path>
                </svg>
                <span class="ml-2">Atividades</span>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 mt-2 mb-4">
                <div class="w-full md:w-1/2">
                    @forelse ($lessonData->activities as $activity)
                        <a href="{{ $activity->id }}"
                            class="block text-blue-500 hover:text-blue-700 mb-1">{{ $activity->title }}</a>
                    @empty
                        <span class="text-red-500">Nenhuma atividade cadastrada</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16.9C16.3477 18 15.9 18.4477 15.9 19C15.9 19.5523 16.3477 20 16.9 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H7.1C7.65228 20 8.1 19.5523 8.1 19C8.1 18.4477 7.65228 18 7.1 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM13 11C13 10.4477 12.5523 10 12 10C11.4477 10 11 10.4477 11 11V16.5858L9.70711 15.2929C9.31658 14.9024 8.68342 14.9024 8.29289 15.2929C7.90237 15.6834 7.90237 16.3166 8.29289 16.7071L11.2929 19.7071C11.6834 20.0976 12.3166 20.0976 12.7071 19.7071L15.7071 16.7071C16.0976 16.3166 16.0976 15.6834 15.7071 15.2929C15.3166 14.9024 14.6834 14.9024 14.2929 15.2929L13 16.5858V11Z"
                            fill="#000000"></path>
                    </g>
                </svg>
                <span class="ml-2">Materiais</span>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if ($lessonData->slide)
                <a href="{{ $lessonData->slide }}" class="block text-blue-500 hover:text-blue-700 mb-1" target="_blanck">PDF</a>
                @else
                <span class="text-red-500">Nenhum PDF cadastrado</span>
                @endif
            </div>
        </div>
    </div>

</div>

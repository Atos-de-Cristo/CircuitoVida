<div>
    @if (session()->has('message'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
            role="alert" x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => { showMessage = false; }, 4000)">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class=" font-bold mb-4 flex items-center">
        <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 512 512" xml:space="preserve" width="30px" height="30px" fill="#000000" stroke="#000000"
            stroke-width="0.00512">
            <path class="st0" d="M512,0H0v40h16v296h480V40h16V0z M464,304H48V40h416V304z"></path>
            <rect x="240" y="352" class="st0" width="32" height="160"></rect>
            <polygon class="st0" points="113.273,512 145.273,512 212.179,352 180.179,352 "></polygon>
            <polygon class="st0" points="299.82,352 366.726,512 398.726,512 331.82,352 "></polygon>
        </svg>
        <div class="ml-2 text-3xl font-bold">
            {{ $event->name }}
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 mt-2 mb-4">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div>
                <div class="font-bold mb-4 flex items-center">
                    <svg height="20px" width="20px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                        fill="#000000">

                        <path class="st0"
                            d="M81.44,116.972c23.206,0,42.007-18.817,42.007-42.008c0-23.215-18.801-42.016-42.007-42.016 c-23.216,0-42.016,18.801-42.016,42.016C39.424,98.155,58.224,116.972,81.44,116.972z">
                        </path>
                        <path class="st0"
                            d="M224.166,245.037c0-0.856-0.142-1.673-0.251-2.498l62.748-45.541c3.942-2.867,4.83-8.411,1.963-12.362 c-1.664-2.285-4.342-3.652-7.17-3.652c-1.877,0-3.667,0.589-5.191,1.689l-62.874,45.636c-2.341-1.068-4.909-1.704-7.65-1.704 h-34.178l-8.294-47.222c-4.555-23.811-14.112-42.51-34.468-42.51h-86.3C22.146,136.873,0,159.019,0,179.383v141.203 c0,10.178,8.246,18.432,18.424,18.432c5.011,0,0,0,12.864,0l7.005,120.424c0,10.83,8.788,19.61,19.618,19.61 c8.12,0,28.398,0,39.227,0c10.83,0,19.61-8.78,19.61-19.61l9.204-238.53h0.463l5.27,23.269c1.744,11.097,11.293,19.28,22.524,19.28 h51.534C215.92,263.461,224.166,255.215,224.166,245.037z M68.026,218.861v-67.123h24.126v67.123l-12.817,15.118L68.026,218.861z">
                        </path>
                        <polygon class="st0"
                            points="190.326,47.47 190.326,200.869 214.452,200.869 214.452,71.595 487.874,71.595 487.874,302.131 214.452,302.131 214.452,273.113 190.326,273.113 190.326,326.256 512,326.256 512,47.47 ">
                        </polygon>
                    </svg>
                    <span class="ml-2 font-bold">Monitores</span>
                </div>
                <div class="flex flex-col items-center sm:flex-row">
                    @forelse ($event->monitors as $monitor)
                    <div class="flex items-center mr-4">
                        <img class="w-8 h-8 bg-black rounded-full mr-2" src="{{ asset($monitor->profile_photo_path) }}"
                            width="32" height="32" alt="Logo" />
                        <span class="truncate text-sm font-medium group-hover:text-slate-800">{{$monitor->name}}</span>
                    </div>
                    @empty
                        <span class="text-red-500">Monitor não cadastrado!</span>
                    @endforelse
                </div>
            </div>
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <button wire:click="createModule()"
                    class="inline-flex items-center justify-center bg-indigo-900 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full">
                    <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 11L12 16" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M14.5 13.5L9.5 13.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M3 9.312C3 4.93757 3.93757 4 8.312 4H9.92963C10.5983 4 11.2228 4.3342 11.5937 4.8906L12.4063 6.1094C12.7772 6.6658 13.4017 7 14.0704 7C15.9647 7 17.8145 7 19.1258 7C20.1807 7 21.0128 7.82095 21.0029 8.8758C21.0013 9.05376 21 9.20638 21 9.312V14.688C21 19.0624 20.0624 20 15.688 20H8.312C3.93757 20 3 19.0624 3 14.688V9.312Z"
                            stroke="#ffffff" stroke-width="2"></path>
                    </svg>
                    <span class="ml-2">Módulos</span>
                </button>
                <button wire:click="createLesson()"
                    class="inline-flex items-center justify-center bg-indigo-900 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full">
                    <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 12C3 16.9706 7.02944 21 12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12Z"
                            stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10 15V9L15 12L10 15Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                    <span class="ml-2">Aulas</span>
                </button>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2 md:col-span-2">
            <div class="text-xl font-bold mb-4 flex items-center">
                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 32 32"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M.63,25.93l7.48,3h0a1,1,0,0,0,.74,0h0L16,26.08l7.11,2.84h0a1,1,0,0,0,.74,0h0l7.48-3A1,1,0,0,0,32,25V17.5a1,1,0,0,0-.07-.35.93.93,0,0,0-.05-.1.86.86,0,0,0-.13-.2l-.08-.08a.78.78,0,0,0-.24-.16s0,0-.05,0h0L24.5,13.82V7a1,1,0,0,0-.07-.35.47.47,0,0,0-.05-.1.86.86,0,0,0-.13-.2l-.08-.08a.78.78,0,0,0-.24-.16s0,0-.05,0h0l-7.5-3a1,1,0,0,0-.74,0l-7.5,3h0s0,0,0,0a.78.78,0,0,0-.24.16.27.27,0,0,0-.07.08.9.9,0,0,0-.14.2.93.93,0,0,0,0,.1A1,1,0,0,0,7.5,7v6.82L.63,16.57h0s0,0-.05,0a.78.78,0,0,0-.24.16.6.6,0,0,0-.08.08.86.86,0,0,0-.13.2l0,.1A1,1,0,0,0,0,17.5V25A1,1,0,0,0,.63,25.93ZM15,24.32l-5.5,2.2V21.18L15,19Zm7.5,2.2L17,24.32V19l5.5,2.2Zm7.5-2.2-5.5,2.2V21.18L30,19ZM28.31,17.5,23.5,19.42,18.69,17.5l4.81-1.92ZM22.5,13.82,17,16V10.68l5.5-2.2ZM16,5.08,20.81,7,16,8.92,11.19,7ZM9.5,8.48l5.5,2.2V16l-5.5-2.2Zm-1,7.1,4.81,1.92L8.5,19.42,3.69,17.5ZM2,19l5.5,2.2v5.34L2,24.32Z">
                    </path>
                </svg>
                <span class="ml-2">MODULOS</span>
            </div>
            @forelse ($event->modules as $module)
                <div x-data="{ open: false }" class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 mb-4 py-4">
                    <div @click="open = !open" class="cursor-pointer">
                        <div class="flex items-center justify-between">
                            <span class="text-xl">{{ $module->name }}</span>
                            <svg x-show="!open" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="open" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            </svg>
                        </div>
                    </div>
                    <div x-show="open" class="transition-all mt-4 duration-300 ease-in-out">
                        <h3 class="font-bold">Título da Aula</h3>
                        <div class="border-t border-gray-200 pb-2">
                            @foreach ($module->lessons as $lesson)
                                <div class="border-t border-gray-200 pb-2 py-2 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                               <path
                                                    d="M3 12C3 4.5885 4.5885 3 12 3C19.4115 3 21 4.5885 21 12C21 19.4115 19.4115 21 12 21C4.5885 21 3 19.4115 3 12Z"
                                                    stroke="#312e81" stroke-width="2"></path>
                                                <path
                                                    d="M10.9 8.8L10.6577 8.66152C10.1418 8.36676 9.5 8.73922 9.5 9.33333L9.5 14.6667C9.5 15.2608 10.1418 15.6332 10.6577 15.3385L10.9 15.2L15.1 12.8C15.719 12.4463 15.719 11.5537 15.1 11.2L10.9 8.8Z"
                                                    stroke="#312e81" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                        </svg>
                                        <a href="{{ route('classroom', ['id' => $lesson->id]) }}"
                                            class="text-blue-500 hover:text-blue-700 ml-1">{{ $lesson->title }}</a>
                                    </div>
                                    <button wire:click="openModalFrequency({{ $lesson->id }})"
                                        class="inline-flex items-center justify-center bg-indigo-900 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full">
                                        Frequencia
                                    </button>
                                    <button wire:click="openModalActivity({{ $lesson->id }})"
                                        class="inline-flex items-center justify-center bg-indigo-900 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full">
                                        Atividade
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <span class="text-red-500">Nenhum Modulo cadastrado</span>
                </div>
            @endforelse
        </div>
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center">
                <svg height="30px" width="30px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                    fill="#000000">
                    <path class="st0"
                        d="M505.837,180.418L279.265,76.124c-7.349-3.385-15.177-5.093-23.265-5.093c-8.088,0-15.914,1.708-23.265,5.093 L6.163,180.418C2.418,182.149,0,185.922,0,190.045s2.418,7.896,6.163,9.627l226.572,104.294c7.349,3.385,15.177,5.101,23.265,5.101 c8.088,0,15.916-1.716,23.267-5.101l178.812-82.306v82.881c-7.096,0.8-12.63,6.84-12.63,14.138c0,6.359,4.208,11.864,10.206,13.618 l-12.092,79.791h55.676l-12.09-79.791c5.996-1.754,10.204-7.259,10.204-13.618c0-7.298-5.534-13.338-12.63-14.138v-95.148 l21.116-9.721c3.744-1.731,6.163-5.504,6.163-9.627S509.582,182.149,505.837,180.418z">
                    </path>
                    <path class="st0"
                        d="M256,346.831c-11.246,0-22.143-2.391-32.386-7.104L112.793,288.71v101.638 c0,22.314,67.426,50.621,143.207,50.621c75.782,0,143.209-28.308,143.209-50.621V288.71l-110.827,51.017 C278.145,344.44,267.25,346.831,256,346.831z">
                    </path>
                </svg>
                <span class="ml-2">ALUNOS</span>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @forelse ($event->inscriptions as $aluno)
                    <div class="flex items-center mb-4">
                        <img class="w-8 h-8 rounded-full" src="{{ $aluno->user->profile_photo_url }}" width="32"
                            height="32" alt="{{ $aluno->user->name }}" />
                        <span
                            class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ $aluno->user->name }}</span>
                    </div>
                @empty
                    <span class="text-red-500">Nenhuma inscrição realizada</span>
                @endforelse
            </div>
        </div>
    </div>
    @if ($isOpenModule)
        @include('livewire.event.module-create')
    @endif
    @if ($isOpenLesson)
        @include('livewire.event.lesson-create')
    @endif
    @if ($isOpenActivity)
        @livewire('event-activity', [$eventId, $lessonId])
    @endif
    @if ($isOpenFrequency)
        @livewire('event-frequency', [$eventId, $lessonId])
    @endif
</div>

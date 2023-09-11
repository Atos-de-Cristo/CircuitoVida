<div>
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">
        <div class="flex justify-center mb-10 pr-3 sm:px-2">
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <a class="block" href="{{route('dashboard')}}">
                <img src="{{ asset('images/logo.png') }}" class="w-25" />
            </a>
        </div>

        <div class="space-y-8">
            <div>
                <ul class="mt-3">
                    <li class="px-3 py-2 rounded-sm mb-0.5 @if (in_array(Request::segment(1), [''])) {{ 'bg-slate-900' }} @endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['dashboard']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['dashboard'])) {{ 'hover:text-slate-200' }} @endif last:mb-0"
                            href="{{ route('dashboard') }} ">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if (in_array(Request::segment(1), [''])) {{ 'text-indigo-500' }}@else{{ 'text-slate-400' }} @endif"
                                            d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                        <path
                                            class="fill-current @if (in_array(Request::segment(1), [''])) {{ 'text-indigo-600' }}@else{{ 'text-slate-600' }} @endif"
                                            d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                        <path
                                            class="fill-current @if (in_array(Request::segment(1), [''])) {{ 'text-indigo-200' }}@else{{ 'text-slate-400' }} @endif"
                                            d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @can('aluno')
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['inscription'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['inscription', 'inscription']) ? 1 : 0 }} }"
                            x-cloak>
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['inscription'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('inscription') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path
                                                class="fill-current @if (in_array(Request::segment(1), ['inscription'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                                d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                            <path
                                                class="fill-current @if (in_array(Request::segment(1), ['inscription'])) {{ 'text-indigo-300' }}@else{{ 'text-slate-400' }} @endif"
                                                d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inscrições</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['activities'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['activities', 'activities']) ? 1 : 0 }} }"
                            x-cloak>
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['activities'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('activities') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center ">
                                        <div
                                            class="@if (in_array(Request::segment(1), ['activities'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-400' }} @endif">
                                            <x-icon-paste />
                                        </div>

                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Atividades</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['attachments'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['attachments', 'attachments']) ? 1 : 0 }} }"
                            x-cloak>
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['attachments'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('attachments') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="@if (in_array(Request::segment(1), ['attachments'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-400' }} @endif">
                                            <x-icon-paperclip />
                                        </div>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Anexos</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Route::currentRouteName(), ['event'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Route::currentRouteName(), ['event']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Route::currentRouteName(), ['event'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('event') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path
                                                class="fill-current @if (in_array(Route::currentRouteName(), ['event'])) {{ 'text-indigo-300' }}@else{{ 'text-slate-400' }} @endif"
                                                d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                            <path
                                                class="fill-current @if (in_array(Route::currentRouteName(), ['event'])) {{ 'text-indigo-600' }}@else{{ 'text-slate-700' }} @endif"
                                                d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                            <path
                                                class="fill-current @if (in_array(Route::currentRouteName(), ['event'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                                d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cursos</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Route::currentRouteName(), ['eventCategory'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Route::currentRouteName(), ['eventCategory']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Route::currentRouteName(), ['eventCategory'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('eventCategory') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg  class="shrink-0 h-6 w-6" viewBox="0 0 512 512">
                                            <path
                                            class="fill-current @if (in_array(Route::currentRouteName(), ['eventCategory'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                            d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Categorias</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Route::currentRouteName(), ['eventInscription'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Route::currentRouteName(), ['eventInscription']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Route::currentRouteName(), ['eventInscription'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('eventInscription') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 512 512">
                                            <path
                                            class="fill-current @if (in_array(Route::currentRouteName(), ['eventInscription'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                            d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inscrições</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['users'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['users', 'user/create']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['users'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('users') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path
                                                class="fill-current @if (in_array(Request::segment(1), ['users'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                                d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                            <path
                                                class="fill-current @if (in_array(Request::segment(1), ['users'])) {{ 'text-indigo-300' }}@else{{ 'text-slate-400' }} @endif"
                                                d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Usuarios</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Route::currentRouteName(), ['relatorios'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['users', 'user/create']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Route::currentRouteName(), ['relatorios'])) {{ 'hover:text-slate-200' }} @endif"
                                >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 384 512">
                                            <path
                                            class="fill-current @if (in_array(Route::currentRouteName(), ['relatorios'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                            d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z"/>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Relatórios</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Route::currentRouteName(), ['audit'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['users', 'user/create']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Route::currentRouteName(), ['audit'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('audit') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 384 512">
                                            <path
                                            class="fill-current @if (in_array(Route::currentRouteName(), ['audit'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                            d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z"/>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Auditoria</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>

        </div>
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

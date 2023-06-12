<div>
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <a class="block" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" class="w-25" />
            </a>
        </div>

        <div class="space-y-8">
            <div>
                <ul class="mt-3">
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['dashboard'])) {{ 'bg-slate-900' }} @endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['dashboard']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['dashboard'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path
                                            class="fill-current @if (in_array(Request::segment(1), ['dashboard'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-400' }} @endif"
                                            d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                        <path
                                            class="fill-current @if (in_array(Request::segment(1), ['dashboard'])) {{ 'text-indigo-600' }}@else{{ 'text-slate-600' }} @endif"
                                            d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                        <path
                                            class="fill-current @if (in_array(Request::segment(1), ['dashboard'])) {{ 'text-indigo-200' }}@else{{ 'text-slate-400' }} @endif"
                                            d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @can('user')
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['users'])) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['users', 'user/create']) ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(1), ['users'])) {{ 'hover:text-slate-200' }} @endif"
                                href="{{ route('inscription') }}">
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
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Inscrições</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcan
                    @cannot('user')
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (Request::is('event*')) {{ 'bg-slate-900' }} @endif"
                            x-data="{ open: {{ Request::is('event*') ? 1 : 0 }} }">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (Request::is('event*')) {{ 'hover:text-slate-200' }} @endif"
                                href="#0" @click.prevent="open = !open">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path
                                                class="fill-current @if (Request::is('event*')) {{ 'text-indigo-300' }}@else{{ 'text-slate-400' }} @endif"
                                                d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                            <path
                                                class="fill-current @if (Request::is('event*')) {{ 'text-indigo-600' }}@else{{ 'text-slate-700' }} @endif"
                                                d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                            <path
                                                class="fill-current @if (Request::is('event*')) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                                d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 @if (Request::is('event*')) {{ 'text-indigo-500' }} @endif">Cursos</span>
                                    </div>
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if (Request::is('event*')) {{ 'rotate-180' }} @endif"
                                            :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-9 mt-1 @if (!Request::is('event*')) {{ 'hidden' }} @endif"
                                    :class="{ 'hidden': !open }">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate "
                                            href="{{ route('event') }}">

                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 @if (Route::is('event')) {{ 'text-indigo-300 ' }} @endif">Gerencial</span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate "
                                            href="{{ route('eventInscription') }}">

                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                                x-bind:class="{ 'text-indigo-300': '{{ Str::contains(url()->current(), 'event/inscription') }}' }">Inscrições</span>

                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if (Route::is('courses.relatorio')) {{ 'text-indigo-500' }} @endif"
                                            href="#0">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Relatório</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                    @endcannot





                </ul>
            </div>

        </div>

    </div>
</div>

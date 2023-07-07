<x-guest-layout>
    <x-authentication-card>

        <x-slot name="logo">
            <x-svg.logo size="w-40 h-40" color="fill-current dark:text-white text-black"/>
        </x-slot>

        <x-validation-errors class="mb-2" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Senha') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
            </div>


            <div class="block mt-2">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembrar-me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}">
                        {{ __('Esqueceu a senha?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Logar') }}
                </x-button>
            </div>
            <div>
                <!-- Footer -->
                <div class="pt-5 mt-6 border-t border-slate-200">
                    <div class="text-md">
                        {{ __('Você não tem uma conta?') }} <a class="font-medium text-indigo-500 hover:text-indigo-600"
                            href="{{ route('register') }}">{{ __('Inscrever-se') }}</a>
                    </div>

                </div>
        </form>

    </x-authentication-card>



    </div>
</x-guest-layout>

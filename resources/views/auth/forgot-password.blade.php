<x-authentication-layout>
    <section class="bg-gray-900 h-screen">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-40"/>
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Recuperação de Conta
                    </h1>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seu email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                            @if ($errors->has('email'))
                                <p id="email-error" class="text-red-600" for="email">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Button type="submit">{{ __('Recuperar') }}</Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-authentication-layout>

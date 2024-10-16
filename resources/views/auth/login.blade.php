<x-guest-layout>

    <div class="flex">

        <div class="flex-1 md:p-40 p-20">

            <h1 class="text-4xl font-extrabold">
                LOGIN
            </h1>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-4 max-w-md">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block my-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="my-4">
                        <a href="{{ route('password.request') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Lupa Password?
                        </a>
                    </div>
                @endif

                <button class="w-full bg-black text-white py-3 uppercase rounded-md">
                    {{ __('Log in') }}
                </button>
            </form>
        </div>
        <div class="flex-1 bg-red-100 hidden md:block rounded-bl-[50px]">

        </div>
    </div>
    <!-- Session Status -->
</x-guest-layout>

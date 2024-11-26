<x-guest-layout>
    <form method="POST" action="{{ route("login") }}" class="mx-auto max-w-md flex-1 bg-white/40 p-8 backdrop-blur">
        <div class="text-center">
            <h1 class="text-4xl font-semibold">Masuk</h1>
            <h1 class="text-2xl">Sistem Informasi</h1>
            <h1>Pelaporan Portofolio Perkuliahan</h1>
        </div>

        <x-auth-session-status class="my-4" :status="session('status')" />

        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="my-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 shadow-sm focus:ring-indigo-500"
                    name="remember"
                />
                <span class="ms-2 text-sm">{{ __("Remember me") }}</span>
            </label>
        </div>

        @if (Route::has("password.request"))
            <div class="my-4">
                <a
                    href="{{ route("password.request") }}"
                    class="hover:text-gray-902 rounded-md text-sm underline focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Lupa Password?
                </a>
            </div>
        @endif

        <button class="w-full rounded-md bg-yellow-600 py-3 uppercase text-white">
            {{ __("Log in") }}
        </button>
    </form>
    <!-- Session Status -->
</x-guest-layout>

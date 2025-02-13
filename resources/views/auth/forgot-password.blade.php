<x-guest-layout>
    <div class="mx-auto max-w-md flex-1 bg-white/50 p-8 backdrop-blur">
        <h1 class="mb-2 text-xl font-semibold">Lupa Password</h1>
        <p class="mb-4">Silahkan masukkan email anda, kami akan mengirimkan link untuk mereset password anda.</p>
        <!-- Session Status -->
        <x-auth-session-status class="my-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
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
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button class="w-full rounded-md bg-yellow-600 py-3 uppercase text-white">Reset Password</button>
            </div>
        </form>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="mx-auto max-w-md flex-1 bg-white/50 p-8 backdrop-blur">
        <div class="mb-4 text-sm text-gray-800">
            Untuk dapat menggunakan semua fitur yang ada dalam sistem ini, anda harus melakukan verifikasi email
            terlebih dahulu. Email anda belum diverifikasi. Silahkan cek email anda untuk verifikasi.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm font-medium text-green-800">Email berhasil dikirim ulang!</div>
        @endif

        <div class="mt-4 flex flex-col items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button class="w-full rounded-md bg-yellow-600 p-2 px-4 uppercase text-white">
                        Kirim Ulang Email Verifikasi
                    </button>
                </div>
            </form>

            <span>atau</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="rounded-md text-sm text-red-600 underline hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>

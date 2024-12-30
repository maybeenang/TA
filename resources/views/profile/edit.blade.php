<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Edit Profil
        </span>

        <div class="">
            <section class="flex flex-col items-center justify-center gap-2 rounded-md md:justify-start">
                <div class="mx-auto h-[100px] w-[100px] rounded-md border border-zinc-400 md:h-[200px] md:w-[200px]">
                    <img
                        src="{{ $user->profile_picture_path }}"
                        alt="{{ $user->name }}"
                        class="h-full w-full rounded-md object-cover"
                    />
                </div>

                <div class="flex justify-end">
                    <form
                        action="{{ route('profile.updatePhoto') }}"
                        method="post"
                        x-ref="profile_picture_form"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <input
                            type="file"
                            name="photo"
                            id="photo"
                            class="hidden"
                            accept="image/*"
                            x-on:change="$refs.profile_picture_form.submit()"
                            x-ref="profile_picture"
                        />
                        <x-button x-on:click.prevent="$refs.profile_picture.click()">Upload Foto Profil</x-button>
                    </form>
                </div>
            </section>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <section class="mt-8 grid grid-cols-2 gap-8 md:flex-row">
                <x-form class="w-full" action="{{ route('profile.update') }}" method="POST">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Profil') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __(' Perbarui informasi profil dan alamat email akun anda. ') }}
                        </p>
                    </header>

                    @csrf
                    @method('PATCH')

                    <x-form.item name="name">
                        <x-form.label>Nama</x-form.label>
                        <x-input
                            x-form:control
                            required
                            placeholder="John Doe"
                            name="name"
                            :value="old('name', $user->name)"
                        />
                        <x-form.message />
                    </x-form.item>
                    <x-form.item name="nip">
                        <x-form.label>NIP</x-form.label>
                        <x-input
                            x-form:control
                            placeholder="1234567890"
                            required
                            name="nip"
                            :value="old('nip', $user?->lecturer?->nip)"
                        />
                        <x-form.message />
                    </x-form.item>

                    <x-form.item name="email">
                        <x-form.label>Email</x-form.label>
                        <x-input
                            type="email"
                            x-form:control
                            required
                            placeholder="johndoe@email.com"
                            name="email"
                            :value="old('email', $user->email)"
                        />
                        <x-form.message />
                    </x-form.item>

                    <livewire:email-notification-switch :user="$user" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="mt-2 text-sm text-gray-800">
                                {{ __('Email anda belum terverifikasi') }}

                                <button
                                    form="send-verification"
                                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    {{ __('Klik disini untuk melakukan verifikasi email') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm font-medium text-green-600">
                                    {{ __('Email verifikasi berhasil dikirim') }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <x-button type="submit">Submit</x-button>
                    </div>
                </x-form>

                <x-form class="w-full" action="{{ route('password.update') }}" method="POST">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Ganti Password') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Hanya isi kolom dibawah ini jika anda ingin mengganti password akun anda') }}
                        </p>
                    </header>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => (show = false), 5000)"
                            class="text-sm text-green-600"
                        >
                            {{ __('Password berhasil diperbarui') }}
                        </p>
                    @endif

                    @csrf
                    @method('PUT')

                    <x-form.item name="current_password">
                        <x-form.label>Password saat ini</x-form.label>
                        <x-input type="password" x-form:control name="current_password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </x-form.item>

                    <x-form.item name="password">
                        <x-form.label>Password Baru</x-form.label>
                        <x-input type="password" x-form:control name="password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </x-form.item>

                    <x-form.item name="password_confirmation">
                        <x-form.label>Konfirmasi Password Baru</x-form.label>
                        <x-input type="password" x-form:control name="password_confirmation" />

                        <x-input-error
                            :messages="$errors->updatePassword->get('password_confirmation')"
                            class="mt-2"
                        />
                    </x-form.item>

                    <div class="flex justify-end">
                        <x-button type="submit">Submit</x-button>
                    </div>
                </x-form>
            </section>
        </div>
    </div>
</x-app-layout>

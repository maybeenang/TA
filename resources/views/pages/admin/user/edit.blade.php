<x-app-layout>
    <div
        class="space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.person-icon />
            Edit Informasi Pengguna
        </span>
        <div class="">
            <section class="flex flex-col items-center justify-center gap-2 rounded-md md:justify-start">
                <div class="mx-auto h-[300px] w-[300px] rounded-md bg-zinc-200 md:h-[200px] md:w-[200px]">
                    <img
                        src="{{ $user->profile_picture_path }}"
                        alt="{{ $user->name }}"
                        class="h-full w-full rounded-md object-cover"
                    />
                </div>
            </section>
            <section class="mx-auto max-w-screen-md rounded-md">
                <x-form class="mx-auto max-w-md" action="{{ route('admin.user.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

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

                    <x-form.item class="flex flex-col space-y-4 rounded-md border p-4">
                        <div class="flex-1 space-y-1">
                            <p class="text-sm font-medium leading-none">Role</p>
                            <p class="text-sm text-muted-foreground">
                                Pilih role yang sesuai dengan pengguna yang anda edit
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($roles as $value => $role)
                                <x-form.item class="">
                                    <x-checkbox
                                        id="{{ $value }}"
                                        x-form:control
                                        name="roles[]"
                                        value="{{ $value }}"
                                        :checked="in_array(
                                            $value,
                                            old('roles', $user->roles->pluck('name')->toArray()),
                                        )"
                                    />
                                    <x-form.label class="whitespace-nowrap">{{ $role }}</x-form.label>
                                </x-form.item>
                            @endforeach
                        </div>
                        <x-form.message />
                    </x-form.item>

                    <x-alert variant="destructive">
                        <x-lucide-triangle-alert class="size-4" />
                        <x-alert.title>Perhatian !</x-alert.title>
                        <x-alert.description>
                            Jika anda tidak ingin mengganti password, silahkan kosongkan field password dan konfirmasi
                            password
                        </x-alert.description>
                    </x-alert>

                    <x-form.item name="password">
                        <x-form.label>Password</x-form.label>
                        <x-input type="password" x-form:control name="password" />
                        <x-form.message />
                    </x-form.item>

                    <x-form.item name="password_confirmation">
                        <x-form.label>Konfirmasi Password</x-form.label>
                        <x-input type="password" x-form:control name="password_confirmation" />
                        <x-form.message />
                    </x-form.item>

                    <x-button type="submit">Submit</x-button>
                </x-form>
            </section>
        </div>
    </div>
</x-app-layout>
